<?php
include '../../../src/db/db_connection.php';

// Start the session to access the logged-in user's district
session_start();
if (!isset($_SESSION['district'])) {
    die("District not set in session.");
}

// Get the logged-in user's district
$logged_in_district = $_SESSION['district'];

// Define the barangay to district mapping
$district_mapping = [
    'District 1' => ['Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion'],
    'District 2' => ['Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan'],
    'District 3' => ['Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban'],
    'District 4' => ['Dalirig', 'Maluko', 'Santiago', 'Guilang2'],
];

// Create a condition based on the district mapping
$barangay_conditions = [];
foreach ($district_mapping[$logged_in_district] as $barangay) {
    $barangay_conditions[] = "l.barangay = '" . mysqli_real_escape_string($conn, $barangay) . "'";
}

$barangay_condition_sql = implode(' OR ', $barangay_conditions);

// Get the requested format and search term
$format = isset($_GET['format']) ? $_GET['format'] : 'csv';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query with filtering for the logged-in user's district
$sql = "
    SELECT 
        l.encoder_name, 
        l.date_encoded, 
        l.province, 
        l.city_municipality, 
        l.barangay, 
        l.sitio_zone_purok, 
        l.housenumber, 
        l.estimated_family_income, 
        l.notes,
        m.household_members, 
        m.relationship_to_head, 
        m.birthdate, 
        m.age, 
        m.gender, 
        m.civil_status, 
        m.person_with_disability, 
        m.ethnicity, 
        m.religion, 
        b.highest_grade_completed, 
        b.currently_attending_school, 
        b.grade_level_enrolled, 
        b.reasons_for_not_attending_school, 
        b.can_read_write_simple_messages_inanylanguage, 
        b.occupation, 
        b.work, 
        b.status
    FROM members_tbl m 
    JOIN location_tbl l ON m.record_id = l.record_id
    JOIN background_tbl b ON m.member_id = b.member_id
    WHERE (m.household_members LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
        OR m.birthdate LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
        OR m.age LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
        OR CONCAT(l.province, ', ', l.city_municipality, ', ', l.barangay) LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')
        AND ($barangay_condition_sql)
";

// Execute the query
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Handle CSV export
    if ($format == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="household_records.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, array_keys($data[0])); // Headers
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }
    
    // Handle Excel export
    elseif ($format == 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="household_records.xls"');
        echo '<table border="1">';
        echo '<tr>';
        foreach (array_keys($data[0]) as $key) {
            echo "<th>{$key}</th>";
        }
        echo '</tr>';
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    
} else {
    echo "No records found.";
}
?>
