<?php
// Include the district mapping and database connection
$district_mapping = [
    'Tankulan' => 'District 1',
    //... (other mappings)
];

include '../../../src/db/db_connection.php';

// Check for download type and search parameter
$type = isset($_GET['type']) ? $_GET['type'] : 'csv';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Default query
$export_query = "SELECT m.household_members AS name, m.age, l.barangay, l.sitio_zone_purok, l.housenumber, 
                        b.highest_grade_completed, b.currently_attending_school, b.reasons_for_not_attending_school 
                 FROM members_tbl m
                 JOIN location_tbl l ON m.record_id = l.record_id
                 JOIN background_tbl b ON m.member_id = b.member_id
                 WHERE m.age BETWEEN 15 AND 30
                 AND LOWER(b.currently_attending_school) = 'no'";

// Modify query based on search input
if (!empty($search)) {
    // Check if the search term is a valid year
    if (preg_match('/^\d{4}$/', $search)) {
        $export_query .= " AND YEAR(l.date_encoded) = '$search'";
    } else {
        $export_query .= " AND (m.age LIKE '%$search%' OR l.barangay LIKE '%$search%' 
                              OR LOWER(b.currently_attending_school) LIKE '%$search%' 
                              OR LOWER(b.reasons_for_not_attending_school) LIKE '%$search%')";
    }
} else {
    // If no search term is provided, filter by the current year
    $current_year = date('Y');
    $export_query .= " AND YEAR(l.date_encoded) = $current_year";
}

// Order the results by age
$export_query .= " ORDER BY m.age"; // Added line to order by age

// Fetch data
$result = $conn->query($export_query);

// Check if results are found
if ($result->num_rows > 0) {
    // Prepare download headers
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
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="members_data.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Begin outputting the Excel file
        echo "<table>";
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
