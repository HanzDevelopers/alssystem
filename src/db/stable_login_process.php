<?php
session_start();
require 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Making the username comparison case-sensitive
        $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE BINARY user_name = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['pass'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['user_name'];
                $_SESSION['user_type'] = $user['user_type'];

                // Check user status
                if (empty($user['status']) || strtolower($user['status']) == 'enable') {
                    $login_time = date("Y-m-d H:i:s");
                    $log_stmt = $conn->prepare("INSERT INTO user_log (user_id, user_name, login_date) VALUES (?, ?, ?)");
                    $log_stmt->bind_param("iss", $_SESSION['user_id'], $_SESSION['username'], $login_time);
                    $log_stmt->execute();

                    if (strtolower($user['user_type']) == 'admin') {
                        header("Location: ../../main_pages/admin/pages/dashboard.php");
                    } elseif (strtolower($user['user_type']) == 'user') {
                        header("Location: ../../main_pages/user/pages/dashboard.php");
                    } else {
                        echo "Invalid user type.";
                    }
                    exit();
                } else {
                    // Redirect to the disabled accounts page if the status is 'disable'
                    header("Location: ../../disabled_accounts.php");
                    exit();
                }
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with that username.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="alert alert-danger mt-5">
            <?php echo isset($error) ? $error : "Unknown error."; ?>
        </div>
        <a href="../../login.php" class="btn btn-primary">Back to Login</a>
    </div>
</body>
</html>
