<?php
include '../../../src/db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $new_status = $_POST['status'];

    // Update the status in the database
    $stmt = $conn->prepare("UPDATE user_tbl SET status = ? WHERE user_id = ?");
    $stmt->bind_param('si', $new_status, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update status.']);
    }

    $stmt->close();
}
?>
