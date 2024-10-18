<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>User Log</title>
</head>
<style>
    
.active2{
    background-color: #b9b9b9;
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
                            User Action
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
                <span class="menu-text">User Log</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>


        <!-- Content for displaying user log -->
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

// Database connection
include '../../../src/db/db_connection.php';

// Get the search query, if any
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get the current page number from the URL, if none set, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Fetch the total number of records, filtering by district and excluding supervisors
$total_sql = "SELECT COUNT(*) AS total 
              FROM user_log ul 
              JOIN user_tbl ut ON ul.user_id = ut.user_id 
              WHERE (ul.user_name LIKE '%$search%' OR ul.login_date LIKE '%$search%' OR ul.logout_date LIKE '%$search%')
              AND ut.user_type != 'supervisor' 
              AND ut.district = '$logged_in_district'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Fetch the log data, including district and filtering by district, excluding supervisors
$sql = "SELECT ul.log_id, ul.user_id, ul.user_name, ul.login_date, ul.logout_date, ut.status, ut.district 
        FROM user_log ul 
        JOIN user_tbl ut ON ul.user_id = ut.user_id 
        WHERE (ul.user_name LIKE '%$search%' OR ul.login_date LIKE '%$search%' OR ul.logout_date LIKE '%$search%')
        AND ut.user_type != 'supervisor'
        AND ut.user_type != 'coordinator' 
        AND ut.district = '$logged_in_district'
        ORDER BY ul.login_date DESC 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// Display the table if there are results
if ($result->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Log ID</th><th>User ID</th><th>User Name</th><th>District</th><th>Login Date</th><th>Logout Date</th><th>Status</th><th>Action</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["log_id"]) . "</td>
                <td>" . htmlspecialchars($row["user_id"]) . "</td>
                <td>" . htmlspecialchars($row["user_name"]) . "</td>
                <td>" . htmlspecialchars($row["district"]) . "</td> <!-- Display district here -->
                <td>" . htmlspecialchars($row["login_date"]) . "</td>
                <td>" . htmlspecialchars($row["logout_date"]) . "</td>
                <td>" . htmlspecialchars($row["status"]) . "</td>
                <td>
                    <button class='btn btn-sm btn-toggle-status'  
                        data-id='{$row['user_id']}' 
                        data-status='{$row['status']}' 
                        style='background-color: " . ($row['status'] === 'disable' ? 'green' : 'orange') . "; color: white;'>
                        " . ($row['status'] === 'disable' ? 'Enable Account?' : 'Disable Account?') . "
                    </button>
                    <a href='delete_user.php?id={$row['user_id']}' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Delete</a>
                </td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo "<p>No logs found.</p>";
}

$conn->close();

// Calculate total number of pages
$total_pages = ceil($total_records / $limit);

// Display pagination buttons
echo '<nav aria-label="Page navigation">';
echo '<ul class="pagination justify-content-center">';
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . htmlspecialchars($search) . '">Previous</a></li>';
}
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . htmlspecialchars($search) . '">' . $i . '</a></li>';
}
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . htmlspecialchars($search) . '">Next</a></li>';
}
echo '</ul>';
echo '</nav>';
?>


        </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../src/js/nav.js"></script>
<!-- Confirmation Script -->
<script>
    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }

    function confirmDelete() {
        return confirm("Are you sure you want to delete this account?");
    }

    function disable(userId, currentStatus) {
        const newStatus = currentStatus === 'disable' ? 'enable' : 'disable';
        const confirmation = confirm("Are you sure you want to " + newStatus + " this account?");
        if (!confirmation) {
            return; // If canceled, do nothing
        }

        // Send AJAX request to update the status
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `user_id=${userId}&status=${newStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Automatically reload the page to reflect changes
                location.reload(); // Reload the current page
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.btn-toggle-status');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const currentStatus = this.getAttribute('data-status');
                disable(userId, currentStatus); // Call the disable function with userId and currentStatus
            });
        });
    });
</script>

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
