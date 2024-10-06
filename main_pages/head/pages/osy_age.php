<?php
include '../../../src/db/db_connection.php';
// Get the current year
$current_year = date("Y");

// Query to get total number of household members for the current year
$total_population_query = "
    SELECT COUNT(*) AS total_population
    FROM members_tbl m
    JOIN location_tbl l ON l.record_id = m.record_id
    WHERE YEAR(l.date_encoded) = $current_year";
$total_population_result = $conn->query($total_population_query);
$total_population = $total_population_result->fetch_assoc()['total_population'];

// Query to get total number of OSY for the current year regardless of district
$total_osy_query = "SELECT COUNT(*) AS total_osy 
                    FROM members_tbl m 
                    JOIN background_tbl b ON m.member_id = b.member_id 
                    JOIN location_tbl l ON l.record_id = m.record_id
                    WHERE b.currently_attending_school IN ('No', 'no', 'NO') 
                    AND m.age BETWEEN 15 AND 30
                    AND YEAR(l.date_encoded) = $current_year";
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
                     AND YEAR(l.date_encoded) = $current_year";

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
                           AND LOWER(m.gender) NOT IN ('male', 'female', 'm', 'f')";

$undefined_gender_result = $conn->query($undefined_gender_query);
$undefined_gender_count = $undefined_gender_result->fetch_assoc()['undefined_gender_count'];

?>

<?php
// Include necessary files
include '../../../src/db/db_connection.php';
// District mapping
$district_mapping = [
    'Tankulan' => 'District 1',
    'Diklum' => 'District 1',
    'San Miguel' => 'District 1',
    'Ticala' => 'District 1',
    'Lingion' => 'District 1',
    'Alae' => 'District 2',
    'Damilag' => 'District 2',
    'Mambatangan' => 'District 2',
    'Mantibugao' => 'District 2',
    'Minsuro' => 'District 2',
    'Lunocan' => 'District 2',
    'Agusan canyon' => 'District 3',
    'Mampayag' => 'District 3',
    'Dahilayan' => 'District 3',
    'Sankanan' => 'District 3',
    'Kalugmanan' => 'District 3',
    'Lindaban' => 'District 3',
    'Dalirig' => 'District 4',
    'Maluko' => 'District 4',
    'Santiago' => 'District 4',
    'Guilang2' => 'District 4'
];

// Get the current year
$current_year = date('Y');

// Pagination setup
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Base query
$query = "SELECT m.household_members AS name, m.age, l.barangay, l.sitio_zone_purok, l.housenumber, 
                 b.highest_grade_completed, b.currently_attending_school, b.reasons_for_not_attending_school 
          FROM members_tbl m
          JOIN location_tbl l ON m.record_id = l.record_id
          JOIN background_tbl b ON m.member_id = b.member_id
          WHERE m.age BETWEEN 15 AND 30
          AND LOWER(b.currently_attending_school) = 'no'";

// Adjusting the query to allow for year searches
if (!empty($search)) {
    $search = strtolower($search);
    // Check if the search term is a valid year
    if (preg_match('/^\d{4}$/', $search)) {
        $query .= " AND YEAR(l.date_encoded) = '$search'";
    } else {
        $query .= " AND (m.age LIKE '%$search%' OR l.barangay LIKE '%$search%' 
                         OR LOWER(b.currently_attending_school) LIKE '%$search%' 
                         OR LOWER(b.reasons_for_not_attending_school) LIKE '%$search%')";
    }
} else {
    // If no search term is provided, filter by the current year
    $query .= " AND YEAR(l.date_encoded) = $current_year";
}

$query .= " ORDER BY m.age ASC LIMIT $limit OFFSET $offset";

// Get total records for pagination
$total_query = "SELECT COUNT(*) as total FROM members_tbl m
                JOIN location_tbl l ON m.record_id = l.record_id
                JOIN background_tbl b ON m.member_id = b.member_id
                WHERE m.age BETWEEN 15 AND 30
                AND LOWER(b.currently_attending_school) = 'no'";

if (!empty($search)) {
    // Check if the search term is a valid year
    if (preg_match('/^\d{4}$/', $search)) {
        $total_query .= " AND YEAR(l.date_encoded) = '$search'";
    } else {
        $total_query .= " AND (m.age LIKE '%$search%' OR l.barangay LIKE '%$search%' 
                              OR LOWER(b.currently_attending_school) LIKE '%$search%' 
                              OR LOWER(b.reasons_for_not_attending_school) LIKE '%$search%')";
    }
} else {
    // If no search term is provided, filter by the current year
    $total_query .= " AND YEAR(l.date_encoded) = $current_year";
}

$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>OSY by Age</title>
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
    .active2 {
        background-color: #b9b9b9;
        color: white;
    }

    .active1 {
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
        background-color: #007bff; /* Blue */
        color: white;
    }

    .card-osy-gender {
        background-color: #6185ad; /* Blue */
        color: white;
    }

    .card-osy-district {
        background-color: #28a745; /* Green */
        color: white;
    }

    .card-osy-district:nth-child(1) {
        background-color: #dc3545; /* Red */
    }

    .card-osy-district:nth-child(2) {
        background-color: #ffc107; /* Yellow */
    }

    .card-osy-district:nth-child(3) {
        background-color: #17a2b8; /* Teal */
    }

    /* New style for Total Population card */
    .card-total-population {
        background-color: rgb(108 117 125);
        color: white;
    }

    /* Ensure responsive card sizes */
    .card {
        min-width: 200px; /* Minimum width for cards */
        height: 100%; /* Full height to align cards */
    }

    /* Margin below each card */
    .mb-3 {
        margin-bottom: 1rem; /* Space below cards */
    }

    .card-text {
        color: white;
    }

    .mt-4 {
        margin-bottom: 50px;
    }
    .card-body h5 {
    font-size: 1.2rem;
    color: darkslategray;
    }

    .card-body p {
        font-size: 1.5rem;
    }

</style>


<body>
<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header" style="background: gray;">
                <h3 style="color: #ffffff;">
                    <?php
                    session_start();
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

            <li class="sidebar-header">
                        Key Performans Indicator
                    </li>
                    <li class="sidebar-item">
                        <a href="dashboard.php" class="sidebar-link">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-header">
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
                                <a href="district_osy.php" class="sidebar-link">District OSY</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="district_population.php" class="sidebar-link">District Population</a>
                            </li>
                            <li class="sidebar-item active2">
                                <a href="OSY_age.php" class="sidebar-link">OSY By Age</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="interested.php" class="sidebar-link">List of Interested in ALS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
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
                            Auth
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
                <span class="menu-text">OSY by Age</span>
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
            <div class="card text-center card-total-population">
                <div class="card-body">
                    <h5 class="card-title">Total Population</h5>
                    <p class="card-text"><?php echo $total_population; ?></p>
                </div>
            </div>
        </div>

        <!-- Total OSY Card -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-total">
                <div class="card-body">
                    <h5 class="card-title">Total OSY</h5>
                    <p class="card-text"><?php echo $total_osy; ?></p>
                </div>
            </div>
        </div>

        <!-- Gender OSY Card (Male, Female, Undefined) -->
        <div class="col-12 col-sm-6 col-md-8 col-lg-6 mb-3"> <!-- Set to double width -->
            <div class="card text-center card-osy-gender">
                <div class="card-body">
                    <h5 class="card-title">OSY Genders</h5>
                    <p class="card-text d-inline">Males: <?php echo $total_males; ?></p>
                    <p class="card-text d-inline ms-3">Females: <?php echo $total_females; ?></p>
                    <p class="card-text d-inline ms-3">Other: <?php echo $undefined_gender_count; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: District OSY Cards -->
    <div class="row justify-content-center">
        <!-- District OSY Cards -->
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
    </div>
</div>  
</div>





<div class="container my-4">
    <h2 class="mb-4">OSY By Age (Ages 15-30, Not Attending School)</h2>
    
    <!-- Search Form -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by Age, or Year encoded" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="osy_age.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Download Options -->
     
<P>TO DOWNLOAD SPECIFIC DATA, PLEASE USE THE SEARCH BAR</P>
    <div class="mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Download Data
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../download_functions/osy_by_age_download.php?type=csv&search=<?php echo urlencode($search); ?>">Download CSV</a></li>
                <li><a class="dropdown-item" href="../download_functions/osy_by_age_download.php?type=excel&search=<?php echo urlencode($search); ?>">Download Excel</a></li>
            </ul>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>District</th>
            <th>Address</th>
            <th>Highest Grade/Year Completed</th>
            <th>Currently Attending School</th>
            <th>Interested in ALS</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars(isset($district_mapping[$row['barangay']]) ? $district_mapping[$row['barangay']] : 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($row['sitio_zone_purok'] . ', ' . $row['housenumber']); ?></td>
                    <td><?php echo htmlspecialchars($row['highest_grade_completed']); ?></td>
                    <td><?php echo htmlspecialchars($row['currently_attending_school']); ?></td>
                    <td><?php echo htmlspecialchars(stripos($row['reasons_for_not_attending_school'], 'ALS') !== false ? 'Yes' : 'No'); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No data found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

</div>









</div>
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