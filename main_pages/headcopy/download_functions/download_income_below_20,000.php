<?php
include '../../../src/db/db_connection.php';

// Get the download type (csv or excel)
$type = isset($_GET['type']) ? $_GET['type'] : 'csv';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query based on the search term
$sql = "
    SELECT 
        l.barangay AS Barangay,
        l.housenumber AS HouseNumber,
        l.estimated_family_income AS EstimatedIncome,
        COUNT(m.member_id) AS HouseholdMembers
    FROM 
        location_tbl AS l
    JOIN 
        members_tbl AS m ON l.record_id = m.record_id
    WHERE 
        l.estimated_family_income < 20000
";

if (!empty($searchTerm)) {
    $sql .= " AND (l.barangay LIKE '%$searchTerm%' OR l.housenumber LIKE '%$searchTerm%')";
}

$sql .= " 
    GROUP BY 
        l.barangay, l.housenumber
    ORDER BY 
        l.barangay ASC
";

$result = $conn->query($sql);

if ($type === 'csv') {
    // Download as CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="households_below_20000.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Barangay', 'House Number', 'Estimated Income', 'Household Members'));

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
} elseif ($type === 'excel') {
    // Download as Excel (simple TSV format for now)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="households_below_20000.xls"');

    echo "Barangay\tHouse Number\tEstimated Income\tHousehold Members\n";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo implode("\t", $row) . "\n";
        }
    }
}
?>
