<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    
    <!-- CORE CSS-->
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Dynamic Form</title>
</head>
<body>
    
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <!-- Top nav -->
  <nav class="navbar" style="background-color: #e3f2fd;">
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

  <!-- Side bar -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo '<h5 class="navAdmin offcanvas-title" id="offcanvasScrollingLabel">' . htmlspecialchars($_SESSION['username']) . '</h5>';
            } else {
                echo '<h5 class="navAdmin offcanvas-title" id="offcanvasScrollingLabel">Admin</h5>';
            }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <a class="nav-link" href="form.php">Form</a>
        
        <!-- Report Dropdown -->
        <div class="dropdown mt-3">
            <a class="nav-link dropdown-toggle" href="#" id="reportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Report
            </a>
            <ul class="dropdown-menu" aria-labelledby="reportDropdown">
                <li><a class="dropdown-item" href="#">Brgy. Tankulan OSY</a></li>
                <li><a class="dropdown-item" href="#">Brgy. Tankulan Population</a></li>
                <li><a class="dropdown-item" href="#">OSY By Age</a></li>
                <li><a class="dropdown-item" href="#">List of Interested in ALS</a></li>
            </ul>
        </div>
        
        <!-- Additional Links -->
        <a class="nav-link" href="#">User Log</a>
        <a class="nav-link" href="#">Log Out</a>
    </div>
</div>
<!-- End of side bar -->

<div class="container">
    <h1>Form</h1>
    <form action="handle_form.php" method="POST">
        <div class="group">
        <div class="group">
            <label>Date Encoded:</label>
            <input type="date" name="date_encoded" required>
        </div>
            <label>Year:</label>
            <input type="date" name="year" required>
        </div>
        <div class="group">
            <label>Province:</label>
            <input type="text" name="province" required>
        </div>
        <div class="group">
            <label>City/Municipality:</label>
            <input type="text" name="city" required>
        </div>
        <div class="group">
            <label>Barangay:</label>
            <input type="text" name="barangay" required>
        </div>
        <div class="group">
            <label>Sitio/Zone:</label>
            <input type="text" name="sitio_zone_purok" required>
        </div>
        <div class="group">
            <label>House Number:</label>
            <input type="text" name="house_number" required>
        </div>
        <div class="group">
            <label>Estimated Family Income:</label>
            <input type="number" name="estimated_family_income" required>
        </div>
        <div class="group">
            <label>Other Notes:</label>
            <textarea name="notes" rows="4" cols="50"></textarea>
        </div>
        <table id="dynamicTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Household <br> Members</th>
                    <th>Relationship <br> to Head</th>
                    <th>Birthdate</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Civil <br> Status</th>
                    <th>Person w/ <br> Disability</th>
                    <th>Ethnicity</th>
                    <th>Religion</th>
                    <th>Highest <br> Grade/Year <br> Completed</th>
                    <th>Currently <br> Attending <br> School?</th>
                    <th>Level <br> Enrolled</th>
                    <th>Reasons for <br> Not Attending <br> School</th>
                    <th>Can Read/Write <br> Simple Message <br> in any Language?</th>
                    <th>Occupation</th>
                    <th>Work</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="text" name="household_members[]"></td>
                    <td><input type="text" name="relationship_to_head[]"></td>
                    <td><input type="date" name="birthdate[]"></td>
                    <td><input type="number" name="age[]"></td>
                    <td><input type="text" name="gender[]"></td>
                    <td><input type="text" name="civil_status[]"></td>
                    <td><input type="text" name="disability[]"></td>
                    <td><input type="text" name="ethnicity[]"></td>
                    <td><input type="text" name="religion[]"></td>
                    <td><input type="text" name="highest_grade[]"></td>
                    <td><input type="text" name="attending_school[]"></td>
                    <td><input type="text" name="level_enrolled[]"></td>
                    <td><input type="text" name="reasons_not_attending[]"></td>
                    <td><input type="text" name="can_read_write[]"></td>
                    <td><input type="text" name="occupation[]"></td>
                    <td><input type="text" name="work[]"></td>
                    <td><input type="text" name="status[]"></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-add" onclick="addRow()">Add Row</button>
        <br><br>
        <button type="submit" class="btn btn-save">Save</button>
        <button type="reset" class="btn btn-cancel">Cancel</button>
    </form>
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
    function addRow() {
        const table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);
        const rowCount = table.rows.length + 1;
        newRow.cells[0].innerText = rowCount;
        const inputs = newRow.getElementsByTagName('input');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
        table.appendChild(newRow);
    }

    function deleteRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateRowNumbers();
    }

    function updateRowNumbers() {
        const table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
        const rows = table.rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[0].innerText = i + 1;
        }
    }
</script>
</body>
</html>
