<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahan buat fitur download
use App\Models\Vehicle; // Tambahan buat baca model

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('vehicles.index'); 
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 🔥 RUTE KHUSUS YANG BUTUH LOGIN 🔥
Route::middleware(['auth'])->group(function () {
    
    // 1. Route Kendaraan (Resource)
    Route::resource('vehicles', VehicleController::class);
    
    // 2. Route DOWNLOAD 3D (Logic langsung di sini biar sat-set!)
   // Ganti Route Download yang lama dengan yang ini:
Route::get('/vehicles/{id}/download', function ($id) {
    $vehicle = App\Models\Vehicle::findOrFail($id);

    // 1. Kita cari tau path aslinya di mana (Debug)
    // Asumsi file kamu tersimpan di folder: storage/app/public/vehicle-models/...
    $filePath = storage_path('app/public/' . $vehicle->model_file);

    // 2. Cek apakah file fisik beneran ada di komputer?
    if (!file_exists($filePath)) {
        // Kalau error, dia bakal kasih tau lokasinya di mana
        return "ERROR: File tidak ditemukan!<br>Sistem mencari di: " . $filePath . "<br><br>Coba cek folder storage kamu, filenya ada nggak di situ?";
    }

    // 3. Kalau ada, paksa download
    return response()->download($filePath, $vehicle->name . '.glb');
    
})->name('vehicles.download');

    // 3. Route Kategori
    Route::resource('categories', CategoryController::class);

    // 4. Route Negara
    Route::resource('nations', NationController::class);

    // 5. Route User (Admin Only ideally, tapi buat sekarang resource aja)
    Route::resource('users', UserController::class);
});

