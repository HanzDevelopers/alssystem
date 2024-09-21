<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>Dashboard</title>

    <!-- Bootstrap CSS CDN --> 
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
  <!-- End Page Loading -->
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header" style="background: gray;">
                <h3 style="color: #ffffff;">
                    <?php
                    session_start();
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
                        <a href="form.php" class="sidebar-link">
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

        <!-- Page Content  -->
        <div id="content">
            <div class="menu-header">
                <button type="button" id="sidebarCollapse" class="btn menu-btn">
                    <img src="../../../assets/images/burger-bar.png" alt="Menu" width="30" style="margin-left: 10px;">
                </button>
                <span class="menu-text">Dashboard</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
            
        </div><!-- Main Content Starts Here -->
        <div class="container-fluid">
    <div class="content p-3">
        <div class="row">
            <div class="col-md-4 col-sm-12 mb-3">
                <div class="card w-100">
                    <div class="card-header">District OSY</div>
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                        <a href="#" class="btn btn-primary mt-2">View Info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 mb-3">
                <div class="card w-100">
                    <div class="card-header">District Population</div>
                    <div class="card-body">
                        <canvas id="barChart"></canvas>
                        <a href="#" class="btn btn-primary mt-2">View Info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 mb-3">
                <div class="card w-100">
                    <div class="card-header">OSY By Age</div>
                    <div class="card-body">
                        <canvas id="barChart2"></canvas>
                        <a href="#" class="btn btn-primary mt-2">View Info</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Main Content Ends Here -->
    </div>



    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="../js/dashboard.js"></script>
        <script src="../../../src/js/nav.js"></script>

    <script>
        //Confirmation Script
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>
</body>

</html>