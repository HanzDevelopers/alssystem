<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit User</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit User</h1>
        <?php
        include '../../../src/db/db_connection.php';

        // Validate and sanitize the user_id
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $user_id = intval($_GET['id']);
        } else {
            die("Invalid user ID");
        }

        // Fetch the user data
        $sql = "SELECT * FROM user_tbl WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            die("User not found");
        }
        ?>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
            <div class="mb-3">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($row['user_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter new password if you want to change it">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">View Password</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="user_type" class="form-label">User Type</label>
                <input type="text" class="form-control" id="user_type" name="user_type" value="<?php echo htmlspecialchars($row['user_type']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = intval($_POST['user_id']);
        $user_name = $conn->real_escape_string($_POST['user_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $user_type = $conn->real_escape_string($_POST['user_type']);

        $sql = "UPDATE user_tbl SET user_name='$user_name', email='$email', user_type='$user_type'";

        if (!empty($_POST['pass'])) {
            $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $sql .= ", pass='$pass'";
        }

        $sql .= " WHERE user_id=$user_id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully'); window.location.href='users.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const passwordInput = document.getElementById('pass');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'View Password' : 'Hide Password';
        });
    </script>
</body>
</html>
