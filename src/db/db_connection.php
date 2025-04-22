<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "als";
/*$servername = "sql104.infinityfree.com";
$username = "if0_36897631";
$password = "20201259";
$dbname = "if0_36897631_als";*/
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
