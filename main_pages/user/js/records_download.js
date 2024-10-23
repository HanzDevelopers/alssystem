// Function to download table data as CSV
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to the DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

// Function to export table to Excel
function exportTableToExcel(filename) {
    var table = document.querySelector("table");
    var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
    XLSX.writeFile(wb, filename);
}

// Function to export table to PDF
function exportTableToPDF() {
    var { jsPDF } = window.jspdf;
    var doc = new jsPDF();
    var table = document.querySelector("table");
    var rows = table.querySelectorAll("tr");

    var body = [];

    rows.forEach(function(row) {
        var cols = row.querySelectorAll("td, th");
        var rowData = [];
        cols.forEach(function(col) {
            rowData.push(col.innerText);
        });
        body.push(rowData);
    });

    doc.autoTable({
        head: [body[0]], // Table header
        body: body.slice(1) // Table body
    });

    doc.save("household_records.pdf");
}