<?php
include '../../../src/db/db_connection.php';

// Get the requested format and search term
$format = isset($_GET['format']) ? $_GET['format'] : 'csv';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query with filtering
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
    WHERE /*l.encoder_name LIKE '%$search%' */
       m.household_members LIKE '%$search%' 
       OR m.birthdate LIKE '%$search%' 
       OR m.age LIKE '%$search%' 
       OR CONCAT(l.province, ', ', l.city_municipality, ', ', l.barangay) LIKE '%$search%'
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
