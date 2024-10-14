<?php 
// osy_pie_chart.php
header('Content-Type: application/json');
include '../../../src/db/db_connection.php';

// Get the current year
$current_year = date("Y");

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Start session to get the logged-in user's district
session_start();
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Query to get the user's district from user_tbl
$user_sql = "SELECT district FROM user_tbl WHERE user_id = '$user_id'";
$user_result = $conn->query($user_sql);

if ($user_result && $user_result->num_rows > 0) {
    $user_row = $user_result->fetch_assoc();
    $user_district = $user_row['district'];
} else {
    echo json_encode(['error' => 'User district not found']);
    exit();
}

// Barangay to District Mapping
$district_mapping = [
    // District 1
    'Tankulan' => 'District 1',
    'Diklum' => 'District 1',
    'San Miguel' => 'District 1',
    'Ticala' => 'District 1',
    'Lingion' => 'District 1',

    // District 2
    'Alae' => 'District 2',
    'Damilag' => 'District 2',
    'Mambatangan' => 'District 2',
    'Mantibugao' => 'District 2',
    'Minsuro' => 'District 2',
    'Lunocan' => 'District 2',

    // District 3
    'Agusan canyon' => 'District 3',
    'Mampayag' => 'District 3',
    'Dahilayan' => 'District 3',
    'Sankanan' => 'District 3',
    'Kalugmanan' => 'District 3',
    'Lindaban' => 'District 3',

    // District 4
    'Dalirig' => 'District 4',
    'Maluko' => 'District 4',
    'Santiago' => 'District 4',
    'Guilang2' => 'District 4',
];

// Prepare an array to hold barangays belonging to the user's district
$barangays_in_user_district = array_keys(array_filter($district_mapping, function($district) use ($user_district) {
    return $district === $user_district;
}));

// SQL Query to fetch barangay and count of OSY (age 15-30) for the current year, who are not attending school
$sql = "SELECT l.barangay, COUNT(m.member_id) AS osy_count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        JOIN background_tbl b ON m.member_id = b.member_id
        WHERE m.age BETWEEN 15 AND 30
        AND b.currently_attending_school IN ('No', 'no', 'NO')
        AND YEAR(l.date_encoded) = $current_year
        AND l.barangay IN ('" . implode("', '", $barangays_in_user_district) . "')
        GROUP BY l.barangay";

$result = $conn->query($sql);

$barangay_counts = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $barangay = $row['barangay'];
            $barangay_counts[$barangay] = intval($row['osy_count']);
        }
    }
} else {
    // Handle query error
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$conn->close();

// Prepare data for JSON response
$barangays = array_keys($barangay_counts);  // Barangay names for the legend
$counts = array_values($barangay_counts);  // Corresponding OSY counts

// Calculate basic statistics
$mean = count($counts) > 0 ? array_sum($counts) / count($counts) : 0;

// Standard Deviation calculation
function standard_deviation($counts) {
    if (count($counts) === 0) return 0; // Avoid division by zero
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
    'barangays' => $barangays,  // Barangay names for the legend
    'counts' => $counts,        // Corresponding OSY counts
    'statistics' => [
        'mean' => $mean,
        'standard_deviation' => $std_dev
    ]
]);

?>
