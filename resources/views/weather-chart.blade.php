<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Line Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

    </nav>

    <div class="container">
        <h1>Weather Line Chart</h1>
        <canvas id="weatherLineChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('weatherLineChart').getContext('2d');
        const labels = {!! json_encode($data->data[0]['labels']) !!};
        const temperatureReadings = {!! json_encode($data->data[0]['readings']) !!};
        const temperaturesKelvin = {!! json_encode($data->data[0]['temperatures']) !!};
        const windSpeedReadings = {!! json_encode($data->data[0]['wind_Speed']) !!};
        const precipitationReadings = {!! json_encode($data->data[0]['precipitation']) !!};
        const humidityReadings = {!! json_encode($data->data[0]['humidity']) !!};

        function kelvinToCelsius(kelvin) {
            return kelvin - 273.15;
        }

        const temperatures = temperaturesKelvin.map(kelvinToCelsius);

        function windSpeedToPercentage(windSpeed) {
            return (windSpeed / 10) * 100; 
        }

        const windSpeedPercentages = windSpeedReadings.map(windSpeedToPercentage);

        const humidityPercentages = humidityReadings.map(humidity => humidity);

        const weatherData = {
            labels: labels,
            datasets: [
                {
                    label: 'Temperature (C*)',
                    data: temperatureReadings,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                    fill: true
                },
                {
                    label: 'precipitation(mm)',
                    data: precipitationReadings,
                    borderColor: 'grey',
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    fill: true
                },
                {
                    label: 'humidity(%)',
                    data: humidityPercentages,
                    borderColor: 'yellow',
                    backgroundColor: 'rgba(220, 220, 0, 0.2)',
                    fill: true
                },
                {
                    label: 'Wind Speed (m/s)',
                    data: windSpeedPercentages,
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 255, 0, 0.2)',
                    fill: true
                }
            ]
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
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'nearest',
                        intersect: false,
                        callbacks: {
                            title: function (context) {
                                return 'Weather Data';
                            },
                            label: function (context) {
                                const dataIndex = context.dataIndex;
                                const temperature = temperatures[dataIndex];
                                const windSpeed = windSpeedReadings[dataIndex];
                                const precipitation = precipitationReadings[dataIndex];
                                const humidity = humidityReadings[dataIndex];
                                return `Temperature: ${temperature.toFixed(2)}°C,
                                         Wind Speed: ${windSpeed.toFixed(2)} m/s,
                                         Precipitation: ${precipitation.toFixed(2)}mm,
                                         humidity: ${humidity.toFixed(2)}%`;
                            }
                        }
                    }
                }
            }
        };

        const chart = new Chart(ctx, config);

        document.getElementById('weatherLineChart').addEventListener('mousemove', onHover);
        document.getElementById('weatherLineChart').addEventListener('mouseleave', onLeave);

        function onHover(event) {
            const activePoints = chart.getElementsAtEventForMode(event, 'nearest', { intersect: false });

            if (activePoints.length > 0) {
                const dataIndex = activePoints[0].index;

                chart.tooltip.setActiveElements([{ datasetIndex: 0, index: dataIndex }]);
                chart.tooltip.update();
                chart.draw();
            }
        }

        function onLeave() {
            chart.tooltip.setActiveElements([]);
            chart.tooltip.update();
            chart.draw();
        }
    });
</script>
</body>
</html>
