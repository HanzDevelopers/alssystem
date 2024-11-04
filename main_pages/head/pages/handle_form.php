<?php
session_start();
include '../../../src/db/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("You must be logged in to submit the form.");
}

// Assuming the form data is collected here
$encoder_name = $_SESSION['username']; // Example for encoder name
$date_encoded = date('Y-m-d'); // Assuming today's date for encoding
$province = $_POST['province']; // Collect from form submission
$city = $_POST['city']; // Collect from form submission
$barangay = $_POST['barangay']; // Collect from form submission
$sitio_zone_purok = $_POST['sitio_zone_purok']; // Collect from form submission
$house_number = $_POST['house_number']; // Collect from form submission
$estimated_family_income = $_POST['estimated_family_income']; // Collect from form submission
$notes = $_POST['notes']; // Collect from form submission

// Example arrays for household members and their details, collected from the form
$household_members = $_POST['household_members']; // Expecting an array
$relationship_to_head = $_POST['relationship_to_head']; // Expecting an array
$birthdate = $_POST['birthdate']; // Expecting an array
$age = $_POST['age']; // Expecting an array
$gender = $_POST['gender']; // Expecting an array
$civil_status = $_POST['civil_status']; // Expecting an array
$disability = $_POST['disability']; // Expecting an array
$ethnicity = $_POST['ethnicity']; // Expecting an array
$religion = $_POST['religion']; // Expecting an array
$highest_grade = $_POST['highest_grade']; // Expecting an array
$attending_school = $_POST['attending_school']; // Expecting an array
$level_enrolled = $_POST['level_enrolled']; // Expecting an array
$reasons_not_attending = $_POST['reasons_not_attending']; // Expecting an array
$can_read_write = $_POST['can_read_write']; // Expecting an array
$occupation = $_POST['occupation']; // Expecting an array
$work = $_POST['work']; // Expecting an array
$status = $_POST['status']; // Expecting an array

// Check for existing records in the database
$checkQuery = "SELECT * FROM location_tbl lt
               JOIN members_tbl mt ON lt.record_id = mt.record_id
               WHERE lt.date_encoded = ? AND lt.barangay = ? 
               AND lt.housenumber = ? AND mt.household_members = ? 
               AND mt.birthdate = ? AND mt.age = ? AND mt.gender = ?";

$stmt = $conn->prepare($checkQuery);
$stmt->bind_param('sssssss', $date_encoded, $barangay, $house_number, 
                  $household_members[0], $birthdate[0], $age[0], $gender[0]);
$stmt->execute();
$result = $stmt->get_result();

// If no matching records are found, insert data directly
if ($result->num_rows === 0) {
    // Insert into location_tbl
    $insertLocation = "INSERT INTO location_tbl (encoder_name, date_encoded, province, city_municipality, 
                     barangay, sitio_zone_purok, housenumber, estimated_family_income, notes) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtLocation = $conn->prepare($insertLocation);
    $stmtLocation->bind_param('sssssssss', $encoder_name, $date_encoded, $province, $city, 
                              $barangay, $sitio_zone_purok, $house_number, 
                              $estimated_family_income, $notes);
    $stmtLocation->execute();
    
    // Get the last insert ID for members
    $record_id = $conn->insert_id;

    // Insert members into members_tbl and background_tbl
    foreach ($household_members as $index => $member) {
        // Insert into members_tbl
        $insertMember = "INSERT INTO members_tbl (record_id, household_members, relationship_to_head, 
                        birthdate, age, gender, civil_status, person_with_disability, 
                        ethnicity, religion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtMember = $conn->prepare($insertMember);
        $stmtMember->bind_param('isssssssss', $record_id, $member, 
                                $relationship_to_head[$index], 
                                $birthdate[$index], 
                                $age[$index], 
                                $gender[$index], 
                                $civil_status[$index], 
                                $disability[$index], 
                                $ethnicity[$index], 
                                $religion[$index]);
        $stmtMember->execute();

        // Get the last insert ID for background
        $member_id = $conn->insert_id;

        // Insert into background_tbl
        $insertBackground = "INSERT INTO background_tbl (member_id, highest_grade_completed, 
                          currently_attending_school, grade_level_enrolled, 
                          reasons_for_not_attending_school, can_read_write_simple_messages_inanylanguage, 
                          occupation, work, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtBackground = $conn->prepare($insertBackground);
        $stmtBackground->bind_param('issssssss', $member_id, 
                                    $highest_grade[$index], 
                                    $attending_school[$index], 
                                    $level_enrolled[$index], 
                                    $reasons_not_attending[$index], 
                                    $can_read_write[$index], 
                                    $occupation[$index], 
                                    $work[$index], 
                                    $status[$index]);
        $stmtBackground->execute();
    }

    // Close statements
    $stmtLocation->close();
    $stmtMember->close();
    $stmtBackground->close();

    echo "<script>alert('New household added successfully.'); window.location.href='dashboard.php';</script>";
} else {
    // Handle duplicate case with AJAX confirmation
    echo "<script>
    window.onload = function() {
        const result = confirm('A household member in this barangay with matching details already exists for the current year. Click OK to save as a duplicate, or Cancel to return to the dashboard without saving.');
        if (result) {
            // Proceed to insert data via AJAX
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'insert_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Prepare data to send
            let data = new URLSearchParams();
            data.append('encoder_name', '$encoder_name');
            data.append('date_encoded', '$date_encoded');
            data.append('province', '$province');
            data.append('city', '$city');
            data.append('barangay', '$barangay');
            data.append('sitio_zone_purok', '$sitio_zone_purok');
            data.append('house_number', '$house_number');
            data.append('estimated_family_income', '$estimated_family_income');
            data.append('notes', '$notes');

            // Ensure we are sending array data correctly
            const householdMembers = " . json_encode($household_members) . ";
            const relationships = " . json_encode($relationship_to_head) . ";
            const birthdates = " . json_encode($birthdate) . ";
            const ages = " . json_encode($age) . ";
            const genders = " . json_encode($gender) . ";
            const civilStatuses = " . json_encode($civil_status) . ";
            const disabilities = " . json_encode($disability) . ";
            const ethnicities = " . json_encode($ethnicity) . ";
            const religions = " . json_encode($religion) . ";
            const highestGrades = " . json_encode($highest_grade) . ";
            const attendingSchools = " . json_encode($attending_school) . ";
            const levelsEnrolled = " . json_encode($level_enrolled) . ";
            const reasonsNotAttending = " . json_encode($reasons_not_attending) . ";
            const canReadWrites = " . json_encode($can_read_write) . ";
            const occupations = " . json_encode($occupation) . ";
            const works = " . json_encode($work) . ";
            const statuses = " . json_encode($status) . ";

            for (let i = 0; i < householdMembers.length; i++) {
                data.append('household_members[]', householdMembers[i]);
                data.append('relationship_to_head[]', relationships[i] || '');
                data.append('birthdate[]', birthdates[i] || '');
                data.append('age[]', ages[i] || '');
                data.append('gender[]', genders[i] || '');
                data.append('civil_status[]', civilStatuses[i] || '');
                data.append('disability[]', disabilities[i] || '');
                data.append('ethnicity[]', ethnicities[i] || '');
                data.append('religion[]', religions[i] || '');
                data.append('highest_grade[]', highestGrades[i] || '');
                data.append('attending_school[]', attendingSchools[i] || '');
                data.append('level_enrolled[]', levelsEnrolled[i] || '');
                data.append('reasons_not_attending[]', reasonsNotAttending[i] || '');
                data.append('can_read_write[]', canReadWrites[i] || '');
                data.append('occupation[]', occupations[i] || '');
                data.append('work[]', works[i] || '');
                data.append('status[]', statuses[i] || '');
            }

            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    alert('Duplicate household data saved successfully.');
                    window.location.href = 'dashboard.php';
                }
            };
            xhr.send(data);
        } else {
            window.location.href = 'dashboard.php';
        }
    };
    </script>";
}

// Close the connection
$conn->close();
?>
