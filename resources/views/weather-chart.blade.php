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
        <a class="navbar-brand" href="#">Web</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('/') }}" target="_blank">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="weather-chart">Weather chart <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Blog</a>
                </li>
            </ul>
        </div>
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
    const labels = {!! json_encode($data['labels']) !!};
    const temperaturesKelvin = {!! json_encode($data['temperatures']) !!};
    const precipitation = {!! json_encode($data['precipitation']) !!};
    const temperaturesCelsius = temperaturesKelvin.map(tempK => tempK - 273.15);
    const windSpeed = {!! json_encode($data['wind_Speed']) !!};
    const humidity = {!! json_encode($data['humidity']) !!};

    const weatherData = {
        labels: labels,
        datasets: [{
            label: 'Temperature (°C)',
            data: temperaturesCelsius,
            borderColor: 'blue',
            backgroundColor: 'rgba(0, 0, 255, 0.2)',
            fill: true
        }, {
            label: 'Precipitation (mm)',
            data: precipitation,
            borderColor: 'green',
            backgroundColor: 'rgba(0, 255, 0, 0.2)',
            fill: true
        }, {
            label: 'Wind Speed (m/s)',
            data: windSpeed,
            borderColor: 'purple',
            backgroundColor: 'rgba(128, 0, 128, 0.2)',
            fill: true
        }, {
            label: 'Humidity (%)',
            data: humidity,
            borderColor: 'yellow',
            backgroundColor: 'rgba(255, 200, 0, 0.2)',
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
                        text: 'Temperature (°C) / Precipitation (mm)/ Wind Speed (m/s)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
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