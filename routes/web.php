<?php
// routes/web.php
use App\Http\Controllers\YourController1;

Route::get('/', [YourController1::class, 'index']);
Route::get('/show-data', [YourController1::class, 'showData']);
Route::get('/pievienot', [YourController1::class, 'showPievienotPage']);
Route::post('/process-pievienot', [YourController1::class, 'processPievienot'])->name('process.pievienot');
Route::post('/authors', [YourController1::class, 'store']);
Route::get('/delete/{name}', [YourController1::class, 'remove']);
Route::get('/edit/{name}', [YourController1::class, 'edit']); // Change this to a GET request
Route::put('/process-edit/{name}', [YourController1::class, 'processEdit'])->name('process.edit');
