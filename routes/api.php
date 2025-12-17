<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Vehicle; // Pastikan ini ada!

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- JALUR KOMUNIKASI API KITA ---

// 1. Ambil Semua Data
Route::get('/vehicles', function () {
    return response()->json([
        'status' => 'success',
        'data' => Vehicle::with(['nation', 'category'])->get()
    ]);
});

// 2. Ambil Detail Satu Data
Route::get('/vehicles/{id}', function ($id) {
    $vehicle = Vehicle::with(['nation', 'category'])->find($id);
    if ($vehicle) {
        return response()->json(['status' => 'success', 'data' => $vehicle]);
    }
    return response()->json(['status' => 'error', 'message' => 'Not Found'], 404);
});