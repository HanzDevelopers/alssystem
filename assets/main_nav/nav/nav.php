<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <!-- CORE CSS-->
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>Dashboard</title>
</head>
<body>
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <div class="wrapper">
      <!-- Sidebar -->
      <aside id="sidebar">
          <div class="h-100">
              <div class="sidebar-logo">
                  <?php
                      session_start();
                      if (isset($_SESSION['username'])) {
                          echo '<a href="#">' . htmlspecialchars($_SESSION['username']) . '</a>';
                      } else {
                          echo '<a href="#">Admin</a>';
                      }
                  ?>
              </div>
              <!-- Sidebar Navigation -->
              <ul class="sidebar-nav">
                  <li class="sidebar-header">Tools & Components</li>
                  <li class="sidebar-item">
                      <a href="form.php" class="sidebar-link"><i class="fa-regular fa-file-lines pe-2"></i>Form</a>
                  </li>
                  <!-- More Sidebar Items -->
              </ul>
          </div>
      </aside>
      <!-- Main Component -->
      <div class="main">
          <nav class="navbar navbar-expand-lg px-3 border-bottom" style="background-color: #e3f2fd;">
              <div class="container-fluid">
                  <!-- Button for sidebar toggle -->
                  <button class="btn btn-light d-lg-none" type="button" id="sidebarToggle">
                      <img src="../../../assets/images/burger-bar.png" alt="Menu" width="30">
                  </button>
                  <!-- Top nav -->
                  <ul class="nav justify-content-end nav-pills">
                      <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                      </li>
                      <!-- More Nav Items -->
                  </ul>
              </div>
          </nav>

          <div class="content p-3">
              <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit...</h1>
          </div>
      </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../../../src/js/plugins/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="../../../src/js/materialize.min.js"></script>
  <script type="text/javascript" src="../../../src/js/plugins.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!--<script src="../../../src/js/nav.js"></script>-->
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
    });
  </script>
</body>
</html>
