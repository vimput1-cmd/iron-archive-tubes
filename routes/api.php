<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Vehicle; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- KODINGAN KITA MULAI SINI ---

Route::get('/vehicles', function () {
    return response()->json([
        'status' => 'success',
        'data' => Vehicle::all()
    ]);
});

Route::get('/vehicles/{id}', function ($id) {
    $vehicle = Vehicle::find($id);
    if ($vehicle) {
        return response()->json(['status' => 'success', 'data' => $vehicle]);
    }
    return response()->json(['status' => 'error', 'message' => 'Not Found'], 404);
});