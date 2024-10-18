<?php
include '../../../src/db/db_connection.php';

// Pagination settings
$results_per_page = 10; // Number of results per page
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = intval($_GET['page']);
} else {
    $current_page = 1; // Default to the first page
}
$start_from = ($current_page - 1) * $results_per_page;

// Search handling
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Query to get the total number of users with user_type = 'user' and matching the search criteria
$search_query = "SELECT COUNT(*) AS total FROM user_tbl WHERE user_type = 'user'";
if (!empty($search_term)) {
    $search_query .= " AND (user_name LIKE '%" . $conn->real_escape_string($search_term) . "%' OR status LIKE '%" . $conn->real_escape_string($search_term) . "%')";
}
$total_result = $conn->query($search_query);
$row = $total_result->fetch_assoc();
$total_users = $row['total'];
$total_pages = ceil($total_users / $results_per_page);

// Query to get the users for the current page, ordered from newest to oldest
$sql = "SELECT * FROM user_tbl WHERE user_type = 'user'";
if (!empty($search_term)) {
    $sql .= " AND (user_name LIKE '%" . $conn->real_escape_string($search_term) . "%' OR status LIKE '%" . $conn->real_escape_string($search_term) . "%')";
}
$sql .= " ORDER BY user_name asc LIMIT $start_from, $results_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CORE CSS-->
    <link rel="stylesheet" href="../../../src/css/dashboard.css">
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>Records</title>
</head>
<style>
    .btn {
        margin: 0 5px; /* Add a uniform margin to both buttons */
        padding: 5px 10px; /* Adjust padding if needed */
    }
    td {
        white-space: nowrap; /* Prevents the content from wrapping */
    }
</style>
<body>
  <!-- Sidebar -->
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
        <!-- Page Content  -->
        <div id="content">
            <div class="menu-header">
                <button type="button" id="sidebarCollapse" class="btn menu-btn">
                    <img src="../../../assets/images/burger-bar.png" alt="Menu" width="30" style="margin-left: 10px;">
                </button>
                <span class="menu-text">Users</span>
                <img src="../../../assets/images/logo.png" alt="Logo" class="header-logo">
            </div>
        <!-- End of top nav -->

        <div class="container mt-5">
            <!-- Search Form -->
            <form method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or status" value="<?php echo htmlspecialchars($search_term); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="users.php" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>
            <a href="add_user.php" class="btn btn-success mb-3">Add</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- PHP code to fetch data from the database -->
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['user_name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['user_type']}</td>
                                        <td>{$row['status']}</td>
                                        <td>
                                            <button class='btn btn-sm btn-toggle-status'  onclick='return disable()' 
                                                data-id='{$row['user_id']}' 
                                                data-status='{$row['status']}' 
                                                style='background-color: " . ($row['status'] === 'disable' ? 'green' : 'orange') . "; color: white;'>
                                                " . ($row['status'] === 'disable' ? 'Enable' : 'Disable') . "
                                            </button>
                                            <a href='delete_user.php?id={$row['user_id']}' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php
                    // Previous page button
                    if ($current_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="users.php?page=' . ($current_page - 1) . '">Previous</a></li>';
                    }
                    
                    // Page number buttons
                    for ($page = 1; $page <= $total_pages; $page++) {
                        if ($page == $current_page) {
                            echo '<li class="page-item active"><a class="page-link" href="#">' . $page . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="users.php?page=' . $page . '">' . $page . '</a></li>';
                        }
                    }
                    
                    // Next page button
                    if ($current_page < $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="users.php?page=' . ($current_page + 1) . '">Next</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- jQuery Library -->
  <script type="text/javascript" src="../../../src/js/plugins/jquery-1.11.2.min.js"></script>  
  <!-- materialize js -->
  <script type="text/javascript" src="../../../src/js/materialize.min.js"></script>
  <!-- plugins.js - Some Specific JS codes for Plugin Settings -->
  <script type="text/javascript" src="../../../src/js/plugins.min.js"></script>
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
  <!-- Confirmation Script -->
  <script>
    function disable() {
          return confirm("Are you sure you want to disable/enable this account?");
      }
      function confirmDelete() {
          return confirm("Are you sure you want to delete this account?");
      }
      function confirmLogout() {
          return confirm("Are you sure you want to log out?");
      }
  </script>
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
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.btn-toggle-status');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const currentStatus = this.getAttribute('data-status');
                const newStatus = currentStatus === 'disable' ? 'enable' : 'disable';

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
                        // Update the button text and status attribute
                        this.textContent = newStatus === 'disable' ? 'Enable' : 'Disable';
                        this.setAttribute('data-status', newStatus);
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"></script>
</body>
</html>
