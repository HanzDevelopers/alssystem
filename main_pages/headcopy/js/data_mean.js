// data.js

// Include SimpleStatistics by adding this to your HTML file:
// <script src="https://unpkg.com/simple-statistics@7.0.2/dist/simple-statistics.min.js"></script>

// Function to fetch and plot District OSY Pie Chart with SimpleStatistics
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

            // SimpleStatistics Operations for District OSY Pie Chart
            const totalOSYs = ss.sum(pieData);
            const osyPercentages = pieData.map(count => (count / totalOSYs) * 100);
            const rangeOSY = ss.max(pieData) - ss.min(pieData);
            
            console.log("District OSY Total:", totalOSYs);
            console.log("District OSY Percentages:", osyPercentages);
            console.log("District OSY Range:", rangeOSY);

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

// Function to fetch and plot District Population Bar Chart with SimpleStatistics
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

            // SimpleStatistics Operations for District Population
            const meanPopulation = ss.mean(filteredData);
            const medianPopulation = ss.median(filteredData);
            const stdDevPopulation = ss.standardDeviation(filteredData);
            
            console.log("Mean Population:", meanPopulation);
            console.log("Median Population:", medianPopulation);
            console.log("Population Standard Deviation:", stdDevPopulation);

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

// Function to fetch and plot OSY By Age Bar Chart with SimpleStatistics
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

            // SimpleStatistics Operations for OSY By Age
            const meanOSY = ss.mean(barData2);
            const modeOSY = ss.mode(barData2);
            const varianceOSY = ss.variance(barData2);
            
            console.log("Mean OSY Count:", meanOSY);
            console.log("Mode OSY Count:", modeOSY);
            console.log("OSY Count Variance:", varianceOSY);

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
                title: 'OSY By Age',
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
