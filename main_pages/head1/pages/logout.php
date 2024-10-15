<?php
// Start the session
session_start();

// Database connection
include '../../../src/db/db_connection.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Update the user_log table with the logout date
    $sql = "UPDATE user_log SET logout_date = NOW() WHERE user_id = ? AND logout_date IS NULL ORDER BY login_date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Logout successful
        session_unset(); // Clear session variables
        session_destroy(); // Destroy session
        header("Location: ../../../login.php"); // Redirect to login page
        exit();
    } else {
        // Handle errors if needed
        echo "Error updating logout date: " . $conn->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
