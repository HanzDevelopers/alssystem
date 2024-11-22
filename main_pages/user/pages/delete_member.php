<?php
include '../../../src/db/db_connection.php';

session_start();
if (!isset($_SESSION['username'])) {
    die("Unauthorized access.");
}

if (!isset($conn)) {
    die("Database connection error.");
}

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$member_id = $_GET['member_id'];
$deleted_by = $_SESSION['username']; // Get the username of the logged-in user

if (!filter_var($member_id, FILTER_VALIDATE_INT)) {
    die("Invalid member ID.");
}

$conn->begin_transaction();

try {
    // Fetch data from members_tbl
    $stmt = $conn->prepare("SELECT * FROM members_tbl WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $member_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$member_data) {
        throw new Exception("Member not found in members_tbl.");
    }

    // Fetch data from background_tbl
    $stmt = $conn->prepare("SELECT * FROM background_tbl WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $background_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$background_data) {
        throw new Exception("Background not found for member.");
    }

    // Fetch related location data using record_id
    $stmt = $conn->prepare("SELECT * FROM location_tbl WHERE record_id = ?");
    $stmt->bind_param("i", $member_data['record_id']);
    $stmt->execute();
    $location_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$location_data) {
        throw new Exception("Location not found for record.");
    }

    // Insert into archive_tbl
    $stmt = $conn->prepare("
    INSERT INTO archive_tbl (
        record_id, member_id, encoder_name, date_encoded, province, city_municipality, barangay, 
        sitio_zone_purok, housenumber, estimated_family_income, notes, household_members, 
        relationship_to_head, birthdate, age, gender, civil_status, person_with_disability, 
        ethnicity, religion, highest_grade_completed, currently_attending_school, 
        grade_level_enrolled, reasons_for_not_attending_school, 
        can_read_write_simple_messages_inanylanguage, occupation, work, status, deleted_by, deletion_timestamp
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
    )
");

// Ensure all variables match the correct types
$stmt->bind_param(
    "iisssssssdssssissssssssssssss",
    $location_data['record_id'],                  // i
    $member_data['member_id'],                   // i
    $location_data['encoder_name'],              // s
    $location_data['date_encoded'],              // s
    $location_data['province'],                  // s
    $location_data['city_municipality'],         // s
    $location_data['barangay'],                  // s
    $location_data['sitio_zone_purok'],          // s
    $location_data['housenumber'],               // s
    $location_data['estimated_family_income'],   // d (decimal)
    $location_data['notes'],                     // s
    $member_data['household_members'],           // s
    $member_data['relationship_to_head'],        // s
    $member_data['birthdate'],                   // s
    $member_data['age'],                         // i
    $member_data['gender'],                      // s
    $member_data['civil_status'],                // s
    $member_data['person_with_disability'],      // s
    $member_data['ethnicity'],                   // s
    $member_data['religion'],                    // s
    $background_data['highest_grade_completed'], // s
    $background_data['currently_attending_school'], // s
    $background_data['grade_level_enrolled'],    // s
    $background_data['reasons_for_not_attending_school'], // s
    $background_data['can_read_write_simple_messages_inanylanguage'], // s
    $background_data['occupation'],             // s
    $background_data['work'],                   // s
    $background_data['status'],                 // s
    $deleted_by                                 // s
);

$stmt->execute();
$stmt->close();


    // Delete records from background_tbl
    $stmt = $conn->prepare("DELETE FROM background_tbl WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->close();

    // Delete records from members_tbl
    $stmt = $conn->prepare("DELETE FROM members_tbl WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    echo "<script>
        alert('Member archived successfully');
        window.location.href = 'dashboard.php';
    </script>";
} catch (Exception $e) {
    $conn->rollback();

    error_log($e->getMessage(), 3, '../../../logs/errors.log'); // Log error
    echo "<script>
        alert('Error archiving member.');
        window.location.href = 'dashboard.php';
    </script>";
}
?>
