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
    p {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    line-height: 1.7em;
    color: #ffffff;
}
    .container.my-5 {
            background-color: gainsboro; /* Set background color to gainsboro */
            padding: 20px; /* Optional: add padding around the container */
            border-radius: 8px; /* Optional: add rounded corners */
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

            <li class="sidebar-header">
                        Key Performans Indicator
                    </li>
                    <li class="sidebar-item active4">
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
                                <a href="district_osy.php" class="sidebar-link">District OSY</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="district_population.php" class="sidebar-link">District Population</a>
                            </li>
                            <li class="sidebar-item">
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
            
    <div class="content p-3">
        <div class="row">




        <div class="container my-5">
    <h1 class="mb-4">Data Summary</h1>
    <div class="d-flex flex-wrap justify-content-between gap-3">
        <!-- Total Population (District 1 to 4) -->
        <div class="card text-white bg-secondary flex-grow-1" style="min-width: 200px;">
            <div class="card-body text-center">
                <p class="card-text">Total Population (District 1 to 4)</p>
                <h3 class="card-title"><?php echo $data['totalPopulation'];?></h3>
            </div>
        </div>
        <!-- Not Attending School (Age 15-30) -->
        <div class="card text-white bg-primary flex-grow-1" style="min-width: 200px;">
            <div class="card-body text-center">
                <p class="card-text">Not Attending School (Age 15-30)</p>
                <h3 class="card-title"><?php echo $data['notAttendingSchool']; ?></h3>
            </div>
        </div>

        <!-- Interested in ALS -->
        <div class="card text-white bg-success flex-grow-1" style="min-width: 200px;">
            <div class="card-body text-center">
                <p class="card-text">Interested in ALS</p>
                <h3 class="card-title"><?php echo $data['interestedInAls']; ?></h3>
            </div>
        </div>

        <!-- Persons with Disability -->
        <div class="card text-white bg-warning flex-grow-1" style="min-width: 200px;">
            <div class="card-body text-center">
                <p class="card-text">Persons with Disability</p>
                <h3 class="card-title"><?php echo $data['personsWithDisability']; ?></h3>
            </div>
        </div>

        <!-- No Occupation -->
        <div class="card text-white bg-danger flex-grow-1" style="min-width: 200px;">
            <div class="card-body text-center">
                <p class="card-text">No Occupation</p>
                <h3 class="card-title"><?php echo $data['noOccupation']; ?></h3>
            </div>
        </div>

        <!-- Families with Income Below 20,000 -->
        <div class="card text-white bg-info flex-grow-1" style="min-width: 200px;">
            <div class="card-body text-center">
                <p class="card-text">Families with Income Below 20,000</p>
                <h3 class="card-title"><?php echo $data['lowIncomeFamilies']; ?></h3>
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
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Data Charts</h1>
    <div class="btn-group" style="margin-right: 100px;">
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
    <div class="chart-card">
        <div id="pie-chart" class="chart"></div>
        <!-- View Info Button for Pie Chart -->
        <a href="district_osy.php" class="sidebar-link btn btn-primary mt-2">
            <i class="fa fa-info-circle me-2"></i>
            View Info
        </a>
    </div>

    <!-- Chart 2: District Population Bar Chart -->
    <div class="chart-card">
        <div id="bar-chart1" class="chart"></div>
        <!-- View Info Button for Bar Chart 1 -->
        <a href="district_population.php" class="sidebar-link btn btn-primary mt-2">
            <i class="fa fa-info-circle me-2"></i>
            View Info
        </a>
    </div>

    <!-- Chart 3: OSY By Age Bar Chart -->
    <div class="chart-card">
        <div id="bar-chart2" class="chart"></div>
        <!-- View Info Button for Bar Chart 2 -->
        <a href="interested.php" class="sidebar-link btn btn-primary mt-2">
            <i class="fa fa-info-circle me-2"></i>
            View Info
        </a>
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
        <script src="../js/data.js"></script>
        <script src="../js/form.js"></script>

</body>

</html>
