<?php
// osy_pie_chart.php
header('Content-Type: application/json');
include '../../../src/db/db_connection.php';
include 'barangay_district_map.php';

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// SQL Query to fetch barangay and count of OSY (age 15-30)
$sql = "SELECT l.barangay, COUNT(m.member_id) AS osy_count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE m.age BETWEEN 15 AND 30
        GROUP BY l.barangay";

$result = $conn->query($sql);

$district_counts = [
    'District 1' => 0,
    'District 2' => 0,
    'District 3' => 0,
    'District 4' => 0
];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $district = getDistrict($row['barangay']);
            if (array_key_exists($district, $district_counts)) {
                $district_counts[$district] += intval($row['osy_count']);
            }
        }
    }
} else {
    // Handle query error
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$conn->close();

// Prepare data for JSON response
$districts = array_keys($district_counts);
$counts = array_values($district_counts);

echo json_encode([
    'districts' => $districts,
    'counts' => $counts
]);
