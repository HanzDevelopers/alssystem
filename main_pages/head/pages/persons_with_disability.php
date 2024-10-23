<?php
// Database connection
include '../../../src/db/db_connection.php';
// Start the session if it hasn't already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and the district is set
if (!isset($_SESSION['username']) || !isset($_SESSION['district'])) {
    header('Location: ../../../index.php');
    exit();
}

// Get the logged-in user's district
$logged_in_district = $_SESSION['district'];

// Barangay to District mapping
$barangayDistrictMapping = [
    'Tankulan' => 'District 1',
    'Tankulan ' => 'District 1',
    'tankulan' => 'District 1',
    'tankulan ' => 'District 1',
    'Diklum' => 'District 1',
    'Diklum ' => 'District 1',
    'diklum' => 'District 1',
    'diklum ' => 'District 1',
    'diclum ' => 'District 1',
    'Diclum ' => 'District 1',
    'San Miguel' => 'District 1',
    'San Miguel ' => 'District 1',
    'san Miguel' => 'District 1',
    'san Miguel ' => 'District 1',
    'san miguel' => 'District 1',
    'san miguel ' => 'District 1',
    'Ticala' => 'District 1',
    'Ticala ' => 'District 1',
    'ticala' => 'District 1',
    'ticala ' => 'District 1',
    'Lingion' => 'District 1',
    'Lingion ' => 'District 1',
    'lingion' => 'District 1',
    'lingion ' => 'District 1',
    'Alae' => 'District 2',
    'Alae ' => 'District 2',
    'alae' => 'District 2',
    'alae ' => 'District 2',
    'Damilag' => 'District 2',
    'Damilag ' => 'District 2',
    'damilag' => 'District 2',
    'damilag ' => 'District 2',
    'Mambatangan' => 'District 2',
    'Mantibugao' => 'District 2',
    'Mantibugao ' => 'District 2',
    'mantibugao' => 'District 2',
    'mantibugao ' => 'District 2',
    'Minsuro' => 'District 2',
    'Minsuro ' => 'District 2',
    'minsuro' => 'District 2',
    'minsuro ' => 'District 2',
    'Lunocan' => 'District 2',
    'Lunocan ' => 'District 2',
    'lunocan ' => 'District 2',
    'lunocan' => 'District 2',
    'Agusan canyon ' => 'District 3',
    'Agusan Canyon ' => 'District 3',
    'Agusan-canyon ' => 'District 3',
    'Agusan-Canyon ' => 'District 3',
    'Agusan canyon' => 'District 3',
    'Agusan Canyon' => 'District 3',
    'Agusan-canyon' => 'District 3',
    'Agusan-Canyon' => 'District 3',
    'Mampayag' => 'District 3',
    'Mampayag ' => 'District 3',
    'mampayag' => 'District 3',
    'mampayag ' => 'District 3',
    'Dahilayan' => 'District 3',
    'Dahilayan ' => 'District 3',
    'dahilayan' => 'District 3',
    'dahilayan ' => 'District 3',
    'Sankanan' => 'District 3',
    'Sankanan ' => 'District 3',
    'sankanan' => 'District 3',
    'sankanan ' => 'District 3',
    'Kalugmanan' => 'District 3',
    'Kalugmanan ' => 'District 3',
    'kalugmanan' => 'District 3',
    'kalugmanan ' => 'District 3',
    'Lindaban' => 'District 3',
    'Lindaban ' => 'District 3',
    'lindaban' => 'District 3',
    'lindaban ' => 'District 3',
    'Dalirig' => 'District 4',
    'Dalirig ' => 'District 4',  // Ensure this is added
    'dalirig' => 'District 4',
    'dalirig ' => 'District 4',
    'Maluko' => 'District 4',
    'Maluko ' => 'District 4',
    'maluko' => 'District 4',
    'maluko ' => 'District 4',
    'Santiago' => 'District 4',
    'santiago' => 'District 4',
    'Santiago ' => 'District 4',
    'santiago ' => 'District 4',
    'Guilang2' => 'District 4',
    'Guilang-Guilang' => 'District 4',
    'guilang-guilang' => 'District 4',
    'Guilang-guilang' => 'District 4',
    'Guilang-Guilang ' => 'District 4',
    'guilang-guilang ' => 'District 4',
    'Guilang-guilang ' => 'District 4',
];

// Get barangays that belong to the logged-in user's district
$userBarangays = array_keys(array_filter($barangayDistrictMapping, function ($district) use ($logged_in_district) {
    return $district === $logged_in_district;
}));

// If no barangays match the user's district, return an error
if (empty($userBarangays)) {
    echo json_encode(['error' => 'No barangays found for the logged-in user\'s district.']);
    exit();
}

// Initialize search variables
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y'); // Default to current year if not specified

// Pagination variables
$itemsPerPage = 10; // Number of items to display per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset for SQL

// Prepare barangay list for SQL IN clause
$barangayList = "'" . implode("','", $userBarangays) . "'";

// Fetch data from the database with year filter, search, and pagination for user's barangays
$sql = "SELECT 
            m.household_members AS Name,
            m.age AS Age,
            m.person_with_disability AS Disability,
            l.barangay AS Barangay,
            CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) AS Address
        FROM 
            members_tbl AS m
        JOIN 
            location_tbl AS l ON m.record_id = l.record_id
        WHERE 
            YEAR(l.date_encoded) = $searchYear
            AND l.barangay IN ($barangayList)
            AND m.person_with_disability = 'Yes'  -- Filter for persons with disability
            AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') OR 
                 m.age LIKE '%$searchTerm%' OR 
                 l.barangay LIKE LOWER('%$searchTerm%') OR 
                 CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))
        LIMIT $offset, $itemsPerPage";

$result = $conn->query($sql);

// Get total records for pagination with the year filter, user's barangays, and disability filter
$totalRecordsSql = "SELECT COUNT(*) AS total FROM members_tbl AS m
                    JOIN location_tbl AS l ON m.record_id = l.record_id
                    WHERE 
                        YEAR(l.date_encoded) = $searchYear
                        AND l.barangay IN ($barangayList)
                        AND m.person_with_disability = 'Yes'  -- Filter for persons with disability
                        AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') OR 
                             m.age LIKE '%$searchTerm%' OR 
                             l.barangay LIKE LOWER('%$searchTerm%') OR 
                             CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))";

$totalRecordsResult = $conn->query($totalRecordsSql);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $itemsPerPage);

// Function to export data as CSV
function exportToCSV($data) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="members_info.csv"');
    $output = fopen('php://output', 'w');
    // Add header row
    fputcsv($output, ['Name', 'Age', 'Disability', 'District', 'Address']);
    
    // Add data rows
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// Function to export data as Excel
function exportToExcel($data) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="members_info.xls"');
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Age</th><th>Disability</th><th>District</th><th>Address</th></tr>";
    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Age']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Disability']) . "</td>";
        echo "<td>" . htmlspecialchars($row['District']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Address']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    exit;
}

// Handle download requests
if (isset($_GET['download'])) {
    $dataToExport = [];

    // Re-run the data fetch with the same search criteria
    $exportSql = "SELECT 
                    m.household_members AS Name,
                    m.age AS Age,
                    m.person_with_disability AS Disability,
                    l.barangay AS Barangay,
                    CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) AS Address
                FROM 
                    members_tbl AS m
                JOIN 
                    location_tbl AS l ON m.record_id = l.record_id
                WHERE 
                    YEAR(l.date_encoded) = $searchYear
                    AND l.barangay IN ($barangayList)
                    AND m.person_with_disability = 'Yes'  -- Filter for persons with disability
                    AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') OR 
                         m.age LIKE '%$searchTerm%' OR 
                         l.barangay LIKE LOWER('%$searchTerm%') OR 
                         CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))";

    $exportResult = $conn->query($exportSql);

    if ($exportResult->num_rows > 0) {
        while ($row = $exportResult->fetch_assoc()) {
            $district = isset($barangayDistrictMapping[$row['Barangay']]) ? $barangayDistrictMapping[$row['Barangay']] : 'Unknown';
            $row['District'] = $district; // Add district to the row data
            $dataToExport[] = $row;
        }
    }

    if ($_GET['download'] === 'csv') {
        exportToCSV($dataToExport);
    } elseif ($_GET['download'] === 'excel') {
        exportToExcel($dataToExport);
    }
}

// Close the database connection
$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>Persons with Disability</title>
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

    a.active1 {
        background-color: #515151;
        color: white;
    }

    /* Ensure container pushes content down */
    .container-fluid {
        margin-top: 1px;
        margin-bottom: 50px;
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
                                <a href="district_osy.php" class="sidebar-link">Manolo Fortich OSY</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="district_population.php" class="sidebar-link">Manolo Fortich Population</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="osy_age.php" class="sidebar-link">OSY By Age</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="interested.php" class="sidebar-link">List of Interested in ALS</a>
                            </li>
                            <li class="sidebar-item active2">
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
                <span class="menu-text">Persons with Disability</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
            
    
        <!--remove responsive
        </div>-->

        <!-- Main Content Starts Here -->
         
<div class="container-fluid">
    <div class="container mt-5">

    <!-- Search Form -->
    <!-- Search Form -->
    <form class="mb-4" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Name, Age, Address">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button> 
                    <a href="persons_with_disability.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    <!-- Download Button Dropdown -->
    <div class="mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"style="background-color: #01c635; border-color: #01c635;">
                Download
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?download=csv&search=<?php echo urlencode($searchTerm); ?>">Download CSV</a></li>
                <li><a class="dropdown-item" href="?download=excel&search=<?php echo urlencode($searchTerm); ?>">Download Excel</a></li>
            </ul>
        </div>
    </div>
    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Disability</th>
                <th>District</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php $district = isset($barangayDistrictMapping[$row['Barangay']]) ? $barangayDistrictMapping[$row['Barangay']] : 'Unknown'; ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Age']); ?></td>
                        <td><?php echo htmlspecialchars($row['Disability']); ?></td>
                        <td><?php echo htmlspecialchars($district); ?></td>
                        <td><?php echo htmlspecialchars($row['Address']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No results found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
    </div>


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

</body>

</html>










<!--
    'Tankulan' => 'District 1',
    'Tankulan ' => 'District 1',
    'tankulan' => 'District 1',
    'tankulan ' => 'District 1',
    'Diklum' => 'District 1',
    'Diklum ' => 'District 1',
    'diklum' => 'District 1',
    'diklum ' => 'District 1',
    'San Miguel' => 'District 1',
    'San Miguel ' => 'District 1',
    'san Miguel' => 'District 1',
    'san Miguel ' => 'District 1',
    'san miguel' => 'District 1',
    'san miguel ' => 'District 1',
    'Ticala' => 'District 1',
    'Ticala ' => 'District 1',
    'ticala' => 'District 1',
    'ticala ' => 'District 1',
    'Lingion' => 'District 1',
    'Lingion ' => 'District 1',
    'lingion' => 'District 1',
    'lingion ' => 'District 1',
    'Alae' => 'District 2',
    'Alae ' => 'District 2',
    'alae' => 'District 2',
    'alae ' => 'District 2',
    'Damilag' => 'District 2',
    'Damilag ' => 'District 2',
    'damilag' => 'District 2',
    'damilag ' => 'District 2',
    'Mambatangan' => 'District 2',
    'Mantibugao' => 'District 2',
    'Mantibugao ' => 'District 2',
    'mantibugao' => 'District 2',
    'mantibugao ' => 'District 2',
    'Minsuro' => 'District 2',
    'Minsuro ' => 'District 2',
    'minsuro' => 'District 2',
    'minsuro ' => 'District 2',
    'Lunocan' => 'District 2',
    'Lunocan ' => 'District 2',
    'lunocan ' => 'District 2',
    'lunocan' => 'District 2',
    'Agusan canyon ' => 'District 3',
    'Agusan Canyon ' => 'District 3',
    'Agusan-canyon ' => 'District 3',
    'Agusan-Canyon ' => 'District 3',
    'Agusan canyon' => 'District 3',
    'Agusan Canyon' => 'District 3',
    'Agusan-canyon' => 'District 3',
    'Agusan-Canyon' => 'District 3',
    'Mampayag' => 'District 3',
    'Mampayag ' => 'District 3',
    'mampayag' => 'District 3',
    'mampayag ' => 'District 3',
    'Dahilayan' => 'District 3',
    'Dahilayan ' => 'District 3',
    'dahilayan' => 'District 3',
    'dahilayan ' => 'District 3',
    'Sankanan' => 'District 3',
    'Sankanan ' => 'District 3',
    'sankanan' => 'District 3',
    'sankanan ' => 'District 3',
    'Kalugmanan' => 'District 3',
    'Kalugmanan ' => 'District 3',
    'kalugmanan' => 'District 3',
    'kalugmanan ' => 'District 3',
    'Lindaban' => 'District 3',
    'Lindaban ' => 'District 3',
    'lindaban' => 'District 3',
    'lindaban ' => 'District 3',
    'Dalirig' => 'District 4',
    'Dalirig ' => 'District 4',  // Ensure this is added
    'dalirig' => 'District 4',
    'dalirig ' => 'District 4',
    'Maluko' => 'District 4',
    'Maluko ' => 'District 4',
    'maluko' => 'District 4',
    'maluko ' => 'District 4',
    'Santiago' => 'District 4',
    'santiago' => 'District 4',
    'Santiago ' => 'District 4',
    'santiago ' => 'District 4',
    'Guilang2' => 'District 4',
    'Guilang-Guilang' => 'District 4',
    'guilang-guilang' => 'District 4',
    'Guilang-guilang' => 'District 4',
    'Guilang-Guilang ' => 'District 4',
    'guilang-guilang ' => 'District 4',
    'Guilang-guilang ' => 'District 4',-->
    