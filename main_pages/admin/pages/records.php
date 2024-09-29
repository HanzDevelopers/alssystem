
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <!-- CORE CSS-->
     
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>Records</title>
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
                        <li class="sidebar-item active2">
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
                <span class="menu-text">Household Records</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
        <!-- End of top nav -->

        <div class="container mt-5">
    <!-- Search Bar -->
    <form id="searchForm" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search By Encoder Name, Household Member, or Birthdate" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
    <div class="container mt-5">
    <!-- Export Dropdown -->
    <div class="mb-3">
    <div class="dropdown">
        <P>TO DOWNLOAD SPECIFIC DATA, PLEASE USE THE SEARCH BAR</P>
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #01c635; border-color: #01c635;">
        Download H.R As
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#" onclick="downloadCSV()">CSV</a></li>
        <li><a class="dropdown-item" href="#" onclick="downloadExcel()">Excel</a></li>
    </ul>
</div>

    </div>
    <!-- Table -->
    <?php
   // Database connection
include '../../../src/db/db_connection.php';

// Get the search query, if any
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get the current page number from the URL, if none set, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of entries to show per page
$offset = ($page - 1) * $limit; // Calculate the offset for the query

// Fetch the total number of records in the household table that match the search criteria
$total_sql = "
    SELECT COUNT(*) AS total 
    FROM members_tbl m 
    JOIN location_tbl l ON m.record_id = l.record_id 
    WHERE /*l.encoder_name LIKE '%$search%' */
       m.household_members LIKE '%$search%' 
       OR m.birthdate LIKE '%$search%' 
       OR m.age LIKE '%$search%' 
       OR CONCAT(l.province, ', ', l.city_municipality, ', ', l.barangay) LIKE '%$search%'
";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Fetch data from the household table, filtered by search query, ordered by birthdate (newest to oldest) with LIMIT and OFFSET
$sql = "
    SELECT m.*, l.encoder_name, CONCAT(l.barangay, ', ', l.city_municipality, ', ',l.province ) AS address
    FROM members_tbl m 
    JOIN location_tbl l ON m.record_id = l.record_id 
    WHERE /*l.encoder_name LIKE '%$search%' */
       m.household_members LIKE '%$search%' 
       OR m.birthdate LIKE '%$search%' 
       OR m.age LIKE '%$search%' 
       OR CONCAT(l.province, ', ', l.city_municipality, ', ', l.barangay) LIKE '%$search%'
    ORDER BY m.age ASC 
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Encoder Name</th><th>Household Member</th><th>Birthdate</th><th>Age</th><th>Address</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["encoder_name"]) . "</td>
                <td>" . htmlspecialchars($row["household_members"]) . "</td>
                <td>" . htmlspecialchars($row["birthdate"]) . "</td>
                <td>" . htmlspecialchars($row["age"]) . "</td>
                <td>" . htmlspecialchars($row["address"]) . "</td>
                <td><button class='btn btn-primary' onclick='viewInfo(" . $row["member_id"] . ")'>View Info</button></td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo "<p>No records found.</p>";
}

// Calculate total number of pages
$total_pages = ceil($total_records / $limit);

// Display pagination buttons
echo '<nav aria-label="Page navigation">';
echo '<ul class="pagination justify-content-center">';

// Previous page button
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . htmlspecialchars($search) . '">Previous</a></li>';
}

// Page number buttons
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . htmlspecialchars($search) . '">' . $i . '</a></li>';
}

// Next page button
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . htmlspecialchars($search) . '">Next</a></li>';
}

echo '</ul>';
echo '</nav>';
?>


        </div>
    </div>
</div>
<!-- JavaScript function to handle the View Info button -->
<script>
    function viewInfo(memberId) {
        // Redirect to the member's detailed information page
        // You need to create this page and handle the memberId parameter
        window.location.href = 'member_info.php?member_id=' + memberId;
    }
</script>

            </tbody>
        </table>
    </div>
        </div>
            </div>

        
    </div>
  </div>

        
    <script src="../../../src/js/nav.js"></script>

    <!-- Confirmation Script -->
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>
 
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <!--libraries to handle the exporting of the table-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="../js/records_download.js"></script>
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

    <!--handle download-->
    <script>
    function downloadCSV() {
        const search = document.getElementById('searchInput').value;
        window.location.href = '../download_functions/download_records.php?format=csv&search=' + encodeURIComponent(search);
    }

    function downloadExcel() {
        const search = document.getElementById('searchInput').value;
        window.location.href = '../download_functions/download_records.php?format=excel&search=' + encodeURIComponent(search);
    }
</script>
>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="../js/form.js"></script>
</body>
</html>
