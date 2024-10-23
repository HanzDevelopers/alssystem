<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <link href="../../../src/css/style.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/form.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../src/css/nav.css">
    <title>Household Form</title>
</head>
<style>
    * { font-size: 12px; }
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
  <!-- End of top nav -->
            <div class="container2">
                <h1>Household Form</h1>
                <form method="post" action="handle_form.php" id="householdForm">
                    <!-- Step Indicators -->
                    <div class="step-indicator">
    <span id="step1-indicator" class="step active" onclick="goToStep(1)">Location</span>
    <span id="step2-indicator" class="step" onclick="goToStep(2)">Members</span>
    <span id="step3-indicator" class="step" onclick="goToStep(3)">Background</span>
</div>



                    <!-- Step 1 -->
<div class="form-step" id="step1">
    <div class="group-container">
        <div class="group">
            <label>Origin Date:</label>
            <input type="date" name="date_encoded" required>
        </div>

        <div class="group">
            <label>Barangay:</label>
            <input type="text" id="barangay" name="barangay" required placeholder="Barangay" oninput="updateLocation()">
        </div>

        <div class="group">
            <label>Estimated Family Income:</label>
            <input type="number" name="estimated_family_income" required placeholder="Estimated Family Income">
        </div>
    </div>

    <div class="group-container">
        <div class="group">
            <label>House Number:</label>
            <input type="text" name="house_number" required placeholder="House Number">
        </div>

        <div class="group">
            <label>City/Municipality:</label>
            <input type="text" id="city" name="city" required placeholder="City/Municipality">
        </div>

        <div class="group">
            <label>Other Notes:</label>
            <textarea name="notes" rows="2" cols="50" placeholder="State Notes Here"></textarea>
        </div>
    </div>

    <div class="group-container">
        <div class="group">
            <label>Sitio/Zone:</label>
            <input type="text" name="sitio_zone_purok" required placeholder="Sitio/Zone">
        </div>

        <div class="group">
            <label>Province:</label>
            <input type="text" id="province" name="province" required placeholder="Province">
        </div>
        <div class="group">
        </div>
    </div>

    <div class="button-group">
        <span id="dashboard" class="dashboard" onclick="dashboard()">Leave form</span>
        <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
    </div>
</div>

<script>
    function updateLocation() {
        // List of barangays
        const barangays = [
            'tankulan', 'diclum', 'san miguel', 'ticala', 'lingion',
            'alae', 'damilag', 'mambatangan', 'mantibugao', 'minsuro', 'lunocan',
            'agusan canyon', 'agusan-canyon', 'mampayag', 'dahilayan', 'sankanan',
            'kalugmanan', 'lindaban', 'dalirig', 'maluko', 'santiago', 'guilang2', 'guilang-guilang'
        ];

        // Get the value from the Barangay input
        const barangayInput = document.getElementById('barangay').value.toLowerCase();

        // Check if the input value matches any barangay in the list
        if (barangays.includes(barangayInput)) {
            document.getElementById('city').value = 'Manolo Fortich';
            document.getElementById('province').value = 'Bukidnon';
        } else {
            // Clear the city and province fields if no match is found
            document.getElementById('city').value = '';
            document.getElementById('province').value = '';
        }
    }
</script>

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
                    <td data-label="Household Members">
                        <input type="text" name="household_members[]" placeholder="Name of Member">
                    </td>
                    <td data-label="Relationship to Head">
                        <input type="text" name="relationship_to_head[]" placeholder="Relationship to Head" oninput="showRelationshipSuggestions(this)">
                        <div class="suggestions-box" id="relationship-suggestions"></div>
                    </td>
                    <td data-label="Birthdate">
                        <input type="date" name="birthdate[]" onchange="calculateAge(this)">
                    </td>
                    <td data-label="Age">
                        <input type="number" name="age[]" placeholder="Age" readonly>
                    </td>
                    <td data-label="Gender">
                        <input type="text" name="gender[]" placeholder="Gender">
                    </td>
                    <td data-label="Civil Status">
                        <input type="text" name="civil_status[]" placeholder="Civil Status" oninput="showCivilStatusSuggestions(this)">
                        <div class="suggestions-box" id="civil-status-suggestions"></div>
                    </td>
                    <td data-label="Person w/ Disability">
                        <input type="text" name="disability[]" placeholder="Person w/ Disability" oninput="showDisabilitySuggestions(this)">
                        <div class="suggestions-box" id="disability-suggestions"></div>
                    </td>
                    <td data-label="Ethnicity">
                        <input type="text" name="ethnicity[]" placeholder="Ethnicity" oninput="showEthnicitySuggestions(this)">
                        <div class="suggestions-box" id="ethnicity-suggestions"></div>
                    </td>
                    <td data-label="Religion">
                        <input type="text" name="religion[]" placeholder="Religion" oninput="showReligionSuggestions(this)">
                        <div class="suggestions-box" id="religion-suggestions"></div>
                    </td>
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

<!-- CSS for Suggestions Box -->
<style>
    .suggestions-box {
        border: 1px solid #ccc;
        border-top: none;
        position: absolute;
        background-color: white;
        z-index: 1000;
        max-height: 150px;
        overflow-y: auto;
        width: calc(100% - 22px); /* Same width as the input field */
        display: none; /* Initially hidden */
    }

    .suggestion-item {
        padding: 8px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #f0f0f0;
    }
</style>

<script>
    const relationships = [
        'Head', 'Spouse', 'Son', 'Daughter', 'Stepson', 'Stepdaughter', 
        'Son-in-law', 'Daughter-in-law', 'Grandson', 'Granddaughter', 
        'Father', 'Mother', 'Brother', 'Sister', 'Uncle', 'Aunt', 
        'Nephew', 'Niece', 'Housemaid', 'Houseboy', 'Others (nonrelative/boarder)'
    ];

    const civilStatuses = [
        'Single', 'Married', 'Widower', 'Separated', 'Live-in'
    ];

    const disabilities = [
        'Partially Hearing Impaired', 'Totally Hearing Impaired', 
        'Partially Visually Impaired', 'Totally Visually Impaired', 
        'Physically Impaired', 'W/ Special Needs'
    ];

    const ethnicities = [
        'Boholano', 'Bukidnon', 'Cebuano', 'Higa-onon', 
        'Ilocano', 'Ilonggo', 'Manobo', 'Matigsalog', 
        'Talaandig', 'Others (specify)'
    ];

    const religions = [
        'Roman Catholic', 'Islam', 'Iglesia ni Kristo', 'Aglipayan', 
        'Protestant', 'Jehovah\'s Witness', 'Seventh Day Adventist', 
        'Baptist', 'Mormons', 'Others (specify)', 'None'
    ];

    function showSuggestions(input, suggestionsArray, suggestionsBoxId) {
        const inputValue = input.value.toLowerCase();
        const suggestionsBox = document.getElementById(suggestionsBoxId);
        suggestionsBox.innerHTML = ''; // Clear previous suggestions
        suggestionsBox.style.display = 'none'; // Hide suggestions initially

        // Filter suggestions based on input
        const filteredSuggestions = suggestionsArray.filter(item =>
            item.toLowerCase().startsWith(inputValue)
        );

        // Show suggestions if any match
        if (filteredSuggestions.length > 0 && inputValue.length > 0) {
            filteredSuggestions.forEach(item => {
                const suggestionItem = document.createElement('div');
                suggestionItem.className = 'suggestion-item';
                suggestionItem.textContent = item;

                // Set the input value to the clicked suggestion
                suggestionItem.onclick = function() {
                    input.value = item;
                    suggestionsBox.innerHTML = ''; // Clear suggestions
                    suggestionsBox.style.display = 'none'; // Hide suggestions
                };

                suggestionsBox.appendChild(suggestionItem);
            });
            suggestionsBox.style.display = 'block'; // Show suggestions
        }
    }

    function showRelationshipSuggestions(input) {
        showSuggestions(input, relationships, 'relationship-suggestions');
    }

    function showCivilStatusSuggestions(input) {
        showSuggestions(input, civilStatuses, 'civil-status-suggestions');
    }

    function showDisabilitySuggestions(input) {
        showSuggestions(input, disabilities, 'disability-suggestions');
    }

    function showEthnicitySuggestions(input) {
        showSuggestions(input, ethnicities, 'ethnicity-suggestions');
    }

    function showReligionSuggestions(input) {
        showSuggestions(input, religions, 'religion-suggestions');
    }

    // Optional: Close suggestion box when clicking outside
    document.addEventListener('click', function(e) {
        const suggestionBoxes = document.querySelectorAll('.suggestions-box');
        suggestionBoxes.forEach(box => {
            if (!box.previousElementSibling.contains(e.target)) {
                box.innerHTML = '';
                box.style.display = 'none';
            }
        });
    });
</script>


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
        function calculateAge(birthdateInput) {
    const birthdate = new Date(birthdateInput.value);
    const today = new Date();
    let age = today.getFullYear() - birthdate.getFullYear();
    const monthDiff = today.getMonth() - birthdate.getMonth();

    // Adjust age if birth month hasn't been reached or if it's the birth month but the birthdate hasn't occurred yet
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }

    // Find the corresponding age input field and set its value
    const ageInput = birthdateInput.closest('tr').querySelector('input[name="age[]"]');
    ageInput.value = age;
}

        function goToStep(step) {
    document.getElementById('step' + currentStep).style.display = 'none';  // Hide the current step
    currentStep = step;  // Update current step
    document.getElementById('step' + currentStep).style.display = 'block';  // Show the selected step
    updateStepIndicator();  // Update the step indicator
    if (step === 3) fillStep3Table();  // Fill Step 3 table if it's the last step
}

let currentStep = 1;

function nextStep(step) {
    const currentInputs = document.getElementById('step' + currentStep).querySelectorAll('input');
    let emptyFields = [];
    
    // Check for empty fields in the current step
    currentInputs.forEach(input => {
        if (input.value.trim() === '') {
            emptyFields.push(input.placeholder); // Collect placeholders of empty fields
        }
    });

    // If there are empty fields, show a single alert
    if (emptyFields.length > 0) {
        alert('Please fill in the following fields:\n' + emptyFields.join('\n'));
        return; // Stop the function if there are empty fields
    }

    // Proceed to the next step if there are no empty fields
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

function validateCurrentStep() {
    let isValid = true;
    const step = document.getElementById('step' + currentStep);
    const inputs = step.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        if (input.hasAttribute('required') && input.value.trim() === '') {
            isValid = false;
            alert(`Please fill out the ${input.previousElementSibling.innerText} field.`);
        }
    });

    return isValid;
}

function fillStep3Table() {
    const step3Table = document.getElementById('step3Table').getElementsByTagName('tbody')[0];
    step3Table.innerHTML = ''; // Clear existing rows

    const step2Table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
    Array.from(step2Table.rows).forEach((row, index) => {
        const householdMember = row.cells[1].querySelector('input').value; // Get household member from Step 2
        const inputs = row.querySelectorAll('input');
        let hasEmptyField = false;

        // Check if all fields in the row are filled
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                hasEmptyField = true;
            }
        });

        // Only add the row to Step 3 if all fields are filled
        if (!hasEmptyField) {
            const newRow = step3Table.insertRow();
            newRow.innerHTML = `
                <td data-label="No.">${index + 1}</td>
                <td data-label="Household Members">${householdMember}</td> <!-- Add household member here for identification -->
                <td data-label="Highest Grade/Year Completed"><input type="text" name="highest_grade[]" placeholder="Grade/Year"></td>
                <td data-label="Currently Attending School?"><input type="text" name="attending_school[]" placeholder="Yes/No"></td>
                <td data-label="Level Enrolled"><input type="text" name="level_enrolled[]" placeholder="Level Enrolled"></td>
                <td data-label="Reasons for Not Attending School"><input type="text" name="reasons_not_attending[]" placeholder="Reasons"></td>
                <td data-label="Can Read/Write Simple Message?"><input type="text" name="can_read_write[]" placeholder="Yes/No"></td>
                <td data-label="Occupation"><input type="text" name="occupation[]" placeholder="Occupation"></td>
                <td data-label="Work"><input type="text" name="work[]" placeholder="Current Work"></td>
                <td data-label="Status">
                    <small style="font-weight: normal; color: gray;">Interested in ALS?</small>
                    <br>
                    <input type="text" name="status[]" placeholder="Yes/No">
                </td>`;
        }
    });
}


document.querySelector('form').addEventListener('submit', function(event) {
    // Prevent form submission if there are missing fields
    if (!validateRows()) {
        event.preventDefault();
    }
});

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
document.querySelector('form').addEventListener('submit', function(event) {
    // Prevent form submission if there are missing fields
    if (!validateRows()) {
        event.preventDefault();
    }
});

function validateRows() {
    const step2Rows = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0].rows;
    let isValid = true;
    let alertMessage = '';
    
    // Loop through each row in Step 2
    for (let i = 0; i < step2Rows.length; i++) {
        const inputs = step2Rows[i].querySelectorAll('input');
        let isRowComplete = true;

        // Check if any of the inputs are empty
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                isRowComplete = false;
            }
        });

        // If the row is incomplete
        if (!isRowComplete) {
            alertMessage += `Row ${i + 1} has missing fields. Please complete all fields.\n`;
            isValid = false;
        }
    }

    // Alert the user if there are any incomplete rows
    if (!isValid) {
        alert(alertMessage);
    }

    return isValid; // Return true if all rows are complete, otherwise false
}

// Confirmation when back to dashboard button is clicked
document.getElementById('dashboard').addEventListener('click', function(event) {
    // Check if any form input is filled (not empty)
    let isFormNotEmpty = false;
    document.querySelectorAll('input, textarea').forEach(function(input) {
        if (input.type !== 'submit' && input.type !== 'reset' && input.value.trim() !== '') {
            isFormNotEmpty = true;
        }
    });

    // If form is not empty, ask for confirmation
    if (isFormNotEmpty) {
        const confirmCancel = confirm('Are you sure you want to go back to the dashboard? All changes will be lost.');
        if (confirmCancel) {
            // Redirect the user to dashboard.php instead of resetting the form
            window.location.href = 'dashboard.php';
        } else {
            // Prevent the default action (navigation)
            event.preventDefault();
        }
    } else {
        // If the form is empty, simply redirect to dashboard.php
        window.location.href = 'dashboard.php';
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
        const confirmCancel = confirm('Are you sure you want to cancel? All changes will be lost and you will redirect to dashboard.');
        if (confirmCancel) {
            // Redirect the user to dashboard.php instead of resetting the form
            window.location.href = 'dashboard.php';
        } else {
            // Prevent the default action (navigation)
            event.preventDefault();
        }
    } else {
        // If the form is empty, simply redirect to dashboard.php
        window.location.href = 'dashboard.php';
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
