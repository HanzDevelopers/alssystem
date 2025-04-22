 
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Mangima', 'Proper Calanawan', 'Upper Calanawan', 'Lower Calanawan', 'Centro', 'Lower Pol-Oton', 'Upper Pol-Oton', 'Mulberry', 'Kihare', 'Tumampong', 'Upper Sosohon', 'Lower Sosohon', 'st. Joseph'],
        datasets: [{
          label: 'Brg. Tankulan OSY',
          data: [5, 4, 5, 10, 20, 20, 6, 5, 25, 3, 10, 5, 2],
          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FFCD56', '#36A2EB', '#FF6384', '#FF9F40', '#4BC0C0', '#9966FF','#9945FF']
        }]
        
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    var ctx2 = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Mangima', 'Proper Calanawan', 'Upper Calanawan', 'Lower Calanawan', 'Centro', 'Lower Pol-Oton', 'Upper Pol-Oton', 'Mulberry', 'Kihare', 'Tumampong', 'Upper Sosohon', 'Lower Sosohon', 'st. Joseph'],
        datasets: [{
          label: 'Population',
          data: [230, 168, 130, 111, 578, 126, 169, 354, 211, 110, 200, 169, 259],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx3 = document.getElementById('barChart2').getContext('2d');
    var barChart2 = new Chart(ctx3, {
      type: 'bar',
      data: {
        labels: ['2021', '2022', '2023', '2024'],
        datasets: [{
          label: '15-20',
          data: [4.3, 2.5, 3.5, 4.5],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }, {
          label: '21-25',
          data: [3, 4, 3, 3],
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }, {
          label: '26-30',
          data: [1, 1.5, 2, 2.5],
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });