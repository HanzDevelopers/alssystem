<?php
// Database connection
include 'db/db_connection.php';

$query = "SELECT reasons_for_not_attending_school, COUNT(*) as count 
          FROM background_tbl 
          GROUP BY reasons_for_not_attending_school 
          ORDER BY count DESC 
          LIMIT 3";
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
echo json_encode($reasons);
?>
