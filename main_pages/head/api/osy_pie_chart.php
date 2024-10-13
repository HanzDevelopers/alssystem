<?php
// osy_pie_chart.php
header('Content-Type: application/json');
include '../../../src/db/db_connection.php';
include 'barangay_district_map.php';

// Get the current year
$current_year = date("Y");

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// SQL Query to fetch barangay and count of OSY (age 15-30) for the current year, who are not attending school
$sql = "SELECT l.barangay, COUNT(m.member_id) AS osy_count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        JOIN background_tbl b ON m.member_id = b.member_id
        WHERE m.age BETWEEN 15 AND 30
        AND b.currently_attending_school IN ('No', 'no', 'NO')
        AND YEAR(l.date_encoded) = $current_year
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

// Calculate basic statistics
$mean = array_sum($counts) / count($counts);

// Standard Deviation calculation
function standard_deviation($counts) {
    $mean = array_sum($counts) / count($counts);
    $sum = 0;
    foreach ($counts as $count) {
        $sum += pow($count - $mean, 2);
    }
    return sqrt($sum / count($counts));
}

$std_dev = standard_deviation($counts);

// Add statistics to the response
echo json_encode([
    'districts' => $districts,
    'counts' => $counts,
    'statistics' => [
        'mean' => $mean,
        'standard_deviation' => $std_dev
    ]
]);
?>
