<?php
// Start session to access logged-in user's district
session_start();
include '../../../src/db/db_connection.php';

// Retrieve the logged-in user’s district from session
$user_district = $_SESSION['district'];

// District mapping with case variations for each barangay
$district_mapping = [
    'tankulan' => 'District 1', 'dicklum' => 'District 1', 'san miguel' => 'District 1', 'ticala' => 'District 1', 'lingion' => 'District 1',
    'alae' => 'District 2', 'damilag' => 'District 2', 'mambatangan' => 'District 2', 'mantibugao' => 'District 2', 'minsuro' => 'District 2', 'lunocan' => 'District 2',
    'agusan canyon' => 'District 3', 'mampayag' => 'District 3', 'dahilayan' => 'District 3', 'sankanan' => 'District 3', 'kalugmanan' => 'District 3', 'lindaban' => 'District 3',
    'dalirig' => 'District 4', 'maluko' => 'District 4', 'santiago' => 'District 4', 'guilang2' => 'District 4', 'guilang-guilang' => 'District 4'
];

// Fetch data with necessary columns and conditions, without using district mapping in SQL
$query = "
    SELECT b.reasons_for_not_attending_school, COUNT(*) AS count, LOWER(TRIM(l.barangay)) AS barangay 
    FROM background_tbl AS b
    JOIN members_tbl AS m ON b.member_id = m.member_id
    JOIN location_tbl AS l ON m.record_id = l.record_id
    WHERE m.age BETWEEN 15 AND 30
    AND LOWER(b.currently_attending_school) = 'no'
    AND YEAR(l.date_encoded) = YEAR(CURDATE())
    GROUP BY b.reasons_for_not_attending_school, barangay
    ORDER BY count DESC
";

$result = $conn->query($query);

$reasons = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if the barangay matches the user's district through the mapping
        $barangay = $row['barangay'];
        $district = $district_mapping[$barangay] ?? null;

        if ($district === $user_district) {
            $reasons[] = [
                'reason' => $row['reasons_for_not_attending_school'],
                'count' => $row['count']
            ];
        }
    }
}

// Return all reasons as a JSON response
echo json_encode($reasons);
?>
