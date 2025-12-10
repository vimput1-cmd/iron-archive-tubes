@extends('layouts.app')
@section('content')
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @if($vehicle->model_file)
                <div class="card mb-3 shadow">
                    <div class="card-header bg-dark text-white">3D Preview</div>
                    <model-viewer src="{{ asset('storage/' . $vehicle->model_file) }}" alt="{{ $vehicle->name }}" auto-rotate camera-controls style="width: 100%; height: 500px; background-color: #eee;"></model-viewer>
                </div>
            @else
                <div class="alert alert-secondary">No 3D Model available.</div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                @if($vehicle->image) <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top"> @endif
                <div class="card-body">
                    <h3>{{ $vehicle->name }}</h3>
                    <p><strong>Nation:</strong> {{ $vehicle->nation->name }}</p>
                    <p><strong>Year:</strong> {{ $vehicle->production_year }}</p>
                    <p><strong>Battles:</strong> {{ $vehicle->battles }}</p>
                    <p>{{ $vehicle->description }}</p>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary w-100">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection