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

// Get the file type (Excel or CSV)
$file_type = isset($_GET['type']) ? $_GET['type'] : 'csv';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Construct search query
$search_query = '';
if (!empty($search)) {
    $search_query = " AND (m.household_members LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
                        OR l.housenumber LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
                        OR l.date_encoded LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'
                        OR (CASE 
                            WHEN l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
                            WHEN l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') THEN 'District 2'
                            WHEN l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') THEN 'District 3'
                            WHEN l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') THEN 'District 4'
                            ELSE 'Unknown District'
                        END) LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
}

// Query to get filtered data based on the user's district
$query = "SELECT 
            CASE 
                WHEN l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
                WHEN l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') THEN 'District 2'
                WHEN l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') THEN 'District 3'
                WHEN l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') THEN 'District 4'
                ELSE 'Unknown District'
            END AS district,
            l.housenumber,
            l.sitio_zone_purok,
            m.household_members,
            l.estimated_family_income
          FROM 
            location_tbl l
          JOIN 
            members_tbl m ON l.record_id = m.record_id
          JOIN 
            background_tbl b ON m.member_id = b.member_id
          WHERE 
            b.currently_attending_school IN ('No', 'no', 'NO')
            AND m.age BETWEEN 15 AND 30
            AND ($barangay_condition_sql)
            $search_query";

$result = $conn->query($query);

// Output the data according to the file type (CSV or Excel)
if ($file_type === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="district_osy.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('District', 'House Number', 'Sitio/Zone/Purok', 'Household Members', 'Estimated Family Income'));

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
} elseif ($file_type === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="district_osy.xls"');

    echo "District\tHouse Number\tSitio/Zone/Purok\tHousehold Members\tEstimated Family Income\n";

    while ($row = $result->fetch_assoc()) {
        echo "{$row['district']}\t{$row['housenumber']}\t{$row['sitio_zone_purok']}\t{$row['household_members']}\t{$row['estimated_family_income']}\n";
    }

    exit;
}
?>
