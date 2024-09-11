<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../src/css/form.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>Household Form</title>
</head>
<style>
    * { font-size: 14px; }
    .table-responsive {
    width: 100%;
    overflow-x: auto;
}

.table-bordered {
    width: 100%;
}

    /* Remove border from inputs in Step 3 table for desktop view */
.step-3-table input {
    border: none;
    outline: none;
    background-color: transparent;
}

/* Add border for inputs in Step 3 table for mobile view */
@media screen and (max-width: 768px) {
    .step-3-table input {
        border: 1px solid #ccc; /* You can adjust the border style, color, and thickness as needed */
        outline: none;
        background-color: white; /* Ensure a consistent background color */
    }
}


    .button-group {
    display: flex;
    justify-content: center; /* Center the buttons horizontally */
    gap: 10px; /* Add space between the buttons */
}
.step-indicator {
    justify-content: space-between;
    margin-bottom: 20px;
}

.step {
    padding: 10px 20px;
    border-radius: 5px;
    background-color: lightgray;
    color: #000;
    cursor: pointer;
}

.step.active {
    background-color: #007bff;
    color: white;
}

.step.completed {
    background-color: #28a745;
    color: white;
}


</style>
<body>
    <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

    <!-- Page Wrapper -->
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
                        <a href="form.php" class="sidebar-link active1">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                            Form
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                            aria-expanded="false" aria-controls="pages">
                            <i class="fa-solid fa-list pe-2"></i>
                            Reports
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">District OSY</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">District Population</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">OSY By Age</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">List of Interested in ALS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
                        User Action
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
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
                                <a href="#" class="sidebar-link">Edit Profile</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Log Out</a>
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
          <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
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
            <div class="container2">
                <h1>Household Form</h1>
                <form method="post" action="handle_form.php" id="householdForm">
                    <!-- Step Indicators -->
                    <div class="step-indicator">
                        <span id="step1-indicator" class="step active">Step 1</span>
                        <span id="step2-indicator" class="step">Step 2</span>
                        <span id="step3-indicator" class="step">Step 3</span>
                    </div>


                    <!-- Step 1 -->
                    <div class="form-step" id="step1">
                        <div class="group-container">
                            <div class="group">
                                <label>Date Encoded:</label>
                <input type="date" name="date_encoded" required>
                                
                            </div>
                            <div class="group">
                                <label>Year:</label>
                                <input type="date" name="year" required>
                            </div>
                            <div class="group">
                                <label>Province:</label>
                                <input type="text" name="province" required placeholder="Province">
                            </div>
                        </div>
                        <div class="group-container">
                            <div class="group">
                                <label>City/Municipality:</label>
                                <input type="text" name="city" required placeholder="City/Municipality">
                            </div>
                            <div class="group">
                                <label>Barangay:</label>
                                <input type="text" name="barangay" required placeholder="Barangay">
                            </div>
                            <div class="group">
                                <label>Sitio/Zone:</label>
                                <input type="text" name="sitio_zone_purok" required placeholder="Sitio/Zone">
                            </div>
                        </div>
                        <div class="group-container">
                            <div class="group">
                                <label>House Number:</label>
                                <input type="text" name="house_number" required placeholder="House Number">
                            </div>
                            <div class="group">
                                <label>Estimated Family Income:</label>
                                <input type="number" name="estimated_family_income" required placeholder="Estimated Family Income">
                            </div>
                            <div class="group">
                                <label>Other Notes:</label>
                                <textarea name="notes" rows="4" cols="50" placeholder="State Notes Here"></textarea>
                             </div>
                        </div>
                        <div class="button-group">
                            <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="form-step" id="step2" style="display:none;">
                        <div class="table-responsive">
                            <table id="dynamicTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Household Members:</th>
                                        <th>Relationship to Head:</th>
                                        <th>Birthdate:</th>
                                        <th>Age:</th>
                                        <th>Gender:</th>
                                        <th>Civil Status:</th>
                                        <th>Person w/ Disability:</th>
                                        <th>Ethnicity:</th>
                                        <th>Religion:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="No.">1</td>
                                        <td data-label="Household Members"><input type="text" name="household_members[]"placeholder="Name of Member"></td>
                                        <td data-label="Relationship to Head"><input type="text" name="relationship_to_head[]"placeholder="Relationship to Head"></td>
                                        <td data-label="Birthdate"><input type="date" name="birthdate[]"></td>
                                        <td data-label="Age"><input type="number" name="age[]" placeholder="Age"></td>
                                        <td data-label="Gender"><input type="text" name="gender[]" placeholder="Gender"></td>
                                        <td data-label="Civil Status"><input type="text" name="civil_status[]" placeholder="Civil Status"></td>
                                        <td data-label="Person w/ Disability"><input type="text" name="disability[]" placeholder="Person w/ Disability"></td>
                                        <td data-label="Ethnicity"><input type="text" name="ethnicity[]" placeholder="Ethnicity"></td>
                                        <td data-label="Religion"><input type="text" name="religion[]" placeholder="Religion"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="button-group-start" style="margin-top: 10px;">
        <button type="button" class="btn btn-add" onclick="addRow()">Add Member</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteLastRow()">Delete Last Row</button>
    </div>
    <div class="button-group">
    <button type="button" class="btn btn-secondary" onclick="previousStep(1)">Previous</button>
    <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
</div>

                    </div>

                    <!-- Step 3 -->
<div class="form-step" id="step3" style="display:none;">
    <div class="table-responsive">
        <table id="step3Table" class="table-bordered step-3-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Household Members</th> <!-- New column for identification -->
                    <th>Highest Grade/Year Completed</th>
                    <th>Currently Attending School?</th>
                    <th>Level Enrolled</th>
                    <th>Reasons for Not Attending School</th>
                    <th>Can Read/Write Simple Message?</th>
                    <th>Occupation</th>
                    <th>Work</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Step 3 rows will be dynamically filled based on Step 2 -->
                
            </tbody>
        </table>
    </div>
    <div class="button-group-container">
    <div class="button-group-start">
        <button type="button" class="btn btn-secondary" onclick="previousStep(2)">Previous</button>
    </div>
    <div class="button-group-end">
        <button type="submit" class="btn btn-save">Save</button>
        <button type="reset" id="cancelButton" class="btn btn-cancel">Cancel</button>
    </div>
</div>

</div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let currentStep = 1;

    function nextStep(step) {
        document.getElementById('step' + currentStep).style.display = 'none';
        currentStep = step;
        document.getElementById('step' + currentStep).style.display = 'block';
        updateStepIndicator();
        if (step === 3) fillStep3Table(); // Fill Step 3 table when navigating to Step 3
    }

    function previousStep(step) {
        document.getElementById('step' + currentStep).style.display = 'none';
        currentStep = step;
        document.getElementById('step' + currentStep).style.display = 'block';
        updateStepIndicator();
    }

    function updateStepIndicator() {
        const indicators = document.querySelectorAll('.step');
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index + 1 === currentStep);
        });
    }

    function fillStep3Table() {
        const step3Table = document.getElementById('step3Table').getElementsByTagName('tbody')[0];
        step3Table.innerHTML = ''; // Clear existing rows

        const step2Table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
        Array.from(step2Table.rows).forEach((row, index) => {
            const householdMember = row.cells[1].querySelector('input').value; // Get household member from Step 2

            const newRow = step3Table.insertRow();
            newRow.innerHTML = `
                <td data-label="No.">${index + 1}</td>
                <td data-label="Household Members">${householdMember}</td> <!-- Add household member here for identification -->
                <td data-label="Highest Grade/Year Completed"><input type="text" name="highest_grade[]" placeholder="Highest Grade/Year Completed"></td>
                <td data-label="Currently Attending School?"><input type="text" name="attending_school[]" placeholder="Currently Attending School?"></td>
                <td data-label="Level Enrolled"><input type="text" name="level_enrolled[]" placeholder="Level Enrolled"></td>
                <td data-label="Reasons for Not Attending School"><input type="text" name="reasons_not_attending[]"placeholder="Reasons for Not Attending School"></td>
                <td data-label="Can Read/Write Simple Message?"><input type="text" name="can_read_write[]"placeholder="Can Read/Write Simple Message?"></td>
                <td data-label="Occupation"><input type="text" name="occupation[]"placeholder="Occupation"></td>
                <td data-label="Work"><input type="text" name="work[]"placeholder="Work"></td>
                <td data-label="Status"><input type="text" name="status[]"placeholder="Status"></td>`;
        });
    }
</script>

    <script>
    // Adding row
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

// Delete the last row
function deleteLastRow() {
    const table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
    const rows = table.rows;

    if (rows.length > 1) { // Ensure there's more than one row
        const lastRow = rows[rows.length - 1];
        const hasData = Array.from(lastRow.getElementsByTagName('input')).some(input => input.value.trim() !== '');
        
        if (hasData) {
            if (confirm('The last row contains data. Are you sure you want to delete it?')) {
                table.deleteRow(rows.length - 1); // Remove the last row
                updateRowNumbers();
            }
        } else {
            table.deleteRow(rows.length - 1); // Remove the last row if it's empty
            updateRowNumbers();
        }
    }
}

function updateRowNumbers() {
    const table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
    const rows = table.rows;
    for (let i = 0; i < rows.length; i++) {
        rows[i].cells[0].innerText = i + 1;
    }
}

// Detect if the form is modified
let isFormModified = false;

// Mark form as modified when any input is changed
document.querySelector('form').addEventListener('input', function() {
    isFormModified = true;
});

// Ask for confirmation when the user tries to refresh or leave the page
window.addEventListener('beforeunload', function(event) {
    if (isFormModified) {
        // Some browsers need returnValue to be set to display a dialog
        event.preventDefault();
        event.returnValue = 'You have unsaved changes, are you sure you want to leave?';
        return 'You have unsaved changes, are you sure you want to leave?';
    }
});

// Confirmation when cancel button is clicked
document.getElementById('cancelButton').addEventListener('click', function(event) {
    // Check if any form input is filled (not empty)
    let isFormNotEmpty = false;
    document.querySelectorAll('input, textarea').forEach(function(input) {
        if (input.type !== 'submit' && input.type !== 'reset' && input.value.trim() !== '') {
            isFormNotEmpty = true;
        }
    });

    // If form is not empty, ask for confirmation
    if (isFormNotEmpty) {
        const confirmCancel = confirm('Are you sure you want to cancel? All changes will be lost.');
        if (confirmCancel) {
            // If confirmed, reset the form
            document.querySelector('form').reset();
        } else {
            // Prevent the form reset
            event.preventDefault();
        }
    } else {
        // If the form is empty, refresh the page
        window.location.reload();
    }
});

// Reset the form modified flag after successful submission
document.querySelector('form').addEventListener('submit', function() {
    isFormModified = false; // Reset flag
});

</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Library -->
  <script type="text/javascript" src="../../../src/js/plugins/jquery-1.11.2.min.js"></script>  
  <!-- materialize js -->
  <script type="text/javascript" src="../../../src/js/materialize.min.js"></script>
  <!-- plugins.js - Some Specific JS codes for Plugin Settings -->
  <script type="text/javascript" src="../../../src/js/plugins.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../../../src/js/nav.js"></script>
</body>
</html>
