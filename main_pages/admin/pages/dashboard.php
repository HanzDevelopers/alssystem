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
                    <li class="sidebar-header">
                        Tools & Components
                    </li>
                    <li class="sidebar-item">
                        <a href="form.php" class="sidebar-link">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                            Form
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="reports.php" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                            aria-expanded="false" aria-controls="pages">
                            <i class="fa-solid fa-list pe-2"></i>
                            Reports
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="district_osy.php" class="sidebar-link">District OSY</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="district_population.php" class="sidebar-link">District Population</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="OSY_age.php" class="sidebar-link">OSY By Age</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="interested.php" class="sidebar-link">List of Interested in ALS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
                        User Action
                    </li>
                    <li class="sidebar-item">
                        <a href="user_log.php" class="sidebar-link">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                            User Log
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                            aria-expanded="false" aria-controls="auth">
                            <i class="fa-regular fa-user pe-2"></i>
                            Auth
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                          
                        <li class="sidebar-item">
                                <a href="edit_profile.php" class="sidebar-link">Edit Profile</a>
                            </li>
                            <li class="sidebar-item">
                            <a href="logout.php" class="sidebar-link" onclick="return confirmLogout();">Log Out</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </aside>
        <!-- Main Component -->
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom" style="background-color: #e3f2fd;">
                <!-- Button for sidebar toggle -->
                <!-- Top nav -->
    <div class="container">
      <button class="btn btn-light-border-subtle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><img src="../../../assets/images/burger-bar.png" alt="Menu" width="30"></button>
      <ul class="nav justify-content-end nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="records.php">Records</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="navbar-brand" href="#">
            <img src="../../../assets/images/logo.png" alt="Bootstrap" width="40" height="30">
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End of top nav -->

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
          District OSY
          </div>
          <div class="card-body">
            <canvas id="pieChart"></canvas>
            <a href="#" class="btn btn-primary mt-2">View Info</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
          District Population
          </div>
          <div class="card-body">
            <canvas id="barChart"></canvas>
            <a href="#" class="btn btn-primary mt-2">View Info</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
          OSY By Age
          </div>
          <div class="card-body">
            <canvas id="barChart2"></canvas>
            <a href="#" class="btn btn-primary mt-2">View Info</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- jQuery Library -->
  <script type="text/javascript" src="../../../src/js/plugins/jquery-1.11.2.min.js"></script>  
  <!-- materialize js -->
  <script type="text/javascript" src="../../../src/js/materialize.min.js"></script>
  <!-- plugins.js - Some Specific JS codes for Plugin Settings -->
  <script type="text/javascript" src="../../../src/js/plugins.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Mangima', 'Proper Calanawan', 'Upper Calanawan', 'Lower Calanawan', 'Centro', 'Lower Pol-Oton', 'Upper Pol-Oton', 'Mulberry', 'Kihare', 'Tumampong', 'Upper Sosohon', 'Lower Sosohon', 'st. Joseph'],
        datasets: [{
          label: 'Brg. Tankulan OSY',
          data: [5, 4, 5, 10, 20, 20, 6, 5, 25, 3, 10, 5, 2],
          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FFCD56', '#36A2EB', '#FF6384', '#FF9F40', '#4BC0C0', '#9966FF','#9945FF']
        }]
        
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    var ctx2 = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Mangima', 'Proper Calanawan', 'Upper Calanawan', 'Lower Calanawan', 'Centro', 'Lower Pol-Oton', 'Upper Pol-Oton', 'Mulberry', 'Kihare', 'Tumampong', 'Upper Sosohon', 'Lower Sosohon', 'st. Joseph'],
        datasets: [{
          label: 'Population',
          data: [230, 168, 130, 111, 578, 126, 169, 354, 211, 110, 200, 169, 259],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx3 = document.getElementById('barChart2').getContext('2d');
    var barChart2 = new Chart(ctx3, {
      type: 'bar',
      data: {
        labels: ['2021', '2022', '2023', '2024'],
        datasets: [{
          label: '15-20',
          data: [4.3, 2.5, 3.5, 4.5],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }, {
          label: '21-25',
          data: [3, 4, 3, 3],
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }, {
          label: '26-30',
          data: [1, 1.5, 2, 2.5],
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="../../../src/js/nav.js"></script>
        <!-- Confirmation Script -->
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>
</body>
</html>