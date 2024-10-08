// data.js

// Function to fetch and plot District OSY Pie Chart with animation
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

            // Initial data with zero values for animation
            const initialPieData = {
                values: Array(pieData.length).fill(0),
                labels: pieLabels,
                type: 'pie',
                textinfo: 'label+percent',
                hoverinfo: 'label+percent+value',
                marker: {
                    colors: Plotly.d3.schemeCategory10
                }
            };

            const pieLayout = { 
                title: 'District OSY (Age 15-30)',
                transition: {
                    duration: 1000,
                    easing: 'cubic-in-out'
                }
            };

            Plotly.newPlot('pie-chart', [initialPieData], pieLayout).then(() => {
                // Animate to actual data
                Plotly.animate('pie-chart', {
                    data: [{ values: pieData }],
                    traces: [0],
                    layout: {}
                }, {
                    transition: {
                        duration: 1000,
                        easing: 'cubic-in-out'
                    },
                    frame: {
                        duration: 1000,
                        redraw: false
                    }
                });
            });
        })
        .catch(error => console.error('Error fetching District OSY data:', error));
}

// Function to fetch and plot District Population Bar Chart with animation
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

            // Initial data with zero heights for animation
            const initialBarChart1 = {
                x: filteredLabels,
                y: Array(filteredData.length).fill(0),
                type: 'bar',
                marker: {
                    color: 'rgba(55,128,191,0.6)',
                    width: 1
                }
            };

            const barLayout1 = { 
                title: 'District Population',
                transition: {
                    duration: 1000,
                    easing: 'cubic-in-out'
                }
            };

            Plotly.newPlot('bar-chart1', [initialBarChart1], barLayout1).then(() => {
                // Animate to actual data
                Plotly.animate('bar-chart1', {
                    data: [{ y: filteredData }],
                    traces: [0],
                    layout: {}
                }, {
                    transition: {
                        duration: 1000,
                        easing: 'cubic-in-out'
                    },
                    frame: {
                        duration: 1000,
                        redraw: false
                    }
                });
            });
        })
        .catch(error => console.error('Error fetching District Population data:', error));
}

// Function to fetch and plot OSY By Age Bar Chart with animation
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

            // Initial data with zero heights for animation
            const initialBarChart2 = {
                x: barLabels2,
                y: Array(barData2.length).fill(0),
                type: 'bar',
                marker: {
                    color: 'rgba(255,153,51,0.6)',
                    width: 1
                }
            };

            const barLayout2 = { 
                title: 'OSY By Age (15-30)',
                transition: {
                    duration: 1000,
                    easing: 'cubic-in-out'
                }
            };

            Plotly.newPlot('bar-chart2', [initialBarChart2], barLayout2).then(() => {
                // Animate to actual data
                Plotly.animate('bar-chart2', {
                    data: [{ y: barData2 }],
                    traces: [0],
                    layout: {}
                }, {
                    transition: {
                        duration: 1000,
                        easing: 'cubic-in-out'
                    },
                    frame: {
                        duration: 1000,
                        redraw: false
                    }
                });
            });
        })
        .catch(error => console.error('Error fetching OSY By Age data:', error));
}

// Function to handle "View Info" button clicks
function setupViewInfoButtons() {
    // Select all buttons with the class 'view-info-btn'
    const viewInfoButtons = document.querySelectorAll('.view-info-btn');

    viewInfoButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retrieve the chart type from the data-chart attribute
            const chartType = this.getAttribute('data-chart');

            // Redirect to sample.php with the chart type as a query parameter
            // For example: sample.php?chart=pie
            window.location.href = `sample.php?chart=${encodeURIComponent(chartType)}`;
        });
    });
}

// Initialize all charts and setup buttons
function initCharts() {
    plotDistrictOSY();
    plotDistrictPopulation();
    plotOSYByAge();
    setupViewInfoButtons(); // Setup buttons after initializing charts
}

// Call the initCharts function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initCharts);


// Initialize all charts and setup buttons
function initCharts() {
    plotDistrictOSY();
    plotDistrictPopulation();
    plotOSYByAge();
    setupViewInfoButtons(); // Setup buttons after initializing charts
}

// Call the initCharts function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initCharts);

// Function to download charts as images (PNG)
function downloadImage() {
    Plotly.downloadImage(document.getElementById('pie-chart'), {format: 'png', filename: 'district-OSY-chart'});
    Plotly.downloadImage(document.getElementById('bar-chart1'), {format: 'png', filename: 'district-population-chart'});
    Plotly.downloadImage(document.getElementById('bar-chart2'), {format: 'png', filename: 'osy-by-age-chart'});
}

function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("ALS System Dashboard", 10, 10);

    // Convert each chart to an image and add each to a new page in the PDF
    Plotly.toImage(document.getElementById('pie-chart'), { format: 'png', width: 900, height: 600 })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 10, 30, 190, 120); // Adjusted size for pie chart
            doc.addPage();  // Add a new page for the next chart
            return Plotly.toImage(document.getElementById('bar-chart1'), { format: 'png', width: 900, height: 600 });
        })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 10, 30, 190, 120); // Adjusted size for first bar chart
            doc.addPage();  // Add another page for the third chart
            return Plotly.toImage(document.getElementById('bar-chart2'), { format: 'png', width: 900, height: 600 });
        })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 10, 30, 190, 120); // Adjusted size for second bar chart
            doc.save('dashboard.pdf');  // Save the multi-page PDF
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
