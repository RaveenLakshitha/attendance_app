<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

Auth::routes();

Route::post('/update-office-location', [SettingsController::class, 'updateOfficeLocation'])->name('update.office.location');  

Route::get('/attendancePage', [AttendanceController::class, 'index']);

Route::get('/loginUI', function () {
    return view('loginUI');
})->name('loginUI');

Route::get('/registerUI', function () {
    return view('registerUI');
})->name('registerUI');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');