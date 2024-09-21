// Data for charts
const pieData = [30, 20, 50];
const barData1 = [5, 10, 7];
const barData2 = [8, 12, 5];

// Plotly charts as before
const pieChart = {
    values: pieData,
    labels: ['Category A', 'Category B', 'Category C'],
    type: 'pie'
};

const pieLayout = { title: 'Pie Chart Example' };
Plotly.newPlot('pie-chart', [pieChart], pieLayout);

const barChart1 = {
    x: ['Group 1', 'Group 2', 'Group 3'],
    y: barData1,
    type: 'bar'
};

const barLayout1 = { title: 'Bar Chart 1' };
Plotly.newPlot('bar-chart1', [barChart1], barLayout1);

const barChart2 = {
    x: ['Group 1', 'Group 2', 'Group 3'],
    y: barData2,
    type: 'bar'
};

const barLayout2 = { title: 'Bar Chart 2' };
Plotly.newPlot('bar-chart2', [barChart2], barLayout2);

// Function to download charts as an image (PNG)
function downloadImage() {
    Plotly.downloadImage(document.getElementById('pie-chart'), {format: 'png', filename: 'pie-chart'});
    Plotly.downloadImage(document.getElementById('bar-chart1'), {format: 'png', filename: 'bar-chart-1'});
    Plotly.downloadImage(document.getElementById('bar-chart2'), {format: 'png', filename: 'bar-chart-2'});
}

// Function to download the page as PDF
function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("SimpleStatistics Dashboard", 20, 20);

    // Convert each chart to an image and add it to PDF
    Plotly.toImage(document.getElementById('pie-chart'), {format: 'png'})
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 15, 30, 180, 90);
            return Plotly.toImage(document.getElementById('bar-chart1'), {format: 'png'});
        })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 15, 130, 180, 90);
            return Plotly.toImage(document.getElementById('bar-chart2'), {format: 'png'});
        })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 15, 230, 180, 90);
            doc.save('dashboard.pdf');
        });
}

// Function to download data as CSV
function downloadCSV() {
    const rows = [
        ['Group', 'Bar Chart 1', 'Bar Chart 2'],
        ['Group 1', barData1[0], barData2[0]],
        ['Group 2', barData1[1], barData2[1]],
        ['Group 3', barData1[2], barData2[2]]
    ];

    let csvContent = "data:text/csv;charset=utf-8," + rows.map(e => e.join(",")).join("\n");
    const link = document.createElement('a');
    link.setAttribute('href', encodeURI(csvContent));
    link.setAttribute('download', 'data.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Function to download data as Excel file
function downloadExcel() {
    const ws_data = [
        ['Group', 'Bar Chart 1', 'Bar Chart 2'],
        ['Group 1', barData1[0], barData2[0]],
        ['Group 2', barData1[1], barData2[1]],
        ['Group 3', barData1[2], barData2[2]]
    ];
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
    XLSX.writeFile(wb, "data.xlsx");
}
