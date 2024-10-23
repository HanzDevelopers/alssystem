<?php
// Database connection
include '../../../src/db/db_connection.php';

if (isset($_POST['upload'])) {
    $file = $_FILES['file']['tmp_name'];

    // Expected CSV headers
    $expectedHeaders = [
        'encoder_name', 'date_encoded', 'province', 'city_municipality', 'barangay', 'sitio_zone_purok', 'housenumber', 'estimated_family_income', 
        'notes', 'household_members', 'relationship_to_head', 'birthdate', 'age', 'gender', 'civil_status', 
        'person_with_disability', 'ethnicity', 'religion', 'highest_grade_completed', 'currently_attending_school', 
        'grade_level_enrolled', 'reasons_for_not_attending_school', 
        'can_read_write_simple_messages_inanylanguage', 'occupation', 'work', 'status'
    ];

    // Open the CSV file
    if (($handle = fopen($file, 'r')) !== FALSE) {
        $header = fgetcsv($handle, 1000, ","); // Read the first row (header)

        // Check if the headers match the expected format
        if ($header === $expectedHeaders) {
            // Process the CSV rows
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                insertLocation($conn, $data); // Use the connection from db_connection.php
            }
            fclose($handle);

            // Alert success and redirect
            echo "<script>
                    alert('CSV file successfully uploaded and processed!');
                    window.location.href = 'form_upload_csv.php';
                  </script>";
        } else {
            // If headers don't match, show an error message
            echo "<script>
                    alert('CSV format does not match. Please check the format and try again.');
                    window.location.href = 'form_upload_csv.php'; // Redirect to form_upload_csv.php
                  </script>";
        }
    } else {
        echo "<script>
                alert('Failed to open the file!');
                window.location.href = 'form_upload_csv.php'; // Redirect to form_upload_csv.php
              </script>";
    }
}

function insertLocation($db, $data) {
    // Insert into `location_tbl`
    $stmt = $db->prepare("INSERT INTO location_tbl (encoder_name, date_encoded, province, city_municipality, barangay, sitio_zone_purok, housenumber, estimated_family_income, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);
    $stmt->execute();

    // Get the auto-incremented record_id
    $record_id = $db->insert_id;

    // Insert members and background information
    insertMemberAndBackground($db, $record_id, $data);
}

function insertMemberAndBackground($db, $record_id, $data) {
    // Insert into `members_tbl`
    $stmt = $db->prepare("INSERT INTO members_tbl (record_id, household_members, relationship_to_head, birthdate, age, gender, civil_status, person_with_disability, ethnicity, religion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssisssss", $record_id, $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[17]);
    $stmt->execute();

    // Get the auto-incremented member_id
    $member_id = $db->insert_id;

    // Insert into `background_tbl`
    insertBackground($db, $member_id, $data);
}

function insertBackground($db, $member_id, $data) {
    // Insert into `background_tbl`
    $stmt = $db->prepare("INSERT INTO background_tbl (member_id, highest_grade_completed, currently_attending_school, grade_level_enrolled, reasons_for_not_attending_school, can_read_write_simple_messages_inanylanguage, occupation, work, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $member_id, $data[18], $data[19], $data[20], $data[21], $data[22], $data[23], $data[24], $data[25]);
    $stmt->execute();
}
?>
