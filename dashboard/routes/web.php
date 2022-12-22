<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotifyMailController;
use App\Http\Controllers\UplinkController;
use App\Notifications\DeviceStatusNotification;
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
    return Inertia::render('StyleView');
})->name('style');


require __DIR__ . '/auth.php';
// group route dashboard device location uplink as auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('device', DeviceController::class);
    Route::resource('location', LocationController::class);
    Route::resource('uplink', UplinkController::class);
    Route::get('/profile', function () {
        return Inertia::render('ProfileView');
    })->name('profile');
});

// send uplink to chirpstack if visit /uplink/test
Route::get('/uplink/test', function () {
    return Inertia::render('UplinkTest');
});
// notification test
Route::get('/notify', function () {
    $device = \App\Models\Device::first();
    $user = \App\Models\User::where('email_subscribe', true)->first();

    $user->notify(new DeviceStatusNotification($device));

    return 'Notification sent!';
})->name('notify.test');
// mail test
Route::get('mail', function () {
    return Inertia::render('MailTest');
})->name('mail.test');
Route::post('mail', [NotifyMailController::class, 'store'])->name('mail.store');
