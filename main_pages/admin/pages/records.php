<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- CORE CSS-->
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>Dashboard</title>
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
                            <a href="logout.php" class="sidebar-link" onclick="return confirmLogout();">Log Out</a>
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
                        <a class="nav-link active" href="records.php">Records</a>
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
        <!-- End of top nav -->

        <div class="container mt-5">
            <h1>Records</h1>
            <!-- Search Form -->
            <form method="GET" class="mb-3">
                <div class="row justify-content-end"> <!-- Use justify-content-end to align right -->
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by Name, Birthday, Age, or Address" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <!--End of Search Form -->

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- PHP code to fetch data from database -->
                        <?php
                        include '../../../src/db/db_connection.php';

                        $search = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

                        $sql = "SELECT * FROM osy_tbl
                                WHERE household_members LIKE ? OR birthdate LIKE ? OR age LIKE ? OR
                                CONCAT(city_municipality, ' ', barangay, ' ', sitio_zone_purok) LIKE ?
                                LIMIT 10";

                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('ssss', $search, $search, $search, $search);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $full_address = $row['city_municipality'] . ' ' . $row['barangay'] . ' ' . $row['sitio_zone_purok'];
                                echo "<tr>
                                        <td>{$row['household_members']}</td>
                                        <td>{$row['birthdate']}</td>
                                        <td>{$row['age']}</td>
                                        <td>{$full_address}</td>
                                        <td><button class='btn btn-primary'>View Info</button></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">></a></li>
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
</body>
</html>
