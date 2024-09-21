<?php
include '../../../src/db/db_connection.php';

// Validate and sanitize the user_id
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    die("Invalid user ID");
}

// Begin transaction
$conn->begin_transaction();

try {
    // Delete from user_log table first
    $deleteLogsSql = "DELETE FROM user_log WHERE user_id = $user_id";
    if ($conn->query($deleteLogsSql) !== TRUE) {
        throw new Exception("Error deleting user logs: " . $conn->error);
    }

    // Delete from user_tbl table
    $deleteUserSql = "DELETE FROM user_tbl WHERE user_id = $user_id";
    if ($conn->query($deleteUserSql) !== TRUE) {
        throw new Exception("Error deleting user: " . $conn->error);
    }

    // Commit the transaction
    $conn->commit();

    echo "<script>alert('User and associated logs deleted successfully'); window.location.href='users.php';</script>";
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
