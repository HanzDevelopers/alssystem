<?php
// Database connection
include '../../../src/db/db_connection.php';

// Fetch all reasons meeting the age, school attendance, and current year conditions
$query = "
    SELECT b.reasons_for_not_attending_school, COUNT(*) AS count 
    FROM background_tbl AS b
    JOIN members_tbl AS m ON b.member_id = m.member_id
    JOIN location_tbl AS l ON m.record_id = l.record_id
    WHERE m.age BETWEEN 15 AND 30
    AND LOWER(b.currently_attending_school) = 'no'
    AND YEAR(l.date_encoded) = YEAR(CURDATE())
    GROUP BY b.reasons_for_not_attending_school
    ORDER BY count DESC
";




$result = $conn->query($query);

$reasons = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reasons[] = [
            'reason' => $row['reasons_for_not_attending_school'],
            'count' => $row['count']
        ];
    }
}

// Return all reasons as a JSON response
echo json_encode($reasons);
?>
