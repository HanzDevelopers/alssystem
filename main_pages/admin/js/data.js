// data.js

// Function to fetch and plot District OSY Pie Chart
function plotDistrictOSY() {
    fetch('../api/osy_pie_chart.php') // Update the path as needed
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            const pieData = data.counts;
            const pieLabels = data.districts;

            const pieChart = {
                values: pieData,
                labels: pieLabels,
                type: 'pie'
            };

            const pieLayout = { title: 'District OSY (Age 15-30)' };
            Plotly.newPlot('pie-chart', [pieChart], pieLayout);
        })
        .catch(error => console.error('Error fetching District OSY data:', error));
}

// Function to fetch and plot District Population Bar Chart
function plotDistrictPopulation() {
    fetch('../api/district_population.php') // Update the path as needed
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            const barData1 = data.counts;
            const barLabels1 = data.districts;

            // Optionally, exclude 'Unknown District' if it's present
            const filteredLabels = [];
            const filteredData = [];
            for (let i = 0; i < barLabels1.length; i++) {
                if (barLabels1[i] !== 'Unknown District') { // Adjust condition as needed
                    filteredLabels.push(barLabels1[i]);
                    filteredData.push(barData1[i]);
                }
            }

            const barChart1 = {
                x: filteredLabels,
                y: filteredData,
                type: 'bar',
                marker: {
                    color: 'rgba(55,128,191,0.6)',
                    width: 1
                }
            };

            const barLayout1 = { title: 'District Population' };
            Plotly.newPlot('bar-chart1', [barChart1], barLayout1);
        })
        .catch(error => console.error('Error fetching District Population data:', error));
}

// Function to fetch and plot OSY By Age Bar Chart
function plotOSYByAge() {
    fetch('../api/osy_by_age.php') // Update the path as needed
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            const barData2 = data.counts;
            const barLabels2 = data.districts;

            const barChart2 = {
                x: barLabels2,
                y: barData2,
                type: 'bar',
                marker: {
                    color: 'rgba(255,153,51,0.6)',
                    width: 1
                }
            };

            const barLayout2 = { title: 'OSY By Age (15-30)' };
            Plotly.newPlot('bar-chart2', [barChart2], barLayout2);
        })
        .catch(error => console.error('Error fetching OSY By Age data:', error));
}

// Initialize all charts
function initCharts() {
    plotDistrictOSY();
    plotDistrictPopulation();
    plotOSYByAge();
}

// Call the initCharts function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initCharts);

// Function to download charts as images (PNG)
function downloadImage() {
    Plotly.downloadImage(document.getElementById('pie-chart'), {format: 'png', filename: 'district-OSY-chart'});
    Plotly.downloadImage(document.getElementById('bar-chart1'), {format: 'png', filename: 'district-population-chart'});
    Plotly.downloadImage(document.getElementById('bar-chart2'), {format: 'png', filename: 'osy-by-age-chart'});
}

// Function to download the page as PDF
function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("ALS System Dashboard", 20, 20);

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
        })
        .catch(error => console.error('Error generating PDF:', error));
}

// Function to download data as CSV
function downloadCSV() {
    // Fetch data for CSV
    Promise.all([
        fetch('../api/osy_pie_chart.php').then(response => response.json()),
        fetch('../api/district_population.php').then(response => response.json()),
        fetch('../api/osy_by_age.php').then(response => response.json())
    ])
    .then(([osyPieData, districtPopData, osyByAgeData]) => {
        if (osyPieData.error || districtPopData.error || osyByAgeData.error) {
            console.error('Error fetching data for CSV:', osyPieData.error || districtPopData.error || osyByAgeData.error);
            return;
        }

        let csvContent = "data:text/csv;charset=utf-8,";

        // District OSY Section
        csvContent += "District OSY (Age 15-30)\nDistrict,OSY Count\n";
        osyPieData.districts.forEach((district, index) => {
            csvContent += `${district},${osyPieData.counts[index]}\n`;
        });

        // District Population Section
        csvContent += "\nDistrict Population\nDistrict,Population Count\n";
        districtPopData.districts.forEach((district, index) => {
            csvContent += `${district},${districtPopData.counts[index]}\n`;
        });

        // OSY By Age Section
        csvContent += "\nOSY By Age (15-30)\nDistrict,OSY Count\n";
        osyByAgeData.districts.forEach((district, index) => {
            csvContent += `${district},${osyByAgeData.counts[index]}\n`;
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "dashboard_data.csv");
        document.body.appendChild(link); // Required for FF
        link.click();
        document.body.removeChild(link);
    })
    .catch(error => console.error('Error generating CSV:', error));
}

// Function to download data as Excel file
function downloadExcel() {
    // Fetch data for Excel
    Promise.all([
        fetch('../api/osy_pie_chart.php').then(response => response.json()),
        fetch('../api/district_population.php').then(response => response.json()),
        fetch('../api/osy_by_age.php').then(response => response.json())
    ])
    .then(([osyPieData, districtPopData, osyByAgeData]) => {
        if (osyPieData.error || districtPopData.error || osyByAgeData.error) {
            console.error('Error fetching data for Excel:', osyPieData.error || districtPopData.error || osyByAgeData.error);
            return;
        }

        const wb = XLSX.utils.book_new();

        // District OSY Sheet
        const osyPieSheetData = [
            ["District", "OSY Count"]
        ];
        osyPieData.districts.forEach((district, index) => {
            osyPieSheetData.push([district, osyPieData.counts[index]]);
        });
        const osyPieSheet = XLSX.utils.aoa_to_sheet(osyPieSheetData);
        XLSX.utils.book_append_sheet(wb, osyPieSheet, "District OSY");

        // District Population Sheet
        const districtPopSheetData = [
            ["District", "Population Count"]
        ];
        districtPopData.districts.forEach((district, index) => {
            districtPopSheetData.push([district, districtPopData.counts[index]]);
        });
        const districtPopSheet = XLSX.utils.aoa_to_sheet(districtPopSheetData);
        XLSX.utils.book_append_sheet(wb, districtPopSheet, "District Population");

        // OSY By Age Sheet
        const osyByAgeSheetData = [
            ["District", "OSY Count"]
        ];
        osyByAgeData.districts.forEach((district, index) => {
            osyByAgeSheetData.push([district, osyByAgeData.counts[index]]);
        });
        const osyByAgeSheet = XLSX.utils.aoa_to_sheet(osyByAgeSheetData);
        XLSX.utils.book_append_sheet(wb, osyByAgeSheet, "OSY By Age");

        // Write the Excel file
        XLSX.writeFile(wb, "dashboard_data.xlsx");
    })
    .catch(error => console.error('Error generating Excel file:', error));
}
