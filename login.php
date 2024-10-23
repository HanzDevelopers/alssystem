<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/login.css">
    <link rel="stylesheet" href="src/css/nav_active.css">
    <link href="src/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <title>Login</title>
    <style>
        .form-container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <div class="form-container">
        <div class="form">
            <form action="src/db/login_process.php" method="post">
                <div id="emailHelp" class="form-text">Please use your organizational account provided by the admin</div>
                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="src/js/plugins/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="src/js/materialize.min.js"></script>
    <script type="text/javascript" src="src/js/plugins.min.js"></script>
</body>
</html>
