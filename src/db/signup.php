<?php
include 'db_connection.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insert_user($conn, $user_name, $email, $pass, $user_type) {
    $sql = "INSERT INTO user_tbl (user_name, email, pass, user_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_name, $email, $pass, $user_type);
    
    return $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    if (insert_user($conn, $user_name, $email, $pass, $user_type)) {
        if (strtolower($user_type) == 'admin') {
            header("Location: ../../main_pages/admin/pages/dashboard.php");
        } elseif (strtolower($user_type) == 'user') {
            header("Location: ../../main_pages/user/pages/dashboard.php");
        }
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
