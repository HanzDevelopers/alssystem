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
    <title>Dynamic Form</title>
</head>
<style>
    * { font-size: 14px; }
</style>
<body>
    <!-- Page Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        <!-- (Code for the Sidebar remains the same) -->
        <!-- Main Component -->
        <div class="main">
            <!-- Top nav (Code for the Top Nav remains the same) -->
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
                                <input type="text" name="province" required>
                            </div>
                        </div>
                        <div class="group-container">
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
                        </div>
                        <div class="group-container">
                            <div class="group">
                                <label>House Number:</label>
                                <input type="text" name="house_number" required>
                            </div>
                            <div class="group">
                                <label>Estimated Family Income:</label>
                                <input type="number" name="estimated_family_income" required>
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
                                        <th>Household Members</th>
                                        <th>Relationship to Head</th>
                                        <th>Birthdate</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Civil Status</th>
                                        <th>Person w/ Disability</th>
                                        <th>Ethnicity</th>
                                        <th>Religion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="No.">1</td>
                                        <td data-label="Household Members"><input type="text" name="household_members[]"></td>
                                        <td data-label="Relationship to Head"><input type="text" name="relationship_to_head[]"></td>
                                        <td data-label="Birthdate"><input type="date" name="birthdate[]"></td>
                                        <td data-label="Age"><input type="number" name="age[]"></td>
                                        <td data-label="Gender"><input type="text" name="gender[]"></td>
                                        <td data-label="Civil Status"><input type="text" name="civil_status[]"></td>
                                        <td data-label="Person w/ Disability"><input type="text" name="disability[]"></td>
                                        <td data-label="Ethnicity"><input type="text" name="ethnicity[]"></td>
                                        <td data-label="Religion"><input type="text" name="religion[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary" onclick="previousStep(1)">Previous</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="form-step" id="step3" style="display:none;">
                        <div class="table-responsive">
                            <table id="step3Table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
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
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary" onclick="previousStep(2)">Previous</button>
                            <button type="submit" class="btn btn-success">Submit</button>
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
            if (step === 3) fillStep3Table();
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
                const newRow = step3Table.insertRow();
                newRow.innerHTML = `
                    <td>${index + 1}</td>
                    <td><input type="text" name="highest_grade[]"></td>
                    <td><input type="text" name="attending_school[]"></td>
                    <td><input type="text" name="level_enrolled[]"></td>
                    <td><input type="text" name="reasons_not_attending[]"></td>
                    <td><input type="text" name="can_read_write[]"></td>
                    <td><input type="text" name="occupation[]"></td>
                    <td><input type="text" name="work[]"></td>
                    <td><input type="text" name="status[]"></td>`;
            });
        }
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
