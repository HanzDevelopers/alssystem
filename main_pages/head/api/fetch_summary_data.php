<?php
session_start();
// Include your database connection
include '../../../src/db/db_connection.php';

// Function to fetch count based on query
function getCount($conn, $query) {
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'] ?? 0; // Return 0 if 'count' key doesn't exist
    }
    return 0; // Return 0 if the query fails or no rows are returned
}

// Fetch the logged-in user's district
function getUserDistrict($conn, $userId) {
    $district = null; // Initialize the district variable
    $query = "SELECT district FROM user_tbl WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($district);
    $stmt->fetch();
    $stmt->close();
    return $district; // Return the district, or null if not found
}

// Fetch summary data based on the logged-in user's district
function getSummaryData($conn, $userDistrict) {
    // Initialize variables to default values
    $totalNotAttendingSchool = 0;
    $totalInterestedInAls = 0;
    $totalPersonsWithDisability = 0;
    $totalNoOccupation = 0;
    $totalLowIncomeFamilies = 0;
    $totalPopulation = 0; // Initialize total population

    // Total number of people aged 15-30 not currently attending school (NO/no)
    $notAttendingSchoolQuery = "
        SELECT COUNT(*) AS count
        FROM members_tbl m
        JOIN background_tbl b ON m.member_id = b.member_id
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE b.currently_attending_school IN ('NO', 'No', 'no')
        AND m.age BETWEEN 15 AND 30
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (
            (l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') AND '$userDistrict' = 'District 1') OR
            (l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') AND '$userDistrict' = 'District 2') OR
            (l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') AND '$userDistrict' = 'District 3') OR
            (l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') AND '$userDistrict' = 'District 4')
        )
    ";
    $totalNotAttendingSchool = getCount($conn, $notAttendingSchoolQuery);

    // Number of people interested in ALS (Yes/yes)
    $interestedInAlsQuery = "
        SELECT COUNT(*) AS count
        FROM background_tbl b
        JOIN members_tbl m ON b.member_id = m.member_id
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE b.status IN ('YES', 'Yes', 'yes')
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (
            (l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') AND '$userDistrict' = 'District 1') OR
            (l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') AND '$userDistrict' = 'District 2') OR
            (l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') AND '$userDistrict' = 'District 3') OR
            (l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') AND '$userDistrict' = 'District 4')
        )
    ";
    $totalInterestedInAls = getCount($conn, $interestedInAlsQuery);

    // Number of persons with disability (Yes/yes)
    $personsWithDisabilityQuery = "
        SELECT COUNT(*) AS count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE m.person_with_disability IN ('YES', 'Yes', 'yes')
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (
            (l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') AND '$userDistrict' = 'District 1') OR
            (l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') AND '$userDistrict' = 'District 2') OR
            (l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') AND '$userDistrict' = 'District 3') OR
            (l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') AND '$userDistrict' = 'District 4')
        )
    ";
    $totalPersonsWithDisability = getCount($conn, $personsWithDisabilityQuery);

    // Number of people with no occupation (NO/no)
    $noOccupationQuery = "
        SELECT COUNT(*) AS count
        FROM background_tbl b
        JOIN members_tbl m ON b.member_id = m.member_id
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE b.occupation IN ('NO', 'No', 'no')
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (
            (l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') AND '$userDistrict' = 'District 1') OR
            (l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') AND '$userDistrict' = 'District 2') OR
            (l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') AND '$userDistrict' = 'District 3') OR
            (l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') AND '$userDistrict' = 'District 4')
        )
    ";
    $totalNoOccupation = getCount($conn, $noOccupationQuery);

    // Number of families with income below 20,000 pesos
    $lowIncomeFamiliesQuery = "
        SELECT COUNT(*) AS count
        FROM location_tbl l
        WHERE l.estimated_family_income < 20000
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (
            (l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') AND '$userDistrict' = 'District 1') OR
            (l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') AND '$userDistrict' = 'District 2') OR
            (l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') AND '$userDistrict' = 'District 3') OR
            (l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') AND '$userDistrict' = 'District 4')
        )
    ";
    $totalLowIncomeFamilies = getCount($conn, $lowIncomeFamiliesQuery);

    // Total population query
    $totalPopulationQuery = "
        SELECT COUNT(*) AS count
        FROM members_tbl m
        JOIN location_tbl l ON m.record_id = l.record_id
        WHERE YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (
            (l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') AND '$userDistrict' = 'District 1') OR
            (l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') AND '$userDistrict' = 'District 2') OR
            (l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') AND '$userDistrict' = 'District 3') OR
            (l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') AND '$userDistrict' = 'District 4')
        )
    ";
    $totalPopulation = getCount($conn, $totalPopulationQuery);

    return [
        'not_attending_school' => $totalNotAttendingSchool,
        'interested_in_als' => $totalInterestedInAls,
        'persons_with_disability' => $totalPersonsWithDisability,
        'no_occupation' => $totalNoOccupation,
        'low_income_families' => $totalLowIncomeFamilies,
        'total_population' => $totalPopulation, // Return total population
    ];
}

// Main code execution
$userId = $_SESSION['user_id'] ?? null; // Replace with actual session variable for user ID

if ($userId) {
    $userDistrict = getUserDistrict($conn, $userId);
    if ($userDistrict) {
        $summaryData = getSummaryData($conn, $userDistrict);
        // Now you can use $summaryData for displaying in your UI
    } else {
        // Handle case where no district is found for the user
        echo "No district found for the user.";
    }
} else {
    echo "User ID not found.";
}
?>
