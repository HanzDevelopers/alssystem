<?php
include '../../../src/db/db_connection.php'; // Ensure this file correctly sets up $conn

if (!isset($conn)) {
    die("Database connection error.");
}

$member_id = $_GET['member_id']; // Get member_id from the URL or form submission

// Start a transaction
$conn->begin_transaction();

try {
    // Step 1: Delete from background_tbl where member_id matches
    $stmt = $conn->prepare("DELETE FROM background_tbl WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->close();

    // Step 2: Delete from members_tbl where member_id matches
    $stmt = $conn->prepare("DELETE FROM members_tbl WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Use JavaScript to show an alert and then redirect to records.php
    echo "<script>
        alert('Member deleted successfully');
        window.location.href = 'records.php';
    </script>";
} catch (Exception $e) {
    // If any error occurs, rollback transaction
    $conn->rollback();
    echo "<script>
        alert('Error deleting member: " . $e->getMessage() . "');
        window.location.href = 'records.php';
    </script>";
}
?>
