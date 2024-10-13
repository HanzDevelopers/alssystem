<?php
// Include your database connection
include '../../../src/db/db_connection.php';

// Function to fetch count based on query
function getCount($conn, $query) {
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Fetch summary data
function getSummaryData($conn) {
    // Total number of people aged 15-30 not currently attending school (NO/no)
    $notAttendingSchoolQuery = "
        SELECT COUNT(*) AS count
        FROM members_tbl m
        JOIN background_tbl b ON m.member_id = b.member_id
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE b.currently_attending_school IN ('NO', 'No', 'no')
        AND m.age BETWEEN 15 AND 30
        AND YEAR(l.date_encoded) = YEAR(CURDATE());
    ";
    $totalNotAttendingSchool = getCount($conn, $notAttendingSchoolQuery);

    // Number of people interested in ALS (Yes/yes)
    $interestedInAlsQuery = "
        SELECT COUNT(*) AS count
        FROM background_tbl b
        JOIN members_tbl m ON b.member_id = m.member_id
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE b.status IN ('YES', 'Yes', 'yes')
        AND YEAR(l.date_encoded) = YEAR(CURDATE());
    ";
    $totalInterestedInAls = getCount($conn, $interestedInAlsQuery);

   // Number of persons with disability (excluding N/A)
   $personsWithDisabilityQuery = "
   SELECT COUNT(*) AS count
   FROM members_tbl m
   JOIN location_tbl l ON m.record_id = l.record_id
   WHERE LOWER(m.person_with_disability) NOT IN ('n/a', 'no', 'none')
   AND YEAR(l.date_encoded) = YEAR(CURDATE());
   ";
   
   $totalPersonsWithDisability = getCount($conn, $personsWithDisabilityQuery);
   

    // Number of people with no occupation (NO/no)
    $noOccupationQuery = "
        SELECT COUNT(*) AS count
        FROM background_tbl b
        JOIN members_tbl m ON b.member_id = m.member_id
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE b.occupation IN ('NO', 'No', 'no')
        AND YEAR(l.date_encoded) = YEAR(CURDATE());
    ";
    $totalNoOccupation = getCount($conn, $noOccupationQuery);

    // Number of families with income below 20,000 pesos
    $lowIncomeFamiliesQuery = "
        SELECT COUNT(*) AS count
        FROM location_tbl l
        WHERE l.estimated_family_income < 20000
        AND YEAR(l.date_encoded) = YEAR(CURDATE());
    ";
    $totalLowIncomeFamilies = getCount($conn, $lowIncomeFamiliesQuery);

    // Total Population based on household members (split by commas)
    $populationQuery = "
        SELECT 
            SUM(LENGTH(m.household_members) - LENGTH(REPLACE(m.household_members, ',', '')) + 1) AS count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE YEAR(l.date_encoded) = YEAR(CURDATE());
    ";
    $totalPopulation = getCount($conn, $populationQuery);

    // Return the data as an array
    return [
        'notAttendingSchool' => $totalNotAttendingSchool,
        'interestedInAls' => $totalInterestedInAls,
        'personsWithDisability' => $totalPersonsWithDisability,
        'noOccupation' => $totalNoOccupation,
        'lowIncomeFamilies' => $totalLowIncomeFamilies,
        'totalPopulation' => $totalPopulation, // Added Total Population
    ];
}

// Fetch the summary data
$data = getSummaryData($conn);

// Close the connection after fetching the data
$conn->close();
