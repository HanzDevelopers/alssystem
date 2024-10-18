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

            const pieLayout = { title: 'District OSY' };
            Plotly.newPlot('pie-chart', [pieChart], pieLayout);
        })
        .catch(error => console.error('Error fetching District OSY data:', error));
}

function plotDistrictPopulation() {
    fetch('../api/district_population.php') // Update the path as needed
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            const barData = data.counts; // Population counts for each barangay
            const barLabels = data.barangays; // Barangay names

            // Debugging logs
            console.log('Barangay Names:', barLabels);
            console.log('Population Counts:', barData);

            const barChart = {
                x: barLabels, // Use barangay names for the x-axis
                y: barData, // Population counts for the y-axis
                type: 'bar',
                marker: {
                    color: 'rgba(55,128,191,0.6)',
                    width: 1
                },
                text: barData.map(String), // Optional: Display counts as text on bars
                textposition: 'auto' // Position text on the bars
            };

            const barLayout = {
                title: 'District Population',
                xaxis: { title: 'Barangays' }, // Change to 'Barangays'
                yaxis: { title: 'Total Population' } // Add y-axis title
            };

            // Render the bar chart in the 'bar-chart1' div
            Plotly.newPlot('bar-chart1', [barChart], barLayout);
        })
        .catch(error => console.error('Error fetching District Population data:', error));
}

// Call the function to plot the chart
plotDistrictPopulation();

// Function to fetch and plot OSY By Age Bar Chart
function plotOSYByAge() {
    fetch('../api/osy_by_age.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            const years = [...new Set(data.map(item => item.year))];
            const ageRanges = ['15-20', '21-25', '26-30'];
            const colors = {
                '15-20': 'rgba(54,162,235,0.6)',  // Blue for 15-20
                '21-25': 'rgba(255,159,64,0.6)',  // Orange for 21-25
                '26-30': 'rgba(201,203,207,0.6)'  // Grey for 26-30
            };

            const traces = ageRanges.map(ageRange => {
                return {
                    x: years,
                    y: years.map(year => {
                        const osyForYearAndRange = data.find(d => d.year === year && d.age_range === ageRange);
                        return osyForYearAndRange ? osyForYearAndRange.osy_count : 0;
                    }),
                    name: ageRange,
                    type: 'bar',
                    marker: { color: colors[ageRange] },
                    text: years.map(year => {
                        const osyForYearAndRange = data.find(d => d.year === year && d.age_range === ageRange);
                        return osyForYearAndRange ? osyForYearAndRange.osy_count : 0;
                    }),
                    textposition: 'auto'  // To display numbers on top of the bars
                };
            });

            const layout = {
                title: 'OSY by Age',
                barmode: 'group',  // Group the bars side by side
                xaxis: { title: 'Year' },
                yaxis: { title: 'OSY Count', tickformat: ',d' },
                margin: { t: 40, b: 40, l: 40, r: 40 },
                showlegend: true
            };

            Plotly.newPlot('bar-chart2', traces, layout);
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
    Plotly.toImage(document.getElementById('pie-chart'), { format: 'png' })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 15, 30, 180, 90);
            doc.addPage(); // Add a new page for the next chart
            return Plotly.toImage(document.getElementById('bar-chart1'), { format: 'png' });
        })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 15, 30, 180, 90);
            doc.addPage(); // Add a new page for the next chart
            return Plotly.toImage(document.getElementById('bar-chart2'), { format: 'png' });
        })
        .then(function (imgData) {
            doc.addImage(imgData, 'PNG', 15, 30, 180, 90);
            // Save the PDF after adding all charts
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
        csvContent += "\nOSY By Age (15-30)\nYear,Age Range,OSY Count\n";
        osyByAgeData.forEach((data) => {
            csvContent += `${data.year},${data.age_range},${data.osy_count}\n`;
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

        const workbook = XLSX.utils.book_new();

        // District OSY Sheet
        const osyData = osyPieData.districts.map((district, index) => ({
            District: district,
            OSY_Count: osyPieData.counts[index]
        }));
        const osySheet = XLSX.utils.json_to_sheet(osyData);
        XLSX.utils.book_append_sheet(workbook, osySheet, 'District OSY');

        // District Population Sheet
        const populationData = districtPopData.districts.map((district, index) => ({
            District: district,
            Population_Count: districtPopData.counts[index]
        }));
        const populationSheet = XLSX.utils.json_to_sheet(populationData);
        XLSX.utils.book_append_sheet(workbook, populationSheet, 'District Population');

        // OSY By Age Sheet
        const osyByAgeDataFormatted = osyByAgeData.map(data => ({
            Year: data.year,
            Age_Range: data.age_range,
            OSY_Count: data.osy_count
        }));
        const ageSheet = XLSX.utils.json_to_sheet(osyByAgeDataFormatted);
        XLSX.utils.book_append_sheet(workbook, ageSheet, 'OSY By Age');

        // Export the Excel file
        XLSX.writeFile(workbook, 'dashboard_data.xlsx');
    })
    .catch(error => console.error('Error generating Excel:', error));
}
