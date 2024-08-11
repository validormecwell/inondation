<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Réservations</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 600px;
            max-height: 400px;
            margin: auto;

        }
        .chart-container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <h1>Statistiques des Réservations</h1>

    <!-- Statistiques Mensuelles -->
    <div class="chart-container">
        <h2>Statistiques des Réservations par Mois</h2>
        <canvas id="reservationsMensuellesChart"></canvas>
    </div>

    <!-- Statistiques Annuelles -->
    <div class="chart-container">
        <h2>Statistiques des Réservations par Année</h2>
        <canvas id="reservationsAnnuellesChart"></canvas>
    </div>

    <script>
        // Statistiques mensuelles
        var ctxMois = document.getElementById('reservationsMensuellesChart').getContext('2d');
        var reservationsMensuellesChart = new Chart(ctxMois, {
            type: 'bar',
            data: {
                labels: @json($labelsMois),
                datasets: [{
                    label: 'Nombre de Clients',
                    data: @json($dataMois),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                maintainAspectRatio: false
            }
        });

        // Statistiques annuelles
        var ctxAn = document.getElementById('reservationsAnnuellesChart').getContext('2d');
        var reservationsAnnuellesChart = new Chart(ctxAn, {
            type: 'bar',
            data: {
                labels: @json($labelsAn),
                datasets: [{
                    label: 'Nombre de Clients',
                    data: @json($dataAn),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
