<?php
// Database connection
include '../../../src/db/db_connection.php';

if (!isset($_SESSION['district'])) {
    die("District not set in session.");
}

// Get the logged-in user's district
$logged_in_district = $_SESSION['district'];

// Define the barangay to district mapping
$district_mapping = [
    'District 1' => ['Tankulan', 'Diklum', 'Diclum', 'San Miguel', 'Ticala', 'Lingion'],
    'District 2' => ['Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan'],
    'District 3' => ['Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban'],
    'District 4' => ['Dalirig', 'Maluko', 'Santiago', 'Guilang2'],
];

// Create a condition based on the district mapping
$barangay_conditions = [];
if (array_key_exists($logged_in_district, $district_mapping)) {
    foreach ($district_mapping[$logged_in_district] as $barangay) {
        $barangay_conditions[] = "l.barangay = '" . mysqli_real_escape_string($conn, $barangay) . "'";
    }
}

$barangay_condition_sql = implode(' OR ', $barangay_conditions);

// Set pagination variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle search query
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = '';
if (!empty($search)) {
    $search_query = " AND (m.household_members LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
                        OR l.housenumber LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
                        OR l.date_encoded LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
                        OR (CASE 
                            WHEN l.barangay IN ('Tankulan', 'Diklum', 'Diclum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
                            WHEN l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') THEN 'District 2'
                            WHEN l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') THEN 'District 3'
                            WHEN l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') THEN 'District 4'
                            ELSE 'Unknown District'
                        END) LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
}

// SQL query with LIMIT and OFFSET for pagination, including search and district filtering
$query = "SELECT 
            m.member_id,
            CASE 
                WHEN l.barangay IN ('Tankulan', 'Diklum', 'Diclum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
                WHEN l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') THEN 'District 2'
                WHEN l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') THEN 'District 3'
                WHEN l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') THEN 'District 4'
                ELSE 'Unknown District'
            END AS district,
            l.housenumber,
            l.sitio_zone_purok,
            m.household_members,
            l.estimated_family_income
          FROM 
            location_tbl l
          JOIN 
            members_tbl m ON l.record_id = m.record_id
          JOIN 
            background_tbl b ON m.member_id = b.member_id
          WHERE 
            b.currently_attending_school IN ('No', 'no', 'NO')
            AND m.age BETWEEN 15 AND 30
            AND ($barangay_condition_sql)
            $search_query
          LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

// Count total records for pagination, including search and district filtering
$count_query = "SELECT COUNT(*) as total 
                FROM location_tbl l 
                JOIN members_tbl m ON l.record_id = m.record_id
                JOIN background_tbl b ON m.member_id = b.member_id
                WHERE b.currently_attending_school IN ('No', 'no', 'NO') 
                AND m.age BETWEEN 15 AND 30
                AND ($barangay_condition_sql)
                $search_query";

$count_result = $conn->query($count_query);
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);
?>
