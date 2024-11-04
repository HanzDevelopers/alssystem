<?php
include '../../../src/db/db_connection.php';

$date_encoded = $_POST['date_encoded'];
$barangay = $_POST['barangay'];
$house_number = $_POST['house_number'];

$currentYear = date('Y', strtotime($date_encoded));
$query = "SELECT * FROM location_tbl 
          WHERE barangay = ? 
          AND housenumber = ? 
          AND YEAR(date_encoded) = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $barangay, $house_number, $currentYear);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'duplicate';
} else {
    echo 'unique';
}

$stmt->close();
$conn->close();
?>
