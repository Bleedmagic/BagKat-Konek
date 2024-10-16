<?php

include 'header_admin.php';
include 'mysql_dashboard.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>

<body>
    <div class="main-content">
        <h1 style="color: #17412D;">DASHBOARD</h1>
        <div class="dashboard">
            <div class="card pending-requests">
                <h3>Pending Requests</h3>
                <div class="numbers">4</div>
                <button>View</button>
            </div>
            <div class="card verify-accounts">
                <h3>Verify Accounts</h3>
                <div class="numbers"><?= $pending_count ?></div>
                <a href="admin_user_approval.php" class="view-button">View</a>
            </div>
            <div class="card highest-education">
                <h3>HIGHEST EDUCATIONAL ATTAINMENT</h3>
                <canvas id="educationChart" class="bar-chart"></canvas>
            </div>
            <div class="card age-of-residents">
                <h3>AGE OF RESIDENTS</h3>
                <canvas id="ageChart" class="pie-chart"></canvas>
            </div>
            <div class="card registered-residents">
                <h3>NUMBER OF REGISTERED RESIDENTS OVER THE YEARS</h3>
                <canvas id="yearsChart" class="line-chart"></canvas>
            </div>
            <div class="card male-female-residents">
                <h3>MALE AND FEMALE RESIDENTS</h3>
                <canvas id="chartGender" class="bar-chart"></canvas>
            </div>
            <div class="card total-residents">
                <h3>TOTAL RESIDENTS</h3>
                <div class="number"><?= $total_residents; ?></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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
                        'rgba(54, 180, 215, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
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
                        display: false
                    }
                }
            }
        });

        const ctxYears = document.getElementById('yearsChart').getContext('2d');
        const yearsChart = new Chart(ctxYears, {
            type: 'line',
            data: {
                labels: <?php echo '[' . implode(', ', $years_reg) . ']' ?>,
                datasets: [{
                    data: <?php echo '[' . implode(', ', $total_reg) . ']' ?>,
                    borderColor: '#0099cc',
                    fill: false,
                }, ],
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
                            color: '#1A4D2E',
                        },
                    },
                    y: {
                        ticks: {
                            color: '#1A4D2E',
                        },
                    },
                },
            },
        });

        const ctxAge = document.getElementById('ageChart').getContext('2d');
        const ageChart = new Chart(ctxAge, {
            type: 'pie',
            data: {
                labels: ['0-14', '15-24', '25-54', '55+'],
                datasets: [{
                    data: [<?= $ages_0_14 ?>, <?= $ages_15_24 ?>, <?= $ages_25_54 ?>, <?= $ages_55_p ?>],
                    backgroundColor: ['#ffcc00', '#ff6600', '#cc0000', '#339933'],
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffff',
                        },
                    },
                },
            },
        });

        const ctxEducation = document.getElementById('educationChart').getContext('2d');
        const educationChart = new Chart(ctxEducation, {
            type: 'bar',
            data: {
                labels: ['Primary', 'Secondary', 'Tertiary'],
                datasets: [{
                    data: [<?php echo $elem ?? 0; ?>, <?php echo $high ?? 0; ?>, <?php echo $coll ?? 0; ?>],
                    backgroundColor: ['#ffcc00', '#0099cc', '#339933'],
                }, ],
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
                            color: '#1A4D2E',
                        },
                    },
                    y: {
                        ticks: {
                            color: '#1A4D2E',
                        },
                    },
                },
            },
        });
    </script>
</body>

</html>
