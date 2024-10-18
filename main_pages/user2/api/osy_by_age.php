<?php
// osy_by_age.php
header('Content-Type: application/json');
include '../../../src/db/db_connection.php';

session_start();  // Start session to get logged-in user info

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
    'District 1' => ['Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion'],
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
        JOIN background_tbl b ON m.member_id = b.member_id
        WHERE m.age BETWEEN 15 AND 30
        AND LOWER(b.currently_attending_school) != 'yes'  -- Filter on background_tbl
        AND l.barangay IN ('" . implode("','", $user_barangays) . "')  -- Filter on user's barangays
        GROUP BY year, age_range";  // Group by year and age_range

$result = $conn->query($sql);

// Check for query execution errors
if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error, 'sql' => $sql]);  // Output error and SQL for debugging
    exit();
}

$osy_data = [];

// Check if there are results and fetch data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $osy_data[] = [
            'year' => $row['year'],
            'age_range' => $row['age_range'],
            'osy_count' => intval($row['osy_count'])  // Convert count to integer
        ];
    }
}

// Close the connection
$conn->close();

// Return the data in JSON format
echo json_encode($osy_data);
?>
