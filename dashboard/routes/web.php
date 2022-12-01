<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UplinkController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/form', function () {
    return Inertia::render('FormsView');
});

Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

require __DIR__ . '/auth.php';

// send uplink to chirpstack if visit /uplink/test
Route::get('/uplink/test', function () {
    return Inertia::render('UplinkTest');
});

// uplink chirpstack route
Route::post('uplink/chirpstack', [UplinkController::class, 'chirpstack'])->name('uplink.chirpstack');

Route::resource('device', DeviceController::class);
Route::resource('location', LocationController::class);
Route::resource('uplink', UplinkController::class);
