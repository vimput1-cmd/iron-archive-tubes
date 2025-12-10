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

    public function index()
    {
        $vehicles = Vehicle::with(['nation', 'category'])->get();
        return view('vehicles.index', compact('vehicles'));
    }

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