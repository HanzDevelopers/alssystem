<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../src/css/dashboard.css">
    <title>Users</title>
</head>
<body>
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->

    <!-- Top nav -->
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container">
            <button class="btn btn-light-border-subtle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><img src="../../../assets/images/burger-bar.png" alt="Menu" width="30"></button>
            <ul class="nav justify-content-end nav-pills">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="records.php">Records</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="users.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="navbar-brand" href="#">
                        <img src="../../../assets/images/logo.png" alt="Bootstrap" width="40" height="30" height="35">
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End of top nav -->

    <!-- Side bar -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Offcanvas with body scrolling</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>gawapo</p>
        </div>
    </div>
    <!-- End of side bar -->

    <div class="container mt-5">
        <h1>Users</h1>
        <a href="add_user.php" class="btn btn-success mb-3">Add</a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch data from database -->
                    <?php
                    include '../../../src/db/db_connection.php';
                    $sql = "SELECT * FROM user_tbl LIMIT 10"; // Adjust the table name and query as necessary
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['user_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['pass']}</td>
                                    <td>{$row['user_type']}</td>
                                    <td>
                                        <a href='edit_user.php?id={$row['user_id']}' class='btn btn-primary'>Edit</a>
                                        <a href='delete_user.php?id={$row['user_id']}' class='btn btn-danger'>Delete</a>
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
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">></a></li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../../src/js/plugins/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="../../../src/js/materialize.min.js"></script>
    <script type="text/javascript" src="../../../src/js/plugins.min.js"></script>
</body>
</html>
