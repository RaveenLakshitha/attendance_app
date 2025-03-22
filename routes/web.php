<?php

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
