<?php
// osy_pie_chart.php
header('Content-Type: application/json');
include '../../../src/db/db_connection.php';
session_start();  // Start session to get logged-in user info

// Get the current year
$current_year = date("Y");

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get logged-in user's district from the session (assuming it's stored during login)
$user_district = $_SESSION['district'];

// Barangay-district mapping
$district_barangays = [
    'District 1' => ['Tankulan', 'Diklum', 'Diclum', 'San Miguel', 'Ticala', 'Lingion'],
    'District 2' => ['Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan'],
    'District 3' => ['Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban'],
    'District 4' => ['Dalirig', 'Maluko', 'Santiago', 'Guilang2']
];

// Ensure the user's district is valid
if (!array_key_exists($user_district, $district_barangays)) {
    echo json_encode(['error' => 'Invalid district for the logged-in user']);
    exit();
}

// Get the barangays for the user's district
$user_barangays = $district_barangays[$user_district];

// SQL Query to fetch barangay and count of OSY (age 15-30) for the current year, who are not attending school, within the user's district
$sql = "SELECT l.barangay, COUNT(m.member_id) AS osy_count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        JOIN background_tbl b ON m.member_id = b.member_id
        WHERE m.age BETWEEN 15 AND 30
        AND b.currently_attending_school IN ('No', 'no', 'NO')
        AND l.barangay IN ('" . implode("','", $user_barangays) . "')
        AND YEAR(l.date_encoded) = $current_year
        GROUP BY l.barangay";

$result = $conn->query($sql);

// Initialize an array to store the counts per barangay
$barangay_counts = array_fill_keys($user_barangays, 0);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $barangay = $row['barangay'];
            if (array_key_exists($barangay, $barangay_counts)) {
                $barangay_counts[$barangay] += intval($row['osy_count']);
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
$barangays = array_keys($barangay_counts);
$counts = array_values($barangay_counts);

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
    'barangays' => $barangays,
    'counts' => $counts,
    'statistics' => [
        'mean' => $mean,
        'standard_deviation' => $std_dev
    ]
]);
?>
