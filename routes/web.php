<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::get('/', function () { return view('welcome'); });
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route Utama
Route::resource('vehicles', VehicleController::class)->middleware('auth');