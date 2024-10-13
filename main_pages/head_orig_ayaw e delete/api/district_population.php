<?php
// district_population.php
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

// Updated SQL Query to count household members for the current year based on comma-separated names
$sql = "SELECT 
            l.barangay, 
            SUM(
                LENGTH(m.household_members) - LENGTH(REPLACE(m.household_members, ',', '')) + 1
            ) AS total_population
        FROM 
            members_tbl m
        JOIN 
            location_tbl l 
            ON m.record_id = l.record_id
        WHERE 
            YEAR(l.date_encoded) = $current_year
        GROUP BY 
            l.barangay";

$result = $conn->query($sql);

$district_population = [
    'District 1' => 0,
    'District 2' => 0,
    'District 3' => 0,
    'District 4' => 0,
    'Unknown District' => 0 // To capture any unmapped barangays
];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $barangay = $row['barangay'];
            $total_population = $row['total_population'];
            $district = getDistrict($barangay);

            if (array_key_exists($district, $district_population)) {
                $district_population[$district] += intval($total_population);
            } else {
                $district_population['Unknown District'] += intval($total_population);
                // Log unmapped barangays for debugging
                error_log("Unmapped Barangay: $barangay with population: $total_population");
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
$districts = array_keys($district_population);
$counts = array_values($district_population);

// Optionally, remove 'Unknown District' from the response if not needed
$index = array_search('Unknown District', $districts);
if ($index !== false) {
    unset($districts[$index]);
    unset($counts[$index]);
}

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
