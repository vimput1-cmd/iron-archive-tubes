<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Nation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // --- BAGIAN INI YANG SUDAH DIUPDATE LENGKAP (Search + Tahun + Kategori + Negara) ---
    public function index(Request $request)
    {
        // 1. Mulai Query (Pakai 'with' biar relasi Negara & Kategori tetap kebawa)
        $query = Vehicle::with(['nation', 'category']);

        // A. Logika Search (Cari Nama Tank)
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // B. 🔥 UPDATE BARU: Logika Filter NEGARA 🔥
        if ($request->filled('nation')) {
            $query->where('nation_id', $request->nation);
        }

        // C. Logika Filter Kategori (Jenis Unit)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // D. Logika Filter Tahun (Sesuai kolom 'production_year')
        if ($request->filled('year')) {
            $query->where('production_year', $request->year);
        }

        // 2. Ambil data & Urutkan dari tahun terlama
        $vehicles = $query->orderBy('production_year', 'asc')->get();

        // 3. Ambil Data Pendukung buat Dropdown Filter
        $categories = Category::all();
        $nations = Nation::all(); // 🔥 KITA BUTUH INI SEKARANG

        // Kirim semua variabel ($vehicles, $categories, $nations) ke view
        return view('vehicles.index', compact('vehicles', 'categories', 'nations'));
    }
    // ------------------------------------------------

    public function create()
    {
        $nations = Nation::all();
        $categories = Category::all();
        return view('vehicles.create', compact('nations', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'nation_id' => 'required',
            'category_id' => 'required',
            'production_year' => 'required|numeric',
            'quantity' => 'required|numeric',
            'battles' => 'required',
            'description' => 'required',
            'image' => 'image|file|max:5000',
            'model_file' => 'nullable|file',
        ]);

        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('vehicle-images', 'public');
        }
        if ($request->file('model_file')) {
            $data['model_file'] = $request->file('model_file')->store('vehicle-models', 'public');
        }

        Vehicle::create($data);
        return redirect()->route('vehicles.index')->with('success', 'Data saved!');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $nations = Nation::all();
        $categories = Category::all();
        return view('vehicles.edit', compact('vehicle', 'nations', 'categories'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'name' => 'required',
            'nation_id' => 'required',
            'category_id' => 'required',
            'production_year' => 'required|numeric',
            'quantity' => 'required|numeric',
            'battles' => 'required',
            'description' => 'required',
        ]);

        if ($request->file('image')) {
            if($vehicle->image) Storage::disk('public')->delete($vehicle->image);
            $data['image'] = $request->file('image')->store('vehicle-images', 'public');
        }
        if ($request->file('model_file')) {
            if($vehicle->model_file) Storage::disk('public')->delete($vehicle->model_file);
            $data['model_file'] = $request->file('model_file')->store('vehicle-models', 'public');
        }

        $vehicle->update($data);
        return redirect()->route('vehicles.index')->with('success', 'Data updated!');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->image) Storage::disk('public')->delete($vehicle->image);
        if ($vehicle->model_file) Storage::disk('public')->delete($vehicle->model_file);
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Data deleted!');
    }
}