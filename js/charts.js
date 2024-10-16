/**
 *  Called in admin_dashboard.php, too long so it is put in separate file
 */


       // MALE AND FEMALE BAR
var xlabels = ['Male', 'Female'];
var yvalues = [<?= $male_count; ?>, <?= $female_count; ?>];
Chart.defaults.color = "#ffff";
new Chart('chartGender', {
    type: 'bar',
    data: {
        labels: xlabels,
        datasets: [{
            data: yvalues,
            backgroundColor: [
                'rgba(54, 180, 215, 0.5)', // Blue for Male
                'rgba(255, 99, 132, 0.5)'  // Red for Female
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false // Hide the legend
            }
        }
    }
});


        // REG YEARS CHART

        const ctxYears = document.getElementById('yearsChart').getContext('2d');
        const yearsChart = new Chart(ctxYears, {
            type: 'line',
            data: {
                labels: <?php echo '[' . implode(', ', $years_reg) . ']'?>,
                datasets: [
                    {
                        data: <?php echo '[' . implode(', ', $total_reg) . ']'?>,
                        borderColor: '#0099cc',
                        fill: false,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#1A4D2E', // X-axis labels color
                        },
                    },
                    y: {
                        ticks: {
                            color: '#1A4D2E', // Y-axis labels color
                        },
                    },
                },
            },
        });


        //AGE CHART
        const ctxAge = document.getElementById('ageChart').getContext('2d');
        const ageChart = new Chart(ctxAge, {
            type: 'pie',
            data: {
                labels: ['0-14', '15-24', '25-54', '55+'],
                datasets: [
                    {
                        data: [<?= $ages_0_14 ?>, <?= $ages_15_24 ?>, <?= $ages_25_54 ?>, <?= $ages_55_p ?>],
                        backgroundColor: ['#ffcc00', '#ff6600', '#cc0000', '#339933'],
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffff', // Legend font color
                        },
                    },
                },
            },
        });


        // EDUCATIONAL ATTAINMENT
        const ctxEducation = document.getElementById('educationChart').getContext('2d');
        const educationChart = new Chart(ctxEducation, {
            type: 'bar',
            data: {
                labels: ['Primary', 'Secondary', 'Tertiary'],
                datasets: [
                    {
                        data: [<?php echo $elem ?? 0; ?>, <?php echo $high ?? 0; ?>, <?php echo $coll ?? 0; ?>],
                        backgroundColor: ['#ffcc00', '#0099cc', '#339933'],
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#1A4D2E', // X-axis labels color
                        },
                    },
                    y: {
                        ticks: {
                            color: '#1A4D2E', // Y-axis labels color
                        },
                    },
                },
            },
        });
