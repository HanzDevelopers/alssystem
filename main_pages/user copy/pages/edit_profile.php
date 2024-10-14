<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include '../../../src/db/db_connection.php';

// Fetch the logged-in user's data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_tbl WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit Profile</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Profile</h1>
        <form action="edit_profile.php" method="POST">
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
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter new password if you want to change it">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = intval($_POST['user_id']);
        $user_name = $conn->real_escape_string($_POST['user_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']); // New line for phone number

        // Update SQL query
        $sql = "UPDATE user_tbl SET user_name='$user_name', email='$email', phone_number='$phone_number'"; // Updated query to include phone_number

        // Update password if provided
        if (!empty($_POST['pass'])) {
            $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $sql .= ", pass='$pass'";
        }

        $sql .= " WHERE user_id=$user_id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Profile updated successfully'); window.location.href='dashboard.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
