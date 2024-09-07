<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>User Log</title>
</head>
<body>
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->
  <!-- Sidebar -->
  <div class="wrapper">
    <aside id="sidebar">
        <div class="h-100">
            <div class="sidebar-logo">
                <?php
                    session_start();
                    if (isset($_SESSION['username'])) {
                        echo '<a href="#">' . htmlspecialchars($_SESSION['username']) . '</a>';
                    } else {
                        echo '<a href="#">Admin</a>';
                    }
                ?>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-header">Tools & Components</li>
                <li class="sidebar-item">
                    <a href="form.php" class="sidebar-link">
                        <i class="fa-regular fa-file-lines pe-2"></i> Form
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="reports.php" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages">
                        <i class="fa-solid fa-list pe-2"></i> Reports
                    </a>
                    <ul id="pages" class="sidebar-dropdown list-unstyled collapse">
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
                <li class="sidebar-header">User Action</li>
                <li class="sidebar-item ">
                    <a href="user_log.php" class="sidebar-link active">
                        <i class="fa-regular fa-file-lines pe-2"></i> User Log
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth">
                        <i class="fa-regular fa-user pe-2"></i> Auth
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse">
                        <li class="sidebar-item">
                            <a href="edit_profile.php" class="sidebar-link">Edit Profile</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="logout.php" class="sidebar-link">Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Component -->
    <div class="main">
        <nav class="navbar navbar-expand px-3 border-bottom" style="background-color: #e3f2fd;">
            <div class="container">
                <button class="btn btn-light-border-subtle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling">
                    <img src="../../../assets/images/burger-bar.png" alt="Menu" width="30">
                </button>
                <ul class="nav justify-content-end nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="records.php">Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="#">
                            <img src="../../../assets/images/logo.png" alt="Bootstrap" width="40" height="30">
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content for displaying user log -->
        <div class="container mt-4">
            <h1>User Log</h1>

            <!-- Search Form -->
<form method="GET" action="user_log.php" class="mb-3">
    <div class="row justify-content-end"> <!-- Use justify-content-end to align right -->
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by User Name, Login Date, Logout Date" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Search</button>
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
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../../../src/js/plugins/jquery-1.11.2.min.js"></script>  
  <script type="text/javascript" src="../../../src/js/materialize.min.js"></script>
  <script type="text/javascript" src="../../../src/js/plugins.min.js"></script>
  <script src="../../../src/js/nav.js"></script>
</body>
</html>
