<?php
// Include the database connection
include '../../../src/db/db_connection.php';

// Check if the member_id is provided in the URL
if (isset($_GET['member_id'])) {
    $member_id = intval($_GET['member_id']); // Convert to integer for security

    // Fetch the corresponding record_id based on the member_id
    $sql = "SELECT record_id FROM members_tbl WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $record_id = $row['record_id'];

        // Redirect to edit_household.php with the record_id
        header("Location: income_below_20,000_edit_household.php?record_id=" . $record_id);
        exit();
    } else {
        echo "No record found for this member.";
        exit();
    }
} else {
    echo "No member ID provided.";
    exit();
}
?>
