

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <title>Uesr Log</title>
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
                    <li class="sidebar-item active2">
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
                <span class="menu-text">Uesr Log</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
            
    
        <!--remove responsive
        </div>-->

        <!-- Main Content Starts Here -->
<div class="container-fluid">
    <div class="container mt-4">
    <!-- Search Form -->
<form method="GET" action="user_log.php" class="mb-3">
    <div class="row justify-content-end"> <!-- Use justify-content-end to align right -->
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by User Name, Login Date, Logout Date" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="user_log.php" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>
<!--End of Search Form -->

            
            <?php
// Database connection
include '../../../src/db/db_connection.php';

// Get the search query, if any
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get the current page number from the URL, if none set, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of entries to show per page
$offset = ($page - 1) * $limit; // Calculate the offset for the query

// Fetch the total number of records in the user_log table that match the search criteria
$total_sql = "SELECT COUNT(*) AS total FROM user_log WHERE user_name LIKE '%$search%' OR login_date LIKE '%$search%' OR logout_date LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Fetch data from the user_log table, filtered by search query, ordered by login_date (most recent) with LIMIT and OFFSET
$sql = "SELECT log_id, user_id, user_name, login_date, logout_date 
        FROM user_log 
        WHERE user_name LIKE '%$search%' OR login_date LIKE '%$search%' OR logout_date LIKE '%$search%'
        ORDER BY login_date DESC 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Log ID</th><th>User ID</th><th>User Name</th><th>Login Date</th><th>Logout Date</th></tr></thead>';
    echo '<tbody>';
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["log_id"]) . "</td>
                <td>" . htmlspecialchars($row["user_id"]) . "</td>
                <td>" . htmlspecialchars($row["user_name"]) . "</td>
                <td>" . htmlspecialchars($row["login_date"]) . "</td>
                <td>" . htmlspecialchars($row["logout_date"]) . "</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo "<p>No logs found.</p>";
}

// Close the connection
$conn->close();

// Calculate total number of pages
$total_pages = ceil($total_records / $limit);

// Display pagination buttons
echo '<nav aria-label="Page navigation">';
echo '<ul class="pagination justify-content-center">';

// Previous page button
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . $search . '">Previous</a></li>';
}

// Page number buttons
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
}

// Next page button
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
}

echo '</ul>';
echo '</nav>';
?>
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
