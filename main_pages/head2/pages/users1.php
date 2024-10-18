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
    </div>
</body>
</html>
