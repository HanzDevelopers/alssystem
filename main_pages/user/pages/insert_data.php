<?php
session_start();
include '../../../src/db/db_connection.php';

if (!isset($_SESSION['username'])) {
    die("You must be logged in to submit the form.");
}

// Collect the data sent via AJAX or direct form submission
$encoder_name = $_POST['encoder_name'];
$date_encoded = $_POST['date_encoded'];
$province = $_POST['province'];
$city = $_POST['city'];
$barangay = $_POST['barangay'];
$sitio_zone_purok = $_POST['sitio_zone_purok'];
$house_number = $_POST['house_number'];
$estimated_family_income = intval($_POST['estimated_family_income']);
$notes = $_POST['notes'];

// Additional data arrays
$household_members = $_POST['household_members'];
$relationship_to_head = $_POST['relationship_to_head'];
$birthdate = $_POST['birthdate'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$civil_status = $_POST['civil_status'];
$disability = $_POST['disability'];
$ethnicity = $_POST['ethnicity'];
$religion = $_POST['religion'];
$highest_grade = $_POST['highest_grade'];
$attending_school = $_POST['attending_school'];
$level_enrolled = $_POST['level_enrolled'];
$reasons_not_attending = $_POST['reasons_not_attending'];
$can_read_write = $_POST['can_read_write'];
$occupation = $_POST['occupation'];
$work = $_POST['work'];
$status = $_POST['status'];

// Insert into location_tbl
$stmt_loc = $conn->prepare("
    INSERT INTO location_tbl (encoder_name, date_encoded, province, city_municipality, barangay, sitio_zone_purok, housenumber, estimated_family_income, notes)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt_loc->bind_param("sssssssss", $encoder_name, $date_encoded, $province, $city, $barangay, $sitio_zone_purok, $house_number, $estimated_family_income, $notes);
$stmt_loc->execute();
$record_id = $stmt_loc->insert_id;
$stmt_loc->close();

// Insert household members and their background
foreach ($household_members as $index => $member) {
    $stmt_mem = $conn->prepare("
        INSERT INTO members_tbl (record_id, household_members, relationship_to_head, birthdate, age, gender, civil_status, person_with_disability, ethnicity, religion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt_mem->bind_param(
        "isssssssss", 
        $record_id, 
        $household_members[$index], 
        $relationship_to_head[$index], 
        $birthdate[$index], 
        $age[$index], 
        $gender[$index], 
        $civil_status[$index], 
        $disability[$index], 
        $ethnicity[$index], 
        $religion[$index]
    );
    $stmt_mem->execute();
    $member_id = $stmt_mem->insert_id;
    $stmt_mem->close();

    $stmt_bg = $conn->prepare("
        INSERT INTO background_tbl (member_id, highest_grade_completed, currently_attending_school, grade_level_enrolled, reasons_for_not_attending_school, can_read_write_simple_messages_inanylanguage, occupation, work, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt_bg->bind_param(
        "issssssss", 
        $member_id, 
        $highest_grade[$index], 
        $attending_school[$index], 
        $level_enrolled[$index], 
        $reasons_not_attending[$index], 
        $can_read_write[$index], 
        $occupation[$index], 
        $work[$index], 
        $status[$index]
    );
    $stmt_bg->execute();
    $stmt_bg->close();
}

// Close the connection and return a success response
$conn->close();
echo json_encode(['success' => true]);

?>
