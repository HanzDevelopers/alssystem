<?php
// osy_by_age.php
header('Content-Type: application/json');
include '../../../src/db/db_connection.php';
include 'barangay_district_map.php';

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// SQL query to group OSY by date_encoded (year) and age ranges (15-20, 21-25, 26-30)
$sql = "SELECT YEAR(l.date_encoded) AS year, 
               CASE 
                   WHEN m.age BETWEEN 15 AND 20 THEN '15-20' 
                   WHEN m.age BETWEEN 21 AND 25 THEN '21-25' 
                   WHEN m.age BETWEEN 26 AND 30 THEN '26-30' 
               END AS age_range, 
               COUNT(m.member_id) AS osy_count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE m.age BETWEEN 15 AND 30
        GROUP BY year, age_range";

$result = $conn->query($sql);

$osy_data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $osy_data[] = [
            'year' => $row['year'],
            'age_range' => $row['age_range'],
            'osy_count' => intval($row['osy_count'])
        ];
    }
} else {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

// Close the connection
$conn->close();

// Return the data in JSON format
echo json_encode($osy_data);
