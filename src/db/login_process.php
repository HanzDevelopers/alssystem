<?php
session_start();
require 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Making the username comparison case-sensitive
        $stmt = $conn->prepare("SELECT user_id, user_name, user_type, pass, district, status FROM user_tbl WHERE BINARY user_name = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['pass'])) {
                // Setting session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['user_name'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['district'] = $user['district']; // Include district in session

                // Debug line to check if the district is correctly set
                var_dump($_SESSION);

                // Check user status
                if (empty($user['status']) || strtolower($user['status']) == 'enable') {
                    $login_time = date("Y-m-d H:i:s");
                    $log_stmt = $conn->prepare("INSERT INTO user_log (user_id, user_name, login_date) VALUES (?, ?, ?)");
                    $log_stmt->bind_param("iss", $_SESSION['user_id'], $_SESSION['username'], $login_time);
                    $log_stmt->execute();

                    // Check user type for redirection
                    $user_type = strtolower($user['user_type']);
                    if ($user_type == 'supervisor') {
                        header("Location: ../../main_pages/admin/pages/dashboard.php");
                    } elseif ($user_type == 'volunteer') {
                        header("Location: ../../main_pages/user/pages/dashboard.php");
                    } elseif ($user_type == 'coordinator') {
                        header("Location: ../../main_pages/head/pages/dashboard.php");
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
