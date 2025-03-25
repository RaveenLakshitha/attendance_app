<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

Auth::routes();

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users/{id}/clear-device-id', [UserController::class, 'clearDeviceId'])->name('users.clearDeviceId');

Auth::routes();

Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');

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

Route::post('/users/{user}/upload-profile-picture', [UserController::class, 'uploadProfilePicture'])
    ->name('users.uploadProfilePicture');