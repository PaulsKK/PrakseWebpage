<?php
// routes/web.php
use App\Http\Controllers\YourController1;
use App\Http\Controllers\WeatherController;


Route::get('/', [YourController1::class, 'index']);
Route::get('/show-data', [YourController1::class, 'showData']);
Route::get('/pievienot', [YourController1::class, 'showPievienotPage']);
Route::post('/process-pievienot', [YourController1::class, 'processPievienot'])->name('process.pievienot');
Route::post('/authors', [YourController1::class, 'store']);
Route::get('/delete/{name}', [YourController1::class, 'remove']);
Route::get('/edit/{name}', [YourController1::class, 'edit']); 
Route::put('/process-edit/{name}', [YourController1::class, 'processEdit'])->name('process.edit');
Route::get('/weather-chart', function () {
    return view('weather-chart');
})->name('weather-chart');
Route::get('/', [YourController1::class,'index'])->name('/');
Route::get('/get-weather-data', [WeatherController::class, 'getWeatherData']);
Route::post('/get-weather-data', [WeatherController::class, 'getWeatherData']);
Route::get('/weather-chart', [WeatherController::class, 'getWeatherData'])->name('weather-chart');
