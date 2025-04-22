<?php
// Include your database connection
include '../../../src/db/db_connection.php';

// Check if the member_id is passed as a URL parameter
if (isset($_GET['member_id']) && !empty($_GET['member_id'])) {
    $member_id = intval($_GET['member_id']); // Convert to integer for security

    // Fetch the housenumber, record_id, encoder_name, and date_encoded for the given member_id
    $housenumber_sql = "SELECT l.encoder_name, l.date_encoded, l.housenumber, l.record_id, l.province, l.city_municipality, l.barangay, l.sitio_zone_purok, l.estimated_family_income, l.notes 
                        FROM location_tbl l 
                        JOIN members_tbl m ON l.record_id = m.record_id 
                        WHERE m.member_id = ?";
    $stmt = $conn->prepare($housenumber_sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $housenumber_result = $stmt->get_result();

    if ($housenumber_result && $housenumber_result->num_rows > 0) {
        $housenumber_row = $housenumber_result->fetch_assoc();
        
        // Fetch all members with the same record_id
        $sql = "SELECT 
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
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $housenumber_row['record_id']);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // Handle case where no housenumber found
        echo "<p>No household found for the given member.</p>";
        $result = null;
    }
} else {
    // Handle missing member_id
    echo "<p>No member ID provided. Please select a household from the records page.</p>";
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household Profile Form</title>
    <link rel="stylesheet" href="output.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<style>
        /* Custom CSS for buttons */
        .custom-button {
            background-color: #007bff; /* Bootstrap Primary Color */
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s;
        }

        .custom-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .custom-button.redirect {
            background-color: #28a745; /* Green for redirect button */
        }

        .custom-button.redirect:hover {
            background-color: #218838; /* Darker shade on hover */
        }

        /* Optional: Add some styling to the button container */
        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end; /* Align buttons to the right */
        }
        .custom-button.edit {
            background-color: #e57373; /* Soft red for edit button */
        }

        .custom-button.edit:hover {
            background-color: #d32f2f; /* Darker shade of red on hover */
        }

    </style>
<body>
    <div class="container" id="pdf-content"> <!-- Added id for PDF generation -->
        <!-- Header -->
        <header><br>
            <h2>DEPARTMENT OF EDUCATION</h2>
            <h2>BUREAU OF ALTERNATIVE LEARNING SYSTEM</h2>
            <h3>in partnership with the</h3>
            <h2>LOCAL GOVERNMENT UNIT OF MANOLO FORTICH</h2>
            <br>
            <h2 class="under">PROFILE OF HOUSEHOLD MEMBERS</h2>
            <br>
        </header>
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

        <!-- Table for Household Members -->
        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Household Members</th>
                        <th>Relationship<br>to Head</th>
                        <th>Birthdate</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Civil Status</th>
                        <th>Persons<br>with<br>Disability</th>
                        <th>Ethnicity</th>
                        <th>Religion</th>
                        <th>Highest Grade/Year Completed</th>
                        <th>Currently<br>Attending<br>School?</th>
                        <th>Level Enrolled</th>
                        <th>Reasons for Not<br>Attending School</th>
                        <th>Can read/write<br>simple message in<br>any language</th>
                        <th>Occupation</th>
                        <th>Work</th>
                        <th>Interested<br>to Enroll<br>in ALS?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Initialize row counter
                    $row_num = 1;

                    // Check if the result has rows
                    if (!empty($result) && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row_num}</td>
                                    <td>" . htmlspecialchars($row['household_members']) . "</td>
                                    <td>" . htmlspecialchars($row['relationship_to_head']) . "</td>
                                    <td>" . htmlspecialchars($row['birthdate']) . "</td>
                                    <td>" . htmlspecialchars($row['age']) . "</td>
                                    <td>" . htmlspecialchars($row['gender']) . "</td>
                                    <td>" . htmlspecialchars($row['civil_status']) . "</td>
                                    <td>" . htmlspecialchars($row['person_with_disability']) . "</td>
                                    <td>" . htmlspecialchars($row['ethnicity']) . "</td>
                                    <td>" . htmlspecialchars($row['religion']) . "</td>
                                    <td>" . htmlspecialchars($row['highest_grade_completed']) . "</td>
                                    <td>" . htmlspecialchars($row['currently_attending_school']) . "</td>
                                    <td>" . htmlspecialchars($row['grade_level_enrolled']) . "</td>
                                    <td>" . htmlspecialchars($row['reasons_for_not_attending_school']) . "</td>
                                    <td>" . htmlspecialchars($row['can_read_write_simple_messages_inanylanguage']) . "</td>
                                    <td>" . htmlspecialchars($row['occupation']) . "</td>
                                    <td>" . htmlspecialchars($row['work']) . "</td>
                                    <td>" . htmlspecialchars($row['status']) . "</td>
                                  </tr>";
                            $row_num++;
                        }
                    } else {
                        echo "<tr><td colspan='17'>No members found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- Button Container -->
    <div class="button-container">
            <a href="dashboard.php" class="custom-button redirect">Back to Dashboard</a>
            <a href="get_record_id.php?member_id=<?php echo $member_id; ?>" class="custom-button edit" onclick="confirmCancel()">Edit Household Data</a>
            <button id="download-pdf" class="custom-button">Download PDF</button>
        </div>

    <script>
        // Get the housenumber from PHP
        const housenumber = "<?php echo isset($housenumber_row['housenumber']) ? htmlspecialchars($housenumber_row['housenumber']) : '0'; ?>";

        document.getElementById('download-pdf').addEventListener('click', function() {
            const element = document.getElementById('pdf-content');
            const opt = {
                margin:       1,
                filename:     'household_profile_' + housenumber + '.pdf', // Updated filename
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { orientation: 'landscape' } // Set to landscape
            };

            // Generate the PDF
            html2pdf().from(element).set(opt).save();
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
