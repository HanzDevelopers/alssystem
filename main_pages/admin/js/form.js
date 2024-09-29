document.getElementById('formLink').addEventListener('click', function(event) {
    event.preventDefault();
    // Show the modal when the "Form" link is clicked
    var csvModal = new bootstrap.Modal(document.getElementById('csvModal'), {
        keyboard: false
    });
    csvModal.show();
});

// Handle "Upload CSV" button click
document.getElementById('uploadCsvBtn').addEventListener('click', function() {
    // Redirect to form_upload_csv.php page
    window.location.href = 'form_upload_csv.php';
});

// Handle "Go to Form" button click
document.getElementById('goToFormBtn').addEventListener('click', function() {
    // Redirect to form.php page
    window.location.href = 'form.php';
});