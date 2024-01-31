<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            width: 400px;
            height: 200px;
        }
    </style>
</head>
<body>
    <h1>Weather Line Chart</h1>
    <canvas id="weatherLineChart"></canvas>
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const ctx = document.getElementById('weatherLineChart').getContext('2d');
            const apiKey = '261d4c8305f6693860e215b6d31c4701';
            const city = 'Valmiera';
            const apiUrl = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}`;

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                const labels = data.list.map(item => new Date(item.dt * 1000).toLocaleDateString());
                const temperatures = data.list.map(item => item.main.temp - 273.15); 

                const weatherData = {
                    labels: labels,
                    datasets: [{
                        label: 'Temperature (°C)',
                        data: temperatures,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        fill: true
                    }]
                };

                const config = {
                    type: 'line',
                    data: weatherData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            x: { 
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: { 
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Temperature (°C)'
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, config);

            } catch (error) {
                console.error('Error fetching weather data:', error);
            }
        });
    </script>
</body>
</html>