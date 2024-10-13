<?php
// Start session
session_start();
include '../../../src/db/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("You must be logged in to submit the form.");
}

// Get the encoder name from session
$encoder_name = $_SESSION['username'];

// Retrieve form data
$province = isset($_POST['province']) ? $_POST['province'] : null;
$city = isset($_POST['city']) ? $_POST['city'] : null;
$barangay = isset($_POST['barangay']) ? $_POST['barangay'] : null;
$sitio_zone_purok = isset($_POST['sitio_zone_purok']) ? $_POST['sitio_zone_purok'] : null;
$house_number = isset($_POST['house_number']) ? $_POST['house_number'] : null;
$estimated_family_income = isset($_POST['estimated_family_income']) ? intval($_POST['estimated_family_income']) : null;
$household_members = isset($_POST['household_members']) ? $_POST['household_members'] : [];
$relationship_to_head = isset($_POST['relationship_to_head']) ? $_POST['relationship_to_head'] : [];
$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : [];
$age = isset($_POST['age']) ? $_POST['age'] : [];
$gender = isset($_POST['gender']) ? $_POST['gender'] : [];
$civil_status = isset($_POST['civil_status']) ? $_POST['civil_status'] : [];
$disability = isset($_POST['disability']) ? $_POST['disability'] : [];
$ethnicity = isset($_POST['ethnicity']) ? $_POST['ethnicity'] : [];
$religion = isset($_POST['religion']) ? $_POST['religion'] : [];
$highest_grade = isset($_POST['highest_grade']) ? $_POST['highest_grade'] : [];
$attending_school = isset($_POST['attending_school']) ? $_POST['attending_school'] : [];
$level_enrolled = isset($_POST['level_enrolled']) ? $_POST['level_enrolled'] : [];
$reasons_not_attending = isset($_POST['reasons_not_attending']) ? $_POST['reasons_not_attending'] : [];
$can_read_write = isset($_POST['can_read_write']) ? $_POST['can_read_write'] : [];
$occupation = isset($_POST['occupation']) ? $_POST['occupation'] : [];
$work = isset($_POST['work']) ? $_POST['work'] : [];
$status = isset($_POST['status']) ? $_POST['status'] : [];
$date_encoded = !empty($_POST['date_encoded']) ? $_POST['date_encoded'] : date('Y-m-d H:i:s'); // Use form date or current date
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

// Check if required fields are provided
if ($province === null || $city === null || $barangay === null || $sitio_zone_purok === null || $house_number === null || $estimated_family_income === null || empty($household_members)) {
    die("Required fields are missing.");
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert into location_tbl
$stmt_loc = $conn->prepare("
    INSERT INTO location_tbl (
        encoder_name, date_encoded, province, city_municipality, barangay, sitio_zone_purok, housenumber, estimated_family_income, notes
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if ($stmt_loc === false) {
    die("Failed to prepare location SQL statement: " . $conn->error);
}

$stmt_loc->bind_param("sssssssss", $encoder_name, $date_encoded, $province, $city, $barangay, $sitio_zone_purok, $house_number, $estimated_family_income, $notes);

// Execute location insert
if (!$stmt_loc->execute()) {
    die("Error inserting into location_tbl: " . $stmt_loc->error);
}

// Get the inserted record_id from location_tbl
$record_id = $stmt_loc->insert_id;
$stmt_loc->close();

// Loop through each household member and insert into members_tbl and background_tbl
$stmt_mem = $conn->prepare("
    INSERT INTO members_tbl (
        record_id, household_members, relationship_to_head, birthdate, age, gender, civil_status, person_with_disability, ethnicity, religion
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt_bg = $conn->prepare("
    INSERT INTO background_tbl (
        member_id, highest_grade_completed, currently_attending_school, grade_level_enrolled, reasons_for_not_attending_school,
        can_read_write_simple_messages_inanylanguage, occupation, work, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if ($stmt_mem === false || $stmt_bg === false) {
    die("Failed to prepare members or background SQL statement: " . $conn->error);
}

foreach ($household_members as $index => $member) {
    // Insert into members_tbl
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
    
    if (!$stmt_mem->execute()) {
        die("Error inserting into members_tbl: " . $stmt_mem->error);
    }
    
    // Get the inserted member_id from members_tbl
    $member_id = $stmt_mem->insert_id;

    // Insert into background_tbl
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

    if (!$stmt_bg->execute()) {
        die("Error inserting into background_tbl: " . $stmt_bg->error);
    }
}

// Close the statements and connection
$stmt_mem->close();
$stmt_bg->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <script>
        window.onload = function() {
            // Alert with options
            const result = confirm('New household added successfully. Click OK to go to the Dashboard or Cancel to add another Household.');
            if (result) {
                // User clicked OK, redirect to dashboard.php
                window.location.href = 'dashboard.php';
            } else {
                // User clicked Cancel, stay on form.php
                window.location.href = 'form.php';
            }
        };
    </script>
</head>
<body>
</body>
</html>
