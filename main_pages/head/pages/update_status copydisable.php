<?php
include '../../../src/db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $new_status = $_POST['status'];
    $current_date = $_POST['date'];

    // Prepare SQL query based on the status clicked
    if ($new_status === 'disable') {
        // Set status to 'disable', update disable_date, and set enable_date to NULL
        $stmt = $conn->prepare("UPDATE user_tbl 
                                SET status = 'disable', 
                                    disable_date = ?, 
                                    enable_date = NULL 
                                WHERE user_id = ?");
        $stmt->bind_param('si', $current_date, $user_id);
    } else {
        // Set status to 'enable', update enable_date, and set disable_date to NULL
        $stmt = $conn->prepare("UPDATE user_tbl 
                                SET status = 'enable', 
                                    enable_date = ?, 
                                    disable_date = NULL 
                                WHERE user_id = ?");
        $stmt->bind_param('si', $current_date, $user_id);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update status.']);
    }

    $stmt->close();
}
?>
