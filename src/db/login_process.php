<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $id_number = $_POST['id_number'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($id_number) && !empty($password)) {
        $stmt = $conn->prepare("SELECT user_id, user_name, id_number, user_type, pass, district, status FROM user_tbl WHERE BINARY user_name = ? AND BINARY id_number = ? LIMIT 1");
        $stmt->bind_param("ss", $username, $id_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['pass'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['user_name'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['district'] = $user['district'];

                if (empty($user['status']) || strtolower($user['status']) == 'enable') {
                    $login_time = date("Y-m-d H:i:s");
                    $log_stmt = $conn->prepare("INSERT INTO user_log (user_id, user_name, login_date) VALUES (?, ?, ?)");
                    $log_stmt->bind_param("iss", $_SESSION['user_id'], $_SESSION['username'], $login_time);
                    $log_stmt->execute();

                    $user_type = strtolower($user['user_type']);
                    if ($user_type == 'supervisor') {
                        header("Location: ../../main_pages/admin/pages/dashboard.php");
                    } elseif ($user_type == 'implementer') {
                        header("Location: ../../main_pages/user/pages/dashboard.php");
                    } elseif ($user_type == 'coordinator') {
                        header("Location: ../../main_pages/head/pages/dashboard.php");
                    }
                    exit();
                } else {
                    header("Location: ../../disabled_accounts.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Invalid password.";
                header("Location: ../../login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "No user found with that username and ID number.";
            header("Location: ../../login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../../login.php");
        exit();
    }
}
?>
