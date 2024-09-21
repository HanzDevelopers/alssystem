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
            <?php echo isset($error) ? $error : "Sorry, your account has been disabled by the head. Please try contacting your head if this is a mistake."; ?>
        </div>
        <a href="login.php" class="btn btn-primary">Back to Login</a>
    </div>
</body>
</html>