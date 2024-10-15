<?php 
include '../../../src/db/db_connection.php';
session_start();

// Check if the user is logged in and retrieve the user's district
if (!isset($_SESSION['username']) || !isset($_SESSION['district'])) {
    header('Location: ../../../index.php'); // Redirect to login if not authenticated
    exit();
}

$logged_in_district = $_SESSION['district'];

// District Mapping
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
    'Guilang2' => 'District 4',
];

// Get the search query and format
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$format = isset($_GET['format']) ? $_GET['format'] : '';

// Prepare the barangay condition based on the logged-in user's district
$barangay_conditions = [];
foreach ($district_mapping as $barangay => $mapped_district) {
    if ($mapped_district === $logged_in_district) {
        $barangay_conditions[] = "location_tbl.barangay = '" . mysqli_real_escape_string($conn, $barangay) . "'";
    }
}
$barangay_condition_sql = implode(' OR ', $barangay_conditions);

// Base SQL query for fetching the data
$sql = "SELECT 
            members_tbl.household_members AS Name, 
            members_tbl.age, 
            location_tbl.barangay AS Address, 
            background_tbl.highest_grade_completed AS Highest_Grade,
            background_tbl.currently_attending_school,
            background_tbl.work,
            background_tbl.status AS Interested_in_ALS
        FROM members_tbl
        JOIN background_tbl ON members_tbl.member_id = background_tbl.member_id
        JOIN location_tbl ON members_tbl.record_id = location_tbl.record_id
        AND background_tbl.status IN ('Yes', 'YES', 'yes')
        AND YEAR(location_tbl.date_encoded) = YEAR(CURDATE())
        AND ($barangay_condition_sql)";

// Fetch data based on the search query or all data if no search query is provided
if (empty($search_query)) {
    // No search query provided; fetch all data for the logged-in district
    $sql .= " ORDER BY members_tbl.age ASC";
} else {
    // Search query provided; fetch filtered data
    $sql .= " AND (members_tbl.household_members LIKE '%$search_query%' 
                OR members_tbl.age LIKE '%$search_query%' 
                OR location_tbl.barangay LIKE '%$search_query%')
              ORDER BY members_tbl.age ASC";
}

$result = mysqli_query($conn, $sql);

// Prepare the data for download
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Handle CSV download
if ($format === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Age', 'District', 'Address', 'Highest Grade', 'Currently Attending School', 'Work', 'Interested in ALS']);
    
    foreach ($data as $row) {
        $district = ''; 
        foreach ($district_mapping as $barangay => $mapped_district) {
            if ($row['Address'] == $barangay) {
                $district = $mapped_district;
                break;
            }
        }
        fputcsv($output, [
            $row['Name'],
            $row['age'],
            $district,
            $row['Address'],
            $row['Highest_Grade'],
            $row['currently_attending_school'],
            $row['work'],
            $row['Interested_in_ALS'],
        ]);
    }
    fclose($output);
    exit();
}

// Handle Excel download
if ($format === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="data.xls"');
    
    // Generate HTML for Excel
    echo '<table border="1">';
    echo '<tr><th>Name</th><th>Age</th><th>District</th><th>Address</th><th>Highest Grade</th><th>Currently Attending School</th><th>Work</th><th>Interested in ALS</th></tr>';
    
    foreach ($data as $row) {
        $district = ''; 
        foreach ($district_mapping as $barangay => $mapped_district) {
            if ($row['Address'] == $barangay) {
                $district = $mapped_district;
                break;
            }
        }
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['age']) . '</td>';
        echo '<td>' . htmlspecialchars($district) . '</td>';
        echo '<td>' . htmlspecialchars($row['Address']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Highest_Grade']) . '</td>';
        echo '<td>' . htmlspecialchars($row['currently_attending_school']) . '</td>';
        echo '<td>' . htmlspecialchars($row['work']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Interested_in_ALS']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    exit();
}
?>
