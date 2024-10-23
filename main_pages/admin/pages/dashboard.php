<?php
// Include the logic to fetch the summary data
include '../api/fetch_summary_data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>Dashboard</title>
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
.active4{
    background-color: #b9b9b9;
    color: white;
}
    /* Ensure container pushes content down */
    .container-fluid {
        margin-top: 1px;
    }
    
    /* Card Styles */
    .card-osy-total {
    background-color: #51cf66; /* Soft Red */
    color: white;
}

.card-osy-gender {
    background-color: #51cf66; /* Soft Orange */
    color: white;
}

.card-osy-district {
    background-color: #ffd43b; /* Soft Yellow */
    color: #333; /* Dark text for better contrast on yellow */
}

.card-osy-district:nth-child(1) {
    background-color: #90D5ff; /* Soft Green */
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
h5{
    text-align: center;
    font-weight: bold;
    font-size: 25px;
}

/* New style for Total Population card */
.card-total-population {
    background-color: #51cf66; /* Soft Violet/Pink */
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
    font-size: 1rem;
    color: #333; /* Dark text for readability */
}

/* Paragraphs inside cards */
.card-body p {
    font-size: 2rem;
    color: #ffffff; /* Consistent white text */
}

h5.card-title{
    font-size: 15px;
}
p.card-text{
    font-weight: bold;
}

/* Hover effect for interactive cards */
.card:hover {
    transform: translateY(-5px); /* Subtle lift effect */
    background-color: #f1f3f5; /* Light grey on hover for contrast */
    color: #333;
}
/* Target the age range labels to be black */
.card:hover .card-body .age-range-label {
    font-size: 2rem;
    color: black; /* Black text for the age range labels */
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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit();
}

// Include the database connection
include '../../../src/db/db_connection.php';

// Fetch the latest user data from the database based on session user_id
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session during login

// Adjust column name to match your database structure
$sql = "SELECT user_name FROM user_tbl WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Update the session username with the latest data from the database
    $_SESSION['username'] = $row['user_name']; // Adjusted to 'user_name'
}

// Display the latest username
if (isset($_SESSION['username'])) {
    echo '<a href="#">' . htmlspecialchars($_SESSION['username']) . '</a>';
} else {
    echo '<a href="#">Admin</a>';
}

$stmt->close();
$conn->close();
?>

            </h3>
                
            </div>

            <li class="sidebar-header title" style="
    font-weight: bold; color:gray;">
                        Key Performans Indicator
                    </li>
                    <li class="sidebar-item active4">
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
                        <a href="reports.php" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
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
                <span class="menu-text">Dashboard</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
                <!-- Dropdown fixed at the bottom
<div class="dropdown fixed-top-right">
    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Download
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" onclick="downloadImage()">Download Images</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadPDF()">Download PDF</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadCSV()">Download CSV</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadExcel()">Download Excel</a></li>
    </ul>
</div> -->
            </div>
            
    
        <!--remove responsive
        </div>-->

        <!-- Main Content Starts Here -->
        <div class="container-fluid">
        <div class="container mt-4">
    <!-- First Row: Total Population, Total OSY, and Gender Cards -->
    <div class="row justify-content-center mb-3">
    <h5 class="mb-4">Data Summary</h5>
        <!-- Total Population (District 1 to 4) -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-total-population" style="cursor: pointer;" onclick="window.location.href='district_population.php';">
                <div class="card-body">
                    <h5 class="card-title">Manolo Fortich Population <br><span style="font-size:12px;">*District 1 to 4*</span></h5>
                    <p class="card-text"><span class="age-range-label"><?php echo $data['totalPopulation'];?></span></p>
                </div>
            </div>
        </div>


        
        <!-- Not Attending School (Age 15-30) -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-total" style="cursor: pointer;" onclick="window.location.href='district_osy.php';">
                <div class="card-body">
                    <h5 class="card-title">Manolo Fortich OSY <br><span style="font-size:12px;">*Age 15-30*</span></h5>
                    <p class="card-text"><span class="age-range-label"><?php echo $data['notAttendingSchool']; ?></span></p>
                </div>
            </div>
        </div>


        <!-- Interested in ALS -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3"> <!-- Set to double width -->
            <div class="card text-center card-osy-gender" style="cursor: pointer;" onclick="window.location.href='interested.php';">
                <div class="card-body">
            <h5 class="card-title">Interested in ALS</h5>
            <p class="card-text"><span class="age-range-label"><?php echo $data['interestedInAls']; ?></span></p>
                </div>
            </div>
        </div>
    </div>

<!-- Second Row: District OSY Cards -->
    <div class="row justify-content-center">

    
        <!-- Persons with Disability -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-district" style="cursor: pointer;" onclick="window.location.href='persons_with_disability.php';">
                <div class="card-body">
                    <h5 class="card-title">Persons with Disability</h5>
                    <p class="card-text"><span class="age-range-label"><?php echo $data['personsWithDisability']; ?></span></p>
                </div>
            </div>
        </div>


        
        <!-- No Occupation -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-district" style="cursor: pointer;" onclick="window.location.href='no_occupation.php';">
                <div class="card-body">
                    <h5 class="card-title">No Occupation</h5>
                    <p class="card-text"><span class="age-range-label"><?php echo $data['noOccupation']; ?></span></p>
                </div>
            </div>
        </div>


        
        <!-- Families with Income Below 20,000 -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card text-center card-osy-district" style="cursor: pointer;" onclick="window.location.href='income_below_20,000.php';">
                <div class="card-body">
                    <h5 class="card-title">Families with Income Below 20,000</h5>
                    <p class="card-text"><span class="age-range-label"><?php echo $data['lowIncomeFamilies']; ?></span></p>
                </div>
            </div>
        </div>

        
    </div>
    </div>
</div>




            <!--
        <form id="searchForm">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="dateEncoded" name="dateEncoded" placeholder="Search by year Encoded">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
                -->
            <!-- Container for charts -->
             
    <h5 class="mb-4">Data Charts</h5>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="btn-group float-end" style="margin-left: 30px;">
    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Download
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" onclick="downloadImage()">Download Images</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadPDF()">Download PDF</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadCSV()">Download CSV</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadExcel()">Download Excel</a></li>
    </ul>
</div>
</div>
<div class="dashboard-container">
    <!-- Chart 1: District OSY Pie Chart -->
    <div class="chart-card" style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; width: 30%; min-width: 300px; text-align: center;">
        <div id="pie-chart" class="chart"></div>
        <!-- View Info Button for Pie Chart -->
        <a href="district_osy.php" class="sidebar-link btn btn-primary mt-2">
            <i class="fa fa-info-circle me-2"></i>
            View Info
        </a>
    </div>

    <!-- Chart 2: District Population Bar Chart -->
    <div class="chart-card" style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; width: 30%; min-width: 300px; text-align: center;">
        <div id="bar-chart1" class="chart"></div>
        <!-- View Info Button for Bar Chart 1 -->
        <a href="district_population.php" class="sidebar-link btn btn-primary mt-2">
            <i class="fa fa-info-circle me-2"></i>
            View Info
        </a>
    </div>

    <!-- Chart 3: OSY By Age Bar Chart -->
    <div class="chart-card" style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; width: 30%; min-width: 300px; text-align: center;">
        <div id="bar-chart2" class="chart"></div>
        <!-- View Info Button for Bar Chart 2 -->
        <a href="interested.php" class="sidebar-link btn btn-primary mt-2">
            <i class="fa fa-info-circle me-2"></i>
            View Info
        </a>
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
