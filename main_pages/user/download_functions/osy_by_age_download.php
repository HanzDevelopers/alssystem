<?php 
session_start();
if (!isset($_SESSION['district'])) {
    die("District not set in session.");
}

$type = isset($_GET['type']) ? $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Get the search query from GET request

$district_mapping = [
    'Tankulan' => 'District 1',
    'Diklum' => 'District 1',
    'San Miguel' => 'District 1',
    'Ticala' => 'District 1',
    'Lingion' => 'District 1',
    'Alae' => 'District 2',
    'Damilag' => 'District 2',
    'Mambatangan' => 'District 2',
    'Mantibugao' => 'District 2',
    'Minsuro' => 'District 2',
    'Lunocan' => 'District 2',
    'Agusan canyon' => 'District 3',
    'Mampayag' => 'District 3',
    'Dahilayan' => 'District 3',
    'Sankanan' => 'District 3',
    'Kalugmanan' => 'District 3',
    'Lindaban' => 'District 3',
    'Dalirig' => 'District 4',
    'Maluko' => 'District 4',
    'Santiago' => 'District 4',
    'Guilang2' => 'District 4'
];

include '../../../src/db/db_connection.php';

$user_id = $_SESSION['user_id']; 
$user_district = '';

$user_query = "SELECT district FROM user_tbl WHERE user_id = '$user_id'";
$user_result = $conn->query($user_query);

if ($user_result->num_rows > 0) {
    $user_row = $user_result->fetch_assoc();
    $user_district = $user_row['district'];
}

$barangays_in_user_district = [];
foreach ($district_mapping as $barangay => $district) {
    if ($district === $user_district) {
        $barangays_in_user_district[] = $barangay;
    }
}

$barangay_list = "'" . implode("','", $barangays_in_user_district) . "'";

// Construct the export query with search functionality
$export_query = "SELECT m.household_members AS name, m.age, l.barangay, l.sitio_zone_purok, l.housenumber, 
                        b.highest_grade_completed, b.currently_attending_school, b.reasons_for_not_attending_school 
                 FROM members_tbl m
                 JOIN location_tbl l ON m.record_id = l.record_id
                 JOIN background_tbl b ON m.member_id = b.member_id
                 WHERE m.age BETWEEN 15 AND 30
                 AND LOWER(b.currently_attending_school) = 'no'
                 AND l.barangay IN ($barangay_list)";

if (!empty($search)) {
    if (preg_match('/^\d{4}$/', $search)) {
        $export_query .= " AND YEAR(l.date_encoded) = '$search'";
    } else {
        $export_query .= " AND (m.age LIKE '%$search%' OR l.barangay LIKE '%$search%' 
                              OR LOWER(b.currently_attending_school) LIKE '%$search%' 
                              OR LOWER(b.reasons_for_not_attending_school) LIKE '%$search%')";
    }
} else {
    $current_year = date('Y');
    $export_query .= " AND YEAR(l.date_encoded) = $current_year";
}

$export_query .= " ORDER BY m.age";

$result = $conn->query($export_query);

if ($result->num_rows > 0) {
    if ($type === 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="members_data.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Age', 'District', 'Address', 'Highest Grade/Year Completed', 'Currently Attending School', 'Interested in ALS']);
        
        while ($row = $result->fetch_assoc()) {
            $district = isset($district_mapping[$row['barangay']]) ? $district_mapping[$row['barangay']] : 'Unknown';
            fputcsv($output, [
                $row['name'], 
                $row['age'], 
                $district, 
                $row['sitio_zone_purok'] . ', ' . $row['housenumber'], 
                $row['highest_grade_completed'], 
                $row['currently_attending_school'], 
                stripos($row['reasons_for_not_attending_school'], 'ALS') !== false ? 'Yes' : 'No'
            ]);
        }
        fclose($output);
    } elseif ($type === 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="members_data.xls"');
        
        echo "<table border='1'>";
        echo "<tr><th>Name</th><th>Age</th><th>District</th><th>Address</th><th>Highest Grade/Year Completed</th><th>Currently Attending School</th><th>Interested in ALS</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            $district = isset($district_mapping[$row['barangay']]) ? $district_mapping[$row['barangay']] : 'Unknown';
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['age']) . "</td>
                    <td>" . htmlspecialchars($district) . "</td>
                    <td>" . htmlspecialchars($row['sitio_zone_purok'] . ', ' . $row['housenumber']) . "</td>
                    <td>" . htmlspecialchars($row['highest_grade_completed']) . "</td>
                    <td>" . htmlspecialchars($row['currently_attending_school']) . "</td>
                    <td>" . (stripos($row['reasons_for_not_attending_school'], 'ALS') !== false ? 'Yes' : 'No') . "</td>
                  </tr>";
        }
        echo "</table>";
    }
} else {
    echo "No data found.";
}

$conn->close();
?>
