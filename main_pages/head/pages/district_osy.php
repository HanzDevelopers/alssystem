<?php
// Database connection
include '../../../src/db/db_connection.php';

// Start the session if it hasn't already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debugging statement to check if session variables are set
if (!isset($_SESSION['username']) || !isset($_SESSION['district']) || !isset($_SESSION['user_type'])) {
    echo "Session variables:";
    var_dump($_SESSION); // This will display all session variables for debugging
}

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../../../index.php');
    exit();
}

// Check if district is set in session
if (!isset($_SESSION['district'])) {
    echo "District is not set.";
    exit();
}

// Get the logged-in user's district and user type from the session
$logged_in_district = $_SESSION['district'];
$logged_in_user_type = $_SESSION['user_type'];

// Define the barangay to district mapping
$district_mapping = [
    'District 1' => ['Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion'],
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
                            WHEN l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
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
                WHEN l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
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

<?php
include '../../../src/db/db_connection.php';



// Get the logged-in user's district
$logged_in_district = $_SESSION['district'];

// Define the barangay to district mapping
$district_mapping = [
    'District 1' => ['Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion'],
    'District 2' => ['Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan'],
    'District 3' => ['Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban'],
    'District 4' => ['Dalirig', 'Maluko', 'Santiago', 'Guilang2'],
];

// Create a condition based on the district mapping for the logged-in user's district
$barangay_conditions = [];
if (array_key_exists($logged_in_district, $district_mapping)) {
    foreach ($district_mapping[$logged_in_district] as $barangay) {
        $barangay_conditions[] = "l.barangay = '" . mysqli_real_escape_string($conn, $barangay) . "'";
    }
}

$barangay_condition_sql = implode(' OR ', $barangay_conditions);

// Get the current year
$current_year = date("Y");

// Query to get total number of household members for the current year
$total_population_query = "
    SELECT COUNT(*) AS total_population
    FROM members_tbl m
    JOIN location_tbl l ON l.record_id = m.record_id
    WHERE YEAR(l.date_encoded) = $current_year
    AND ($barangay_condition_sql)";
$total_population_result = $conn->query($total_population_query);
$total_population = $total_population_result->fetch_assoc()['total_population'];

// Query to get total number of OSY for the current year for the user's district
$total_osy_query = "SELECT COUNT(*) AS total_osy 
                    FROM members_tbl m 
                    JOIN background_tbl b ON m.member_id = b.member_id 
                    JOIN location_tbl l ON l.record_id = m.record_id
                    WHERE b.currently_attending_school IN ('No', 'no', 'NO') 
                    AND m.age BETWEEN 15 AND 30
                    AND YEAR(l.date_encoded) = $current_year
                    AND ($barangay_condition_sql)";
$total_osy_result = $conn->query($total_osy_query);
$total_osy = $total_osy_result->fetch_assoc()['total_osy'];

// Query to get total number of OSY for each district for the current year
$district_osy_query = "
    SELECT 
        CASE 
            WHEN l.barangay IN ('Tankulan', 'Diklum', 'San Miguel', 'Ticala', 'Lingion') THEN 'District 1'
            WHEN l.barangay IN ('Alae', 'Damilag', 'Mambatangan', 'Mantibugao', 'Minsuro', 'Lunocan') THEN 'District 2'
            WHEN l.barangay IN ('Agusan canyon', 'Mampayag', 'Dahilayan', 'Sankanan', 'Kalugmanan', 'Lindaban') THEN 'District 3'
            WHEN l.barangay IN ('Dalirig', 'Maluko', 'Santiago', 'Guilang2') THEN 'District 4'
            ELSE 'Unknown District'
        END AS district,
        COUNT(*) AS total_osy
    FROM members_tbl m
    JOIN background_tbl b ON m.member_id = b.member_id
    JOIN location_tbl l ON l.record_id = m.record_id
    WHERE b.currently_attending_school IN ('No', 'no', 'NO') 
    AND m.age BETWEEN 15 AND 30
    AND YEAR(l.date_encoded) = $current_year
    AND ($barangay_condition_sql)
    GROUP BY district";

$district_osy_result = $conn->query($district_osy_query);
$district_data = [];
while ($row = $district_osy_result->fetch_assoc()) {
    $district_data[$row['district']] = $row['total_osy'];
}

// Query to get total number of males and females for the current year (case-insensitive, including 'm' and 'f')
$gender_osy_query = "SELECT 
                        SUM(CASE WHEN LOWER(m.gender) IN ('male', 'm') THEN 1 ELSE 0 END) AS total_males, 
                        SUM(CASE WHEN LOWER(m.gender) IN ('female', 'f') THEN 1 ELSE 0 END) AS total_females
                     FROM members_tbl m
                     JOIN background_tbl b ON m.member_id = b.member_id
                     JOIN location_tbl l ON l.record_id = m.record_id
                     WHERE b.currently_attending_school IN ('No', 'no', 'NO') 
                     AND m.age BETWEEN 15 AND 30
                     AND YEAR(l.date_encoded) = $current_year
                     AND ($barangay_condition_sql)";

$gender_osy_result = $conn->query($gender_osy_query);
$gender_osy_data = $gender_osy_result->fetch_assoc();
$total_males = $gender_osy_data['total_males'];
$total_females = $gender_osy_data['total_females'];

// Query to count records with undefined or invalid gender (excluding 'Male', 'Female', 'm', 'f')
$undefined_gender_query = "SELECT COUNT(*) AS undefined_gender_count 
                           FROM members_tbl m
                           JOIN background_tbl b ON m.member_id = b.member_id
                           JOIN location_tbl l ON l.record_id = m.record_id
                           WHERE b.currently_attending_school IN ('No', 'no', 'NO') 
                           AND m.age BETWEEN 15 AND 30
                           AND YEAR(l.date_encoded) = $current_year
                           AND ($barangay_condition_sql)
                           AND LOWER(m.gender) NOT IN ('male', 'female', 'm', 'f')";

$undefined_gender_result = $conn->query($undefined_gender_query);
$undefined_gender_count = $undefined_gender_result->fetch_assoc()['undefined_gender_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>District OSY</title>
    <!-- Bootstrap CSS CDN --> 
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

<!--For SimpleStatistics-->
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://unpkg.com/simple-statistics@7.0.2/dist/simple-statistics.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simple-statistics/7.8.1/simple-statistics.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<style>
    
    .active2{
    background-color: #b9b9b9;
    color: white;
}

.active1{
    background-color: #515151;
    color: white;
}
    /* Ensure container pushes content down */
    .container-fluid {
        margin-top: 1px;
        margin-bottom: 50px;
    }
   
    /* Card Styles */
.card-osy-total {
    background-color: #90D5ff; /* Soft Red */
    color: white;
}

.card-osy-gender {
    background-color: #90D5ff; /* Soft Orange */
    color: white;
}

.card-osy-district {
    background-color: #90D5ff; /* Soft Yellow */
    color: #333; /* Dark text for better contrast on yellow */
}

.card-osy-district:nth-child(1) {
    background-color: #51cf66; /* Soft Green */
    color: white;
}

.card-osy-district:nth-child(2) {
    background-color: #74c0fc; /* Soft Blue */
    color: white;
}

.card-osy-district:nth-child(3) {
    background-color: #9775fa; /* Soft Indigo */
    color: white;
}

/* New style for Total Population card */
.card-total-population {
    background-color: #90D5ff; /* Soft Violet/Pink */
    color: white;
}

/* Ensure responsive card sizes */
.card {
    min-width: 220px;
    height: 100%;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Lighter shadow for subtle depth */
    transition: transform 0.3s ease, background-color 0.3s ease;
}

/* Margin below each card */
.mb-3 {
    margin-bottom: 1.5rem;
}

.card-text {
    color: white;
}

/* Larger spacing for better visual separation */
.mt-4 {
    margin-bottom: 60px;
}

/* Headings inside cards */
.card-body h5 {
    font-size: 15px;
    color: #333; /* Dark text for readability */
}
/* Paragraphs inside cards */
.card-body p {
    font-size: 2rem;
    font-weight: bold;
    color: #ffffff; /* Consistent white text */
}

/* Target the age range labels to be black */
.card-body .age-range-label {
    font-size: 1rem;
    color: #000000; /* Black text for the age range labels */
}

/* Hover effect for interactive cards */
.card:hover {
    transform: translateY(-5px); /* Subtle lift effect */
    background-color: #f1f3f5; /* Light grey on hover for contrast */
    color: #333;
}

/* Change the paragraph text color to black on hover */
.card:hover .card-body p {
    color: #000000; /* Black text on hover */
}
</style>

<body>
<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header" style="background: gray;">
                <h3 style="color: #ffffff;">
                    <?php
                    if (!isset($_SESSION['username'])) {
                        header('Location: ../../../index.php');
                        exit();
                    }
                    if (isset($_SESSION['username'])) {
                        echo '<a href="#">' . htmlspecialchars($_SESSION['username']) . '</a>';
                    } else {
                        echo '<a href="#">Admin</a>';
                    }
                ?>
            </h3>
                
                </div>
    
                <li class="sidebar-header title" style="
        font-weight: bold; color:gray;">
                            Key Performans Indicator
                        </li>
                        <li class="sidebar-item">
                            <a href="dashboard.php" class="sidebar-link">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="sidebar-header" style="
        font-weight: bold; color:gray;">
                            Tools & Components
                        </li>
                        <li class="sidebar-item">
                    <a href="#" id="formLink" class="sidebar-link">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                        Form
                    </a>
                </li>
                        <li class="sidebar-item">
                            <a href="reports.php" class="sidebar-link collapsed active1" data-bs-toggle="collapse" data-bs-target="#pages"
                                aria-expanded="false" aria-controls="pages">
                                <i class="fa-solid fa-list pe-2"></i>
                                Reports
                            </a>
                            <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                    <a href="records.php" class="sidebar-link">Household Records</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="district_osy.php" class="sidebar-link active2">District OSY</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="district_population.php" class="sidebar-link">District Population</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="osy_age.php" class="sidebar-link">OSY By Age</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="interested.php" class="sidebar-link">List of Interested in ALS</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="persons_with_disability.php" class="sidebar-link">Persons with Disability</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="no_occupation.php" class="sidebar-link">No Occupation</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="income_below_20,000.php" class="sidebar-link">Income Below 20,000</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-header" style="
        font-weight: bold; color:gray;">
                            Admin Action
                        </li>
                        <li class="sidebar-item">
                            <a href="users.php" class="sidebar-link">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                                Users
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="user_log.php" class="sidebar-link">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                                User Log
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                                aria-expanded="false" aria-controls="auth">
                                <i class="fa-regular fa-user pe-2"></i>
                                Account Settings
                            </a>
                            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                              
                            <li class="sidebar-item">
                                    <a href="edit_profile.php" class="sidebar-link">Edit Profile</a>
                                </li>
                                <li class="sidebar-item">
                                <a href="logout.php" class="sidebar-link" onclick="return confirmLogout();">Log Out</a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
            </nav>


        <!-- Modal Structure -->
    <div class="modal fade" id="csvModal" tabindex="-1" aria-labelledby="csvModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="csvModalLabel">Choose an Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>What would you like to do?</p>
                    <button type="button" id="uploadCsvBtn" class="btn btn-outline-primary btn-lg mb-3">Upload CSV File</button><br>
                    <button type="button" id="goToFormBtn" class="btn btn-primary btn-lg">Go to Form</button>
                </div>
            </div>
        </div>
    </div>
    

        <!-- Page Content  -->
        <div id="content">
            
            <div class="menu-header">
                <button type="button" id="sidebarCollapse" class="btn menu-btn">
                    <img src="../../../assets/images/burger-bar.png" alt="Menu" width="30" style="margin-left: 10px;">
                </button>
                <span class="menu-text">Manolo Fortich OSY</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
            
    

        
        <!-- Main Content Starts Here -->
         
        <div class="container-fluid">
    <!-- <div class="content p-3">
        <div class="row">
            Container for charts
            <div class="dashboard-container">
    
    Chart 1: District OSY Pie Chart
    <div class="chart-card">
        <div id="pie-chart" class="chart"></div>
    </div>
    
</div>

        </div>
    </div> -->
    <div class="container mt-4">
    <!-- First Row: Total Population, Total OSY, and Gender Cards -->
    <div class="row justify-content-center mb-3">
        <!-- Total Population Card -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-total-population" style="cursor: pointer;" onclick="window.location.href='district_population.php';">
                <div class="card-body">
                    <h5 class="card-title" style="font-weight: bold;">District Total Population</h5>
                    <p class="card-text"><?php echo $total_population; ?></p>
                </div>
            </div>
        </div>

        <!-- Total OSY Card -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-total" style="cursor: pointer;" onclick="window.location.href='district_osy.php';">
                <div class="card-body">
                    <h5 class="card-title" style="font-weight: bold;">District Total OSY</h5>
                    <p class="card-text"><?php echo $total_osy; ?></p>
                </div>
            </div>
        </div>

        <!-- Gender OSY Card (Male, Female, Undefined) -->
        <div class="col-12 col-sm-6 col-md-8 col-lg-6 mb-3"> <!-- Set to double width -->
            <div class="card text-center card-osy-gender" onclick="window.location.href='osy_age.php';">
                <div class="card-body">
                    <h5 class="card-title" style="font-weight: bold;">District OSY Genders</h5>
                    <p class="card-text d-inline">
                    <span class="age-range-label">Males:</span> <?php echo $total_males; ?></p>
                    <p class="card-text d-inline ms-3">
                    <span class="age-range-label">Females:</span> <?php echo $total_females; ?></p>
                    <p class="card-text d-inline ms-3">
                    <span class="age-range-label">Other:</span> <?php echo $undefined_gender_count; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: District OSY Cards 
    <div class="row justify-content-center">
        <!-- District OSY Cards
        <?php foreach ($district_data as $district => $count): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-district">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $district; ?></h5>
                    <p class="card-text"><?php echo $count; ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>-->
</div>
</div>





    <!-- Search Form -->
<form method="GET" action="">
    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search by District, Household Members, House Number, or Date Encoded" value="<?php echo $search; ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="district_osy.php" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>
<P>TO DOWNLOAD SPECIFIC DATA, PLEASE USE THE SEARCH BAR</P>
<!-- Dropdown for Download Options -->
<div class="mb-3">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="downloadMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Download
    </button>
    <div class="dropdown-menu" aria-labelledby="downloadMenuButton">
        <a class="dropdown-item" href="../download_functions/download_district_osy.php?type=excel&search=<?php echo $search; ?>">Download as Excel</a>
        <a class="dropdown-item" href="../download_functions/download_district_osy.php?type=csv&search=<?php echo $search; ?>">Download as CSV</a>
    </div>
</div>

<!-- Display Table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>District</th>
            <th>House Number</th>
            <th>Sitio/Zone/Purok</th>
            <th>Household Members</th>
            <th>Estimated Family Income</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['district']); ?></td>
            <td><?php echo htmlspecialchars($row['housenumber']); ?></td>
            <td><?php echo htmlspecialchars($row['sitio_zone_purok']); ?></td>
            <td><?php echo htmlspecialchars($row['household_members']); ?></td>
            <td><?php echo htmlspecialchars($row['estimated_family_income']); ?></td>
            <td>
                <!-- View Info Button -->
                <button class='btn btn-primary view-info-btn' data-member-id='<?php echo $row["member_id"]; ?>'>View Info</button>
                <!-- Delete Button -->
                <button class='btn btn-danger delete-member-btn' data-member-id='<?php echo $row["member_id"]; ?>'>Delete</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Pagination Links (Centered) -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php if($i == $page) echo 'active'; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>


<footer class="footer" style="margin-top: 100px; padding: 0px 110px 0px 110px;">
    <div class="container">
        <div class="footer-content">
            <!-- Partnership Logos and Description -->
            <div class="footer-section about">
                <div class="logos">
                    <img src="../../../assets/images/logo.png" alt="Your Logo" class="partner-logo">
                    <img src="../../../assets/images/logo1.png" alt="ALS Logo" class="partner-logo">
                </div>
                <p>In partnership with the <strong>Alternative Learning System (ALS)</strong>, we aim to collect and analyze profiles of out-of-school youth, helping create better programs and initiatives tailored to their needs.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about-us.html">About Us</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="footer-section contact">
                <h4>Contact Us</h4>
                <p><i class="fas fa-phone-alt"></i> +63 123 4567 890</p>
                <p><i class="fas fa-envelope"></i> info@household-info-system.com</p>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 Household Information System in Manolo Fortich. All rights reserved.</p>
        </div>
    </div>
</footer>
</div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

<!-- JavaScript to handle the View Info button click event -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewInfoButtons = document.querySelectorAll('.view-info-btn');
        
        viewInfoButtons.forEach(button => {
            button.addEventListener('click', function() {
                const memberId = this.getAttribute('data-member-id');
                window.location.href = 'district_osy_household_members.php?member_id=' + memberId;
            });
        });
    });

    // JavaScript function to handle the Delete button
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-member-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const memberId = this.getAttribute('data-member-id');
                if (confirm("Are you sure you want to delete this record?")) {
                    window.location.href = 'district_osy_delete_member.php?member_id=' + memberId;
                }
            });
        });
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="../js/form.js"></script>
</body>

</html>
<?php
// Close the database connection
mysqli_close($conn);
?>