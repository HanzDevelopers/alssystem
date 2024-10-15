<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Add User</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Add User</h1>
        <form action="add_user.php" method="POST">
            <div class="mb-3">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Mobile Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                       pattern="^\d{11}$" placeholder="e.g., 09123456789" required>
                <small class="form-text text-muted">Enter a 11-digit mobile number (e.g., 09123456789).</small>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="mb-3">
                <label for="user_type" class="form-label">User Type</label>
                <select class="form-select" id="user_type" name="user_type" required>
                    <option value="" disabled selected>Select User Type</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Coordinator">Coordinator</option>
                    <option value="Volunteer">Volunteer</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select class="form-select" id="district" name="district" required>
                    <option value="" disabled selected>Select District</option>
                    <option value="District 1">District 1</option>
                    <option value="District 2">District 2</option>
                    <option value="District 3">District 3</option>
                    <option value="District 4">District 4</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='users.php';">Cancel</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../../../src/db/db_connection.php';
        $user_name = $_POST['user_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number']; // Capture the phone number
        $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
        $user_type = $_POST['user_type'];
        $district = $_POST['district'];

        // Update the SQL statement to include phone_number
        $sql = "INSERT INTO user_tbl (user_name, email, phone_number, pass, user_type, district) VALUES ('$user_name', '$email', '$phone_number', '$pass', '$user_type', '$district')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully'); window.location.href='users.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
