
<?php
// Include your database connection
include '../../../src/db/db_connection.php';

// Check if the record_id is passed as a URL parameter
if (isset($_GET['record_id'])) {
    $record_id = intval($_GET['record_id']); // Convert to integer for security

    // Fetch household information for the given record_id
    $sql = "SELECT 
                l.encoder_name, 
                l.date_encoded, 
                l.housenumber, 
                l.province, 
                l.city_municipality, 
                l.barangay, 
                l.sitio_zone_purok, 
                l.estimated_family_income, 
                l.notes 
            FROM 
                location_tbl l
            WHERE 
                l.record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $household_info = $result->fetch_assoc();
    } else {
        echo "No household data found.";
        exit;
    }

    // Fetch household members based on the record_id
    $members_sql = "SELECT 
                        m.member_id, 
                        m.household_members, 
                        m.relationship_to_head, 
                        m.birthdate, 
                        m.age, 
                        m.gender, 
                        m.civil_status, 
                        m.person_with_disability, 
                        m.ethnicity, 
                        m.religion, 
                        b.highest_grade_completed, 
                        b.currently_attending_school, 
                        b.grade_level_enrolled, 
                        b.reasons_for_not_attending_school, 
                        b.can_read_write_simple_messages_inanylanguage, 
                        b.occupation, 
                        b.work, 
                        b.status 
                    FROM 
                        members_tbl m 
                    LEFT JOIN 
                        background_tbl b ON m.member_id = b.member_id 
                    WHERE 
                        m.record_id = ?";
    $stmt = $conn->prepare($members_sql);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $members_result = $stmt->get_result();
    
    // Store members data in an array
    $members = [];
    while ($member = $members_result->fetch_assoc()) {
        $members[] = $member;
    }
} else {
    echo "No record ID provided.";
    exit;
}

// If form is submitted, update household data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update household information
    $encoder = $_POST['encoder_name'];
    $date = $_POST['date_encoded'];
    $province = $_POST['province'];
    $city_municipality = $_POST['city_municipality'];
    $barangay = $_POST['barangay'];
    $sitio_zone_purok = $_POST['sitio_zone_purok'];
    $estimated_family_income = $_POST['estimated_family_income'];
    $notes = $_POST['notes'];

    $update_sql = "UPDATE location_tbl 
                   SET encoder_name = ?, date_encoded = ?, province = ?, city_municipality = ?, barangay = ?, sitio_zone_purok = ?, estimated_family_income = ?, notes = ?
                   WHERE record_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssssi", $encoder, $date, $province, $city_municipality, $barangay, $sitio_zone_purok, $estimated_family_income, $notes, $record_id);
    $stmt->execute();

    // Update household members
    foreach ($_POST['members'] as $member_id => $member_data) {
        $household_member = $member_data['household_members'];
        $relationship_to_head = $member_data['relationship_to_head'];
        $birthdate = $member_data['birthdate'];
        $age = $member_data['age'];
        $gender = $member_data['gender'];
        $civil_status = $member_data['civil_status'];
        $person_with_disability = $member_data['person_with_disability'];
        $ethnicity = $member_data['ethnicity'];
        $religion = $member_data['religion'];
        $highest_grade_completed = $member_data['highest_grade_completed'];
        $currently_attending_school = $member_data['currently_attending_school'];
        $grade_level_enrolled = $member_data['grade_level_enrolled'];
        $reasons_for_not_attending_school = $member_data['reasons_for_not_attending_school'];
        $can_read_write_simple_messages_inanylanguage = $member_data['can_read_write_simple_messages_inanylanguage'];
        $occupation = $member_data['occupation'];
        $work = $member_data['work'];
        $status = $member_data['status'];

        // Update member information
        $update_member_sql = "UPDATE members_tbl 
        SET household_members = ?, relationship_to_head = ?, birthdate = ?, age = ?, gender = ?, civil_status = ?, person_with_disability = ?, ethnicity = ?, religion = ? 
        WHERE member_id = ?";
$stmt = $conn->prepare($update_member_sql);
$stmt->bind_param("sssssssssi", $household_member, $relationship_to_head, $birthdate, $age, $gender, $civil_status, $person_with_disability, $ethnicity, $religion, $member_id);


        $stmt->execute();

        // Update background information
        $update_background_sql = "UPDATE background_tbl 
                                   SET highest_grade_completed = ?, currently_attending_school = ?, grade_level_enrolled = ?, reasons_for_not_attending_school = ?, can_read_write_simple_messages_inanylanguage = ?, occupation = ?, work = ?, status = ? 
                                   WHERE member_id = ?";
        $stmt = $conn->prepare($update_background_sql);
        $stmt->bind_param("ssssssssi", $highest_grade_completed, $currently_attending_school, $grade_level_enrolled, $reasons_for_not_attending_school, $can_read_write_simple_messages_inanylanguage, $occupation, $work, $status, $member_id);
        $stmt->execute();
    }

    // Redirect after successful update
    header("Location: income_below_20,000.php");
    exit;
}
?>
<?php
// Assume form processing is done here
$update_successful = false; // Initialize as false

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data (e.g., update household data in the database)
    // If the update is successful, set $update_successful to true
    // Example of setting to true (you will have your own logic)
    if ($update_is_successful) { // Replace this with your actual condition
        $update_successful = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Household Data</title>
    <link rel="stylesheet" href="output.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 100%;
            background-color: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 10px;
        }

        .under {
            font-style: italic;
            text-decoration: underline;
        }

        input[type="text"], input[type="number"], input[type="date"], textarea {
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
            width: 100%;
            padding: 5px;
            font-size: 12px;
        }

        input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, textarea:focus {
            border-bottom: 1px solid #007BFF;
        }

        h1, h2 {
            margin-bottom: 5px;   
            font-weight: 700;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 3px;
            font-size: 9px; 
        }

        thead {
            background-color: #f4f4f4;
        }

        @media print {
            @page {
                size: 13in 8.5in; 
                margin: 0.5cm; 
            }
            body {
                font-size: 9px; 
            }
            .container {
                width: 100%;
                height: 100%; 
            }
            table {
                width: 100%; 
            }
            th, td {
                border: 1px solid black; 
                padding: 2px; 
            }
        }
        
        .household-details {
    display: flex;
    justify-content: space-between;
    gap: 20px; /* Adds space between left and right sections */
    flex-wrap: wrap; /* Ensures the layout adjusts on smaller screens */
}

.household-details .left-section,
.household-details .right-section {
    flex: 1; /* Each section takes up equal width */
    min-width: 300px; /* Ensures the sections don't shrink below a certain size */
}

.household-details div {
    margin-bottom: 5px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 12px;
}

input, textarea {
    font-weight: bold;
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; /* Ensures padding is included in the element’s total width */
}
.button-group {
    display: flex;
    justify-content: flex-end; /* Aligns buttons to the right */
    gap: 10px; /* Space between the buttons */
    margin-top: 20px; /* Add some space above the buttons */
}

.update-btn {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    padding: 10px 20px; /* Button padding */
    border: none; /* Remove border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    font-size: 14px;
}

.update-btn:hover {
    background-color: #45a049; /* Darker green on hover */
}

.cancel-btn {
    background-color: #f44336; /* Red background */
    color: white; /* White text */
    padding: 10px 20px; /* Button padding */
    border: none; /* Remove border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    font-size: 14px;
}

.cancel-btn:hover {
    background-color: #d32f2f; /* Darker red on hover */
}


    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Household Information</h1>
        </header>

        <form method="POST">
           
            <!-- Encoder Info -->
                <div class="encoder-info" style="width:50%;">
                <label for="encoder_name">Name of Encoder: </label>
                <input type="text" id="encoder_name" name="encoder_name" value="<?php echo htmlspecialchars($household_info['encoder_name']); ?>" required>
            <!--<p class="haha">Name of Encoder: 
                <span class="underline encoder"><strong>
                <?php echo isset($household_info['encoder_name']) ? htmlspecialchars($household_info['encoder_name']) : '_____________________'; ?>
                </strong></span>
            </p>-->


            
            <label for="date_encoded">Origin Date: </label>
                <input type="text" id="date_encoded" name="date_encoded" value="<?php echo htmlspecialchars($household_info['date_encoded']); ?>" required>

            </div>

            <!-- Household Details -->
<div class="household-details">
    <div class="left-section">
        <div>
            <label for="housenumber">House Number:</label>
            <input type="text" id="housenumber" name="housenumber" value="<?php echo htmlspecialchars($household_info['housenumber']); ?>" required>
        </div>
        <div>
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($household_info['province']); ?>" required>
        </div>
        <div>
            <label for="city_municipality">City/Municipality:</label>
            <input type="text" id="city_municipality" name="city_municipality" value="<?php echo htmlspecialchars($household_info['city_municipality']); ?>" required>
        </div>
    </div>

    <div class="right-section">
        <div>
            <label for="barangay">Barangay:</label>
            <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($household_info['barangay']); ?>" required>
        </div>
        <div>
            <label for="sitio_zone_purok">Sitio/Zone/Purok:</label>
            <input type="text" id="sitio_zone_purok" name="sitio_zone_purok" value="<?php echo htmlspecialchars($household_info['sitio_zone_purok']); ?>" required>
        </div>
        <div>
            <label for="estimated_family_income">Estimated Family Income:</label>
            <input type="number" id="estimated_family_income" name="estimated_family_income" value="<?php echo htmlspecialchars($household_info['estimated_family_income']); ?>" required>
        </div>
    </div>
</div>

<div>
    <label for="notes">Notes:</label>
    <textarea id="notes" name="notes"><?php echo htmlspecialchars($household_info['notes']); ?></textarea>
</div>


            <h2>Household Members</h2>
            <table>
                <thead>
                    <tr>
                        <th>Household Member</th>
                        <th>Relationship to Head</th>
                        <th>Birthdate</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Civil Status</th>
                        <th>Person with Disability</th>
                        <th>Ethnicity</th>
                        <th>Religion</th>
                        <th>Highest Grade Completed</th>
                        <th>Currently Attending School</th>
                        <th>Grade Level Enrolled</th>
                        <th>Reasons for Not Attending School</th>
                        <th>Can Read/Write</th>
                        <th>Occupation</th>
                        <th>Work</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][household_members]" value="<?php echo htmlspecialchars($member['household_members']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][relationship_to_head]" value="<?php echo htmlspecialchars($member['relationship_to_head']); ?>" required>
                        </td>
                        <td>
                            <input type="date" name="members[<?php echo $member['member_id']; ?>][birthdate]" value="<?php echo htmlspecialchars($member['birthdate']); ?>" required>
                        </td>
                        <td>
                            <input type="number" name="members[<?php echo $member['member_id']; ?>][age]" value="<?php echo htmlspecialchars($member['age']); ?>" required>
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][gender]" required>
                                <option value="Male" <?php echo $member['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $member['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][civil_status]" required>
                                <option value="Single" <?php echo $member['civil_status'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                                <option value="Married" <?php echo $member['civil_status'] === 'Married' ? 'selected' : ''; ?>>Married</option>
                                <option value="Widowed" <?php echo $member['civil_status'] === 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                <option value="Separated" <?php echo $member['civil_status'] === 'Separated' ? 'selected' : ''; ?>>Separated</option>
                            </select>
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][person_with_disability]" required>
                                <option value="Yes" <?php echo $member['person_with_disability'] === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo $member['person_with_disability'] === 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][ethnicity]" value="<?php echo htmlspecialchars($member['ethnicity']); ?>">
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][religion]" value="<?php echo htmlspecialchars($member['religion']); ?>" required>
                        </td>

                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][highest_grade_completed]" value="<?php echo htmlspecialchars($member['highest_grade_completed']); ?>">
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][currently_attending_school]" required>
                                <option value="Yes" <?php echo $member['currently_attending_school'] === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo $member['currently_attending_school'] === 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][grade_level_enrolled]" value="<?php echo htmlspecialchars($member['grade_level_enrolled']); ?>">
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][reasons_for_not_attending_school]" value="<?php echo htmlspecialchars($member['reasons_for_not_attending_school']); ?>">
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][can_read_write_simple_messages_inanylanguage]" required>
                                <option value="Yes" <?php echo $member['can_read_write_simple_messages_inanylanguage'] === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo $member['can_read_write_simple_messages_inanylanguage'] === 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][occupation]" value="<?php echo htmlspecialchars($member['occupation']); ?>">
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][work]" value="<?php echo htmlspecialchars($member['work']); ?>">
                        </td>
                        <td>
                            <input type="text" name="members[<?php echo $member['member_id']; ?>][status]" value="<?php echo htmlspecialchars($member['status']); ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

           
    <div class="button-group">
    <button type="submit" class="update-btn" onclick="showUpdateSuccess()">Update Household Data</button>
    <button type="button" class="cancel-btn" onclick="confirmCancel()">Cancel</button>
</div> 
        </form>
    </div>
</body>
<script>
function confirmCancel() {
    var result = confirm("Are you sure you want to cancel? Any changes may not be saved.");
    if (result) {
        window.location.href = 'income_below_20,000.php'; // Redirect if user confirms
    }
}
// Function to display success message
function showUpdateSuccess() {
            alert("Household data has been updated successfully!");
        }

        // Check if the update was successful and display the alert
        <?php if ($update_successful): ?>
            window.onload = function() {
                showUpdateSuccess();
            };
        <?php endif; ?>

</script>

</html>