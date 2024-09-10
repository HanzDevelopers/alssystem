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
$year = isset($_POST['year']) ? intval($_POST['year']) : null;
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
$date_encoded = date('Y-m-d H:i:s'); // Set current date and time
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

// Check if required fields are provided
if ($year === null || $province === null || $city === null || $barangay === null || $sitio_zone_purok === null || $house_number === null || $estimated_family_income === null || empty($household_members)) {
    die("Required fields are missing.");
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the insert statement
$stmt = $conn->prepare("
    INSERT INTO osy_tbl (
        encoder_name, date_encoded, year, province, city_municipality, barangay, sitio_zone_purok, housenumber, estimated_family_income,
        household_members, relationship_to_head, birthdate, age, gender, civil_status, person_with_disability, ethnicity, religion,
        highest_grade_completed, currently_attending_school, grade_level_enrolled, reasons_for_not_attending_school,
        can_read_write_simple_messages_inanylanguage, occupation, work, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Check if statement was prepared correctly
if ($stmt === false) {
    die("Failed to prepare SQL statement: " . $conn->error);
}

// Loop through each household member and insert data
foreach ($household_members as $index => $member) {
    $stmt->bind_param(
        "ssssssssssssssssssssssssss",
        $encoder_name,
        $date_encoded,
        $year,
        $province,
        $city,
        $barangay,
        $sitio_zone_purok,
        $house_number,
        $estimated_family_income,
        $household_members[$index],
        $relationship_to_head[$index],
        $birthdate[$index],
        $age[$index],
        $gender[$index],
        $civil_status[$index],
        $disability[$index],
        $ethnicity[$index],
        $religion[$index],
        $highest_grade[$index],
        $attending_school[$index],
        $level_enrolled[$index],
        $reasons_not_attending[$index],
        $can_read_write[$index],
        $occupation[$index],
        $work[$index],
        $status[$index]
    );

    // Execute the statement
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
}

// Close the statement and connection
$stmt->close();
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
