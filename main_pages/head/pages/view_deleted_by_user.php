<?php
include '../../../src/db/db_connection.php';

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['district'])) {
    die("Unauthorized access.");
}

if (!isset($conn)) {
    die("Database connection error.");
}

$deleted_by_user = $_SESSION['username'];
$user_district = $_SESSION['district'];

// Barangay-to-district mapping
$district_mapping = [
    'District 1' => ['Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion'],
    'District 2' => ['Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan'],
    'District 3' => ['Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban'],
    'District 4' => ['Dalirig', 'Maluko', 'Santiago', 'Guilang2']
];

// Get barangays for the logged-in user's district
$user_barangays = $district_mapping[$user_district] ?? [];

if (empty($user_barangays)) {
    die("Invalid district for user.");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Prepare the query to fetch archived data for the user's barangays
    $placeholders = implode(',', array_fill(0, count($user_barangays), '?'));
    $query = "
        SELECT 
            record_id, member_id, encoder_name, date_encoded, deleted_by, deletion_timestamp, 
            household_members, relationship_to_head, birthdate, age, 
            barangay, currently_attending_school, grade_level_enrolled
        FROM archive_tbl
        WHERE LOWER(barangay) IN ($placeholders)
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('s', count($user_barangays)), ...array_map('strtolower', $user_barangays));
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching archive data: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restore'])) {
        $record_id = $_POST['record_id'];
        $member_id = $_POST['member_id'];
        try {
            $stmt = $conn->prepare("SELECT * FROM archive_tbl WHERE record_id = ? AND member_id = ?");
            $stmt->bind_param("ii", $record_id, $member_id);
            $stmt->execute();
            $archived_data = $stmt->get_result()->fetch_assoc();

            // Restore data to original tables
            $stmt = $conn->prepare("
                INSERT INTO location_tbl (encoder_name, date_encoded, province, city_municipality, barangay, sitio_zone_purok, housenumber, estimated_family_income, notes)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sssssssss", $archived_data['encoder_name'], $archived_data['date_encoded'], $archived_data['province'], $archived_data['city_municipality'], $archived_data['barangay'], $archived_data['sitio_zone_purok'], $archived_data['housenumber'], $archived_data['estimated_family_income'], $archived_data['notes']);
            $stmt->execute();

            $stmt = $conn->prepare("
                INSERT INTO members_tbl (member_id, record_id, household_members, relationship_to_head, birthdate, age, gender, civil_status, person_with_disability, ethnicity, religion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("iisssisssss", $member_id, $record_id, $archived_data['household_members'], $archived_data['relationship_to_head'], $archived_data['birthdate'], $archived_data['age'], $archived_data['gender'], $archived_data['civil_status'], $archived_data['person_with_disability'], $archived_data['ethnicity'], $archived_data['religion']);
            $stmt->execute();

            $stmt = $conn->prepare("
                INSERT INTO background_tbl (member_id, highest_grade_completed, currently_attending_school, grade_level_enrolled, reasons_for_not_attending_school, can_read_write_simple_messages_inanylanguage, occupation, work, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("issssssss", $member_id, $archived_data['highest_grade_completed'], $archived_data['currently_attending_school'], $archived_data['grade_level_enrolled'], $archived_data['reasons_for_not_attending_school'], $archived_data['can_read_write_simple_messages_inanylanguage'], $archived_data['occupation'], $archived_data['work'], $archived_data['status']);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM archive_tbl WHERE record_id = ? AND member_id = ?");
            $stmt->bind_param("ii", $record_id, $member_id);
            $stmt->execute();

            header("Location: {$_SERVER['PHP_SELF']}?message=restore_success");
        } catch (Exception $e) {
            header("Location: {$_SERVER['PHP_SELF']}?message=restore_error");
        }
    }

    if (isset($_POST['delete'])) {
        $record_id = $_POST['record_id'];
        $member_id = $_POST['member_id'];
        try {
            $stmt = $conn->prepare("DELETE FROM archive_tbl WHERE record_id = ? AND member_id = ?");
            $stmt->bind_param("ii", $record_id, $member_id);
            $stmt->execute();

            header("Location: {$_SERVER['PHP_SELF']}?message=delete_success");
        } catch (Exception $e) {
            header("Location: {$_SERVER['PHP_SELF']}?message=delete_error");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Archived Records in Your District</h2>
    
    <!-- Alert Messages -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-<?= $_GET['message'] === 'restore_success' || $_GET['message'] === 'delete_success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= $_GET['message'] === 'restore_success' ? 'Record successfully restored.' : ($_GET['message'] === 'delete_success' ? 'Record successfully deleted.' : 'An error occurred.') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Encoder Name</th>
                <th>Date Encoded</th>
                <th>Deleted By</th>
                <th>Date Deleted</th>
                <th>Name</th>
                <th>Relationship to Head</th>
                <th>Birthdate</th>
                <th>Age</th>
                <th>Barangay</th>
                <th>Currently Attending School</th>
                <th>Grade Level Enrolled</th>
                <th>Permanent Deletion Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php $permanent_deletion_date = date('Y-m-d', strtotime($row['deletion_timestamp'] . ' + 30 days')); ?>
                    <tr>
                        <td><?= htmlspecialchars($row['encoder_name']) ?></td>
                        <td><?= htmlspecialchars($row['date_encoded']) ?></td>
                        <td><?= htmlspecialchars($row['deleted_by']) ?></td>
                        <td><?= htmlspecialchars($row['deletion_timestamp']) ?></td>
                        <td><?= htmlspecialchars($row['household_members']) ?></td>
                        <td><?= htmlspecialchars($row['relationship_to_head']) ?></td>
                        <td><?= htmlspecialchars($row['birthdate']) ?></td>
                        <td><?= htmlspecialchars($row['age']) ?></td>
                        <td><?= htmlspecialchars($row['barangay']) ?></td>
                        <td><?= htmlspecialchars($row['currently_attending_school']) ?></td>
                        <td><?= htmlspecialchars($row['grade_level_enrolled']) ?></td>
                        <td><?= htmlspecialchars($permanent_deletion_date) ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline;" onsubmit="return confirmRestore();">
                                <input type="hidden" name="record_id" value="<?= $row['record_id'] ?>">
                                <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                                <button type="submit" name="restore" class="btn btn-success btn-sm">Restore</button>
                            </form>
                            <form action="" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                <input type="hidden" name="record_id" value="<?= $row['record_id'] ?>">
                                <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="13" class="text-center">No archived records found in your district.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    function confirmRestore() {
        return confirm("Are you sure you want to restore this record?");
    }

    function confirmDelete() {
        return confirm("Are you sure you want to permanently delete this record?");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
