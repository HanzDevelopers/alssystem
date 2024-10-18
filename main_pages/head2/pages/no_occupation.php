
<?php
// Database connection
include '../../../src/db/db_connection.php';

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

// Initialize search variable
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination variables
$itemsPerPage = 10; // Number of items to display per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset for SQL

// Fetch data from the database for individuals with no occupation
$sql = "
    SELECT 
        m.household_members AS Name,
        m.age AS Age,
        b.occupation AS Occupation,
        l.barangay AS Barangay,
        CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) AS Address
    FROM 
        background_tbl AS b
    JOIN 
        members_tbl AS m ON b.member_id = m.member_id
    JOIN 
        location_tbl AS l ON m.record_id = l.record_id
    WHERE 
        b.occupation IN ('NO', 'No', 'no') 
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') 
        OR m.age LIKE '%$searchTerm%'
        OR l.barangay LIKE LOWER('%$searchTerm%') 
        OR CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))
    ORDER BY 
        m.household_members ASC
    LIMIT $offset, $itemsPerPage
";

$result = $conn->query($sql);

// Get total records for pagination
$totalRecordsSql = "
    SELECT COUNT(*) AS total 
    FROM background_tbl AS b
    JOIN members_tbl AS m ON b.member_id = m.member_id
    JOIN location_tbl AS l ON m.record_id = l.record_id
    WHERE 
        b.occupation IN ('NO', 'No', 'no') 
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') 
        OR m.age LIKE '%$searchTerm%'
        OR l.barangay LIKE LOWER('%$searchTerm%') 
        OR CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))
";

$totalRecordsResult = $conn->query($totalRecordsSql);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $itemsPerPage);


if (isset($_GET['download'])) {
    $downloadType = $_GET['download'];

    // Fetch data for the CSV or Excel download based on the search term
    $downloadSql = "
        SELECT 
            m.household_members AS Name,
            m.age AS Age,
            b.occupation AS Occupation,
            l.barangay AS Barangay,
            CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) AS Address
        FROM 
            background_tbl AS b
        JOIN 
            members_tbl AS m ON b.member_id = m.member_id
        JOIN 
            location_tbl AS l ON m.record_id = l.record_id
        WHERE 
            b.occupation IN ('NO', 'No', 'no') 
            AND YEAR(l.date_encoded) = YEAR(CURDATE())
            AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') 
            OR m.age LIKE '%$searchTerm%'
            OR l.barangay LIKE LOWER('%$searchTerm%') 
            OR CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))
        ORDER BY 
            m.household_members ASC
    ";

    $downloadResult = $conn->query($downloadSql);

    if ($downloadType == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="data.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Name', 'Age', 'Occupation', 'Barangay', 'Address'));

        while ($row = $downloadResult->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    } elseif ($downloadType == 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="data.xls"');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Name', 'Age', 'Occupation', 'Barangay', 'Address'), "\t");

        while ($row = $downloadResult->fetch_assoc()) {
            fputcsv($output, $row, "\t");
        }
        fclose($output);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>No Occupation</title>
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
                                <a href="district_osy.php" class="sidebar-link">District OSY</a>
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
                            <li class="sidebar-item active2">
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
                <span class="menu-text">No Occupation</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
            
    
        <!--remove responsive
        </div>-->

        <!-- Main Content Starts Here -->
<div class="container-fluid">
    <div class="container mt-4">
        
        <!-- Search Form -->
        <form class="mb-4" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Name, Age, Address">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <a href="no_occupation.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
<!-- Download Button -->
<div class="mb-3 text-right">
    <div class="btn-group">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Download
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?download=csv&search=<?php echo urlencode($searchTerm); ?>">Download CSV</a></li>
            <li><a class="dropdown-item" href="?download=excel&search=<?php echo urlencode($searchTerm); ?>">Download Excel</a></li>
        </ul>
    </div>
</div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Occupation</th>
                    <th>District</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $district = $barangayDistrictMapping[$row['Barangay']] ?? 'Unknown District';
                        echo "<tr>
                                <td>{$row['Name']}</td>
                                <td>{$row['Age']}</td>
                                <td>{$row['Occupation']}</td>
                                <td>{$district}</td>
                                <td>{$row['Address']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
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
        <script src="../js/data.js"></script>
        <script src="../js/form.js"></script>

</body>

</html>
