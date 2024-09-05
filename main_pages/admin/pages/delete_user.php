<?php
include '../../../src/db/db_connection.php';

// Validate and sanitize the user_id
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    die("Invalid user ID");
}

$sql = "DELETE FROM user_tbl WHERE user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Record deleted successfully'); window.location.href='users.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
