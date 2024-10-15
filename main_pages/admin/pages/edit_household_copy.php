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
} else {
    echo "No record ID provided.";
    exit;
}

// If form is submitted, update household data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update household information
    $province = $_POST['province'];
    $city_municipality = $_POST['city_municipality'];
    $barangay = $_POST['barangay'];
    $sitio_zone_purok = $_POST['sitio_zone_purok'];
    $estimated_family_income = $_POST['estimated_family_income'];
    $notes = $_POST['notes'];

    $update_sql = "UPDATE location_tbl 
                   SET province = ?, city_municipality = ?, barangay = ?, sitio_zone_purok = ?, estimated_family_income = ?, notes = ?
                   WHERE record_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssi", $province, $city_municipality, $barangay, $sitio_zone_purok, $estimated_family_income, $notes, $record_id);
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
        $stmt->bind_param("ssssssssi", $household_member, $relationship_to_head, $birthdate, $age, $gender, $civil_status, $person_with_disability, $ethnicity, $religion, $member_id);
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
    header("Location: records.php");
    exit;
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

        /* Style to remove borders and apply underline effect to input fields */
        input[type="text"], input[type="number"], input[type="date"], textarea {
            border: none; /* Remove border */
            border-bottom: 1px solid #ccc; /* Underline effect */
            outline: none; /* Remove outline on focus */
            width: 100%; /* Full width */
            padding: 5px; /* Padding for better appearance */
            font-size: 12px; /* Adjust font size */
        }

        /* Add focus style */
        input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, textarea:focus {
            border-bottom: 1px solid #007BFF; /* Change underline color on focus */
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

        /* Landscape print style */
        @media print {
            @page {
                size: 13in 8.5in; /* Long bond paper size */
                margin: 0.5cm; /* Set margin for print */
            }
            body {
                font-size: 9px; /* Adjust font size for printing */
            }
            .container {
                width: 100%;
                height: 100%; /* Ensure it uses full height */
            }
            table {
                width: 100%; /* Ensure table fits full width */
            }
            th, td {
                border: 1px solid black; /* Darker border for print */
                padding: 2px; /* Reduced padding for print */
            }
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
        <div class="encoder-info">
            <p class="haha">Name of Encoder: 
                <span class="underline encoder"><strong>
                    <?php echo isset($housenumber_row['encoder_name']) ? htmlspecialchars($housenumber_row['encoder_name']) : '_____________________'; ?>
                </strong></span>
            </p>
            <p class="line-encoder">_______________________</p>
            <p class="haha">Date Encoded: 
                <span class="underline encoded"><strong>
                    <?php echo isset($housenumber_row['date_encoded']) ? htmlspecialchars($housenumber_row['date_encoded']) : '_____________________'; ?>
                </strong></span>
            </p>
            <p class="line-encoded">_______________________</p>
        </div>

        <!-- Form Body -->
        <section class="form-body">
            <!-- First Column -->
            <div class="column">
                <p class="haha">Province:
                    <span class="underline province"><strong>
                        <?php echo isset($housenumber_row['province']) ? htmlspecialchars($housenumber_row['province']) : '_____________________'; ?>
                    </strong></span>
                </p>
                <p class="line-province">_______________________</p>
                <p class="haha">City/Municipality:
                    <span class="underline city"><strong>
                        <?php echo isset($housenumber_row['city_municipality']) ? htmlspecialchars($housenumber_row['city_municipality']) : '_____________________'; ?>
                    </strong></span>
                </p>
                <p class="line-city">_______________________</p>
                <p class="haha">Barangay: 
                    <span class="underline barangay"><strong>
                        <?php echo isset($housenumber_row['barangay']) ? htmlspecialchars($housenumber_row['barangay']) : '_____________________'; ?>
                    </strong></span>
                </p>
                <p class="line-barangay">_______________________</p>
            </div>

            <!-- Second Column -->
            <div class="column">
                <p class="haha">Sitio/Purok/Zone:
                    <span class="underline purok"><strong>
                        <?php echo isset($housenumber_row['sitio_zone_purok']) ? htmlspecialchars($housenumber_row['sitio_zone_purok']) : '_____________________'; ?>
                    </strong></span>
                </p>
                <p class="line-purok">_______________________</p>
                <p class="haha">House Number:
                    <span class="underline house"><strong>
                        <?php echo isset($housenumber_row['housenumber']) ? htmlspecialchars($housenumber_row['housenumber']) : '_____________________'; ?>
                    </strong></span>
                </p>
                <p class="line-house">_______________________</p>
                <p class="haha">Estimated Family Income:
                    <span class="underline income"><strong>
                        <?php echo isset($housenumber_row['estimated_family_income']) ? htmlspecialchars($housenumber_row['estimated_family_income']) : '_____________________'; ?>
                    </strong></span>
                </p>
                <p class="line-income">_______________________</p>
            </div>

            <!-- Third Column -->
            <div class="column">
                <p class="haha">Other Notes: 
                    <span class="underline notes"><strong>
                        <?php echo isset($housenumber_row['notes']) && !empty($housenumber_row['notes']) ? htmlspecialchars($housenumber_row['notes']) : 'None'; ?>
                    </strong></span>
                </p>
                <p class="line-notes">_______________________</p>
            </div>
        </section>

            <!-- Household Members Information -->
            <h2>Household Members</h2>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Household Members</th>
                        <th>Relationship to Head</th>
                        <th>Birthdate</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Civil Status</th>
                        <th>Persons with Disability</th>
                        <th>Ethnicity</th>
                        <th>Religion</th>
                        <th>Highest Grade/Year Completed</th>
                        <th>Currently Attending School?</th>
                        <th>Level Enrolled</th>
                        <th>Reasons for Not Attending School</th>
                        <th>Can read/write simple message in any language</th>
                        <th>Occupation</th>
                        <th>Work</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($member = $members_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $member['member_id']; ?></td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][household_members]" value="<?php echo htmlspecialchars($member['household_members']); ?>"></td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][relationship_to_head]" value="<?php echo htmlspecialchars($member['relationship_to_head']); ?>"></td>
                        <td><input type="date" name="members[<?php echo $member['member_id']; ?>][birthdate]" value="<?php echo htmlspecialchars($member['birthdate']); ?>"></td>
                        <td><input type="number" name="members[<?php echo $member['member_id']; ?>][age]" value="<?php echo htmlspecialchars($member['age']); ?>"></td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][gender]">
                                <option value="Male" <?php if ($member['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($member['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            </select>
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][civil_status]">
                                <option value="Single" <?php if ($member['civil_status'] == 'Single') echo 'selected'; ?>>Single</option>
                                <option value="Married" <?php if ($member['civil_status'] == 'Married') echo 'selected'; ?>>Married</option>
                                <option value="Widowed" <?php if ($member['civil_status'] == 'Widowed') echo 'selected'; ?>>Widowed</option>
                                <option value="Divorced" <?php if ($member['civil_status'] == 'Divorced') echo 'selected'; ?>>Divorced</option>
                            </select>
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][person_with_disability]">
                                <option value="Yes" <?php if ($member['person_with_disability'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                <option value="No" <?php if ($member['person_with_disability'] == 'No') echo 'selected'; ?>>No</option>
                            </select>
                        </td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][ethnicity]" value="<?php echo htmlspecialchars($member['ethnicity']); ?>"></td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][religion]" value="<?php echo htmlspecialchars($member['religion']); ?>"></td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][highest_grade_completed]" value="<?php echo htmlspecialchars($member['highest_grade_completed']); ?>"></td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][currently_attending_school]">
                                <option value="Yes" <?php if ($member['currently_attending_school'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                <option value="No" <?php if ($member['currently_attending_school'] == 'No') echo 'selected'; ?>>No</option>
                            </select>
                        </td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][grade_level_enrolled]" value="<?php echo htmlspecialchars($member['grade_level_enrolled']); ?>"></td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][reasons_for_not_attending_school]" value="<?php echo htmlspecialchars($member['reasons_for_not_attending_school']); ?>"></td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][can_read_write_simple_messages_inanylanguage]">
                                <option value="Yes" <?php if ($member['can_read_write_simple_messages_inanylanguage'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                <option value="No" <?php if ($member['can_read_write_simple_messages_inanylanguage'] == 'No') echo 'selected'; ?>>No</option>
                            </select>
                        </td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][occupation]">
                                <option value="Yes" <?php if ($member['occupation'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                <option value="No" <?php if ($member['occupation'] == 'No') echo 'selected'; ?>>No</option>
                            </select>
                        </td>
                        <td><input type="text" name="members[<?php echo $member['member_id']; ?>][work]" value="<?php echo htmlspecialchars($member['work']); ?>"></td>
                        <td>
                            <select name="members[<?php echo $member['member_id']; ?>][status]">
                                <option value="Yes" <?php if ($member['status'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                <option value="No" <?php if ($member['status'] == 'No') echo 'selected'; ?>>No</option>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <button type="submit">Update Household</button>
        </form>
    </div>
</body>
</html>
