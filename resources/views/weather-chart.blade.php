<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Line Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
</head>
<body>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Web</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('/') }}" target="_blank">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Weather chart <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Large" value="Right Aligned Button" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </ul>
            </div>
        </nav>
    <style>
        #map { height: 700px; }
        .chart-container { position: relative; height:40vh; width:100vw; } 
        #locationName { text-align: left; margin-bottom: 20px; margin-left: 20px; }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Navbar content here -->
    </nav>

    <div id="locationName"></div> 

    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>

    <div id="map"></div> 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var map = L.map('map', {
            maxZoom: 19,
            minZoom: 4,
            zoomControl: false
        });

        map.setView([57.5359, 25.4243], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        navigator.geolocation.watchPosition(success, error);

        let marker, circle;
        let chart; 
        let minTemp = Infinity;
        let maxTemp = -Infinity;

        function success(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const accuracy = pos.coords.accuracy;

            if (circle) {
                map.removeLayer(circle);
            }
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);
            circle = L.circle([lat, lng], {
                radius: accuracy,
                opacity: 0.5,
                fillOpacity: 0.1,
                color: '#3388ff'
            }).addTo(map);
        }

        function error(err) {
            if (err.code === 1) {
                alert("Please allow geolocation access");
            } else {
                alert("Cannot get location currently");
            }
        }

        function pickLocation(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            axios.get(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => {
                    const locationInfo = response.data;
                    const displayName = locationInfo.display_name;

                    document.getElementById('locationName').innerText = displayName;
                })
                .catch(error => {
                    console.error('Error fetching location information:', error);
                });

            const startDate = new Date('2024-02-08'); 
            const endDate = new Date('2024-02-14'); 
            axios.get(`https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lng}&units=metric&appid=261d4c8305f6693860e215b6d31c4701`)
                .then(response => {
                    const weatherData = response.data.list.filter(data => {
                        const timestamp = new Date(data.dt_txt);
                        return timestamp >= startDate && timestamp < endDate;
                    });
                    const labels = [];
                    const temperatureData = [];
                    const precipitationData = [];
                    const humidityData = [];
                    const windSpeedData = [];
                    minTemp = Infinity;
                    maxTemp = -Infinity;
                    weatherData.forEach(dataPoint => {
                        const temperature = dataPoint.main.temp;
                        if (temperature < minTemp) minTemp = temperature;
                        if (temperature > maxTemp) maxTemp = temperature;
                    });
                    weatherData.forEach(dataPoint => {
                        labels.push(formatDate(dataPoint.dt_txt));
                        temperatureData.push(((dataPoint.main.temp - minTemp) / (maxTemp - minTemp)) * 100); 
                        precipitationData.push(dataPoint.rain ? dataPoint.rain['3h'] || 0 : 0);
                        humidityData.push(dataPoint.main.humidity);
                        windSpeedData.push(dataPoint.wind.speed * 10); 
                    });
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = temperatureData;
                    chart.data.datasets[1].data = precipitationData;
                    chart.data.datasets[2].data = humidityData;
                    chart.data.datasets[3].data = windSpeedData;
                    chart.update();
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
        }

        map.on('click', pickLocation);

        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chart').getContext('2d');
            const weatherData = {
                labels: [],
                datasets: [
                    {
                        label: 'Temperature',
                        data: [],
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Precipitation',
                        data: [],
                        borderColor: 'grey',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Humidity',
                        data: [],
                        borderColor: 'yellow',
                        backgroundColor: 'rgba(220, 220, 0, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Wind Speed',
                        data: [],
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
                    maintainAspectRatio: false, // Set to false to allow width adjustment
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Value' 
                            },
                            min: 0,
                            max: 100,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const dataIndex = context.dataIndex;
                                    const datasetIndex = context.datasetIndex;
                                    const value = context.dataset.data[dataIndex];
                                    let label = '';

                                    switch(datasetIndex) {
                                        case 0:
                                            const tempValue = ((value * (maxTemp - minTemp)) / 100) + minTemp;
                                            label = 'Temperature: ' + tempValue.toFixed(2) + '°C'; 
                                            break;
                                        case 1:
                                            label = 'Precipitation: ' + value + 'mm';
                                            break;
                                        case 2:
                                            label = 'Humidity: ' + value + '%';
                                            break;
                                        case 3:
                                            label = 'Wind Speed: ' + value.toFixed(2) + 'm/s'; 
                                            break;
                                    }

                                    return label;
                                }
                            }
                        }
                    }
                }
            };

            chart = new Chart(ctx, config); 
        });

        function formatDate(dateTimeStr) {
            const dateTime = new Date(dateTimeStr);
            const options = { month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
            return dateTime.toLocaleString('en-US', options);
        }
    </script>
</body>
</html>