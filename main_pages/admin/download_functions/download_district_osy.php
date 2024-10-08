<?php
include '../../../src/db/db_connection.php';

// Get the file type (Excel or CSV)
$file_type = isset($_GET['type']) ? $_GET['type'] : 'csv';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Construct search query
$search_query = '';
if (!empty($search)) {
    $search_query = " AND (m.household_members LIKE '%$search%' 
                        OR l.housenumber LIKE '%$search%' 
                        OR l.date_encoded LIKE '%$search%'
                        OR (CASE 
                            WHEN l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
                            WHEN l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') THEN 'District 2'
                            WHEN l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') THEN 'District 3'
                            WHEN l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') THEN 'District 4'
                            ELSE 'Unknown District'
                        END) LIKE '%$search%')";
}

// Query to get filtered data
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
