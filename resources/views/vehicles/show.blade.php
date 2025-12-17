@extends('layouts.app')

@section('content')
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js"></script>

<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            @if($vehicle->model_file)
                <div class="card mb-3 shadow border-0">
                    <div class="card-header text-white fw-bold" style="background-color: #4B5320;">
                        3D Preview Area
                    </div>
                    <model-viewer 
                        src="{{ asset('storage/' . $vehicle->model_file) }}" 
                        alt="{{ $vehicle->name }}" 
                        auto-rotate 
                        camera-controls 
                        shadow-intensity="1"
                        style="width: 100%; height: 500px; background-color: #E5E5E5;">
                    </model-viewer>
                </div>

                {{-- 🔥 TOMBOL DOWNLOAD 3D 🔥 --}}
                <div class="d-grid gap-2">
                    <a href="{{ route('vehicles.download', $vehicle->id) }}" class="btn btn-success fw-bold py-2 shadow-sm">
                        📥 DOWNLOAD 3D ASSET (.GLB)
                    </a>
                </div>
            @else
                <div class="alert alert-secondary text-center py-5">
                    <h4>⚠️ No 3D Model Available</h4>
                    <p>Cetak biru untuk unit ini belum tersedia di arsip.</p>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="background-color: #F4F1EA;">
                @if($vehicle->image) 
                    <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top" style="max-height: 250px; object-fit: cover;"> 
                @endif
                
                <div class="card-body">
                    <h2 class="fw-bold" style="font-family: 'Courier New', monospace; color: #3F3B2E;">
                        {{ $vehicle->name }}
                    </h2>
                    <hr>
                    
                    <p class="mb-1"><strong>🌍 Nation:</strong> {{ $vehicle->nation->name }}</p>
                    <p class="mb-1"><strong>🏭 Year:</strong> {{ $vehicle->production_year }}</p>
                    <p class="mb-1"><strong>⚔️ Battles:</strong> {{ $vehicle->battles }}</p>
                    <p class="mb-1"><strong>🏷️ Type:</strong> {{ $vehicle->category->name }}</p>
                    
                    <hr>
                    <p class="text-muted">{{ $vehicle->description }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary w-100 fw-bold">
                            🔙 KEMBALI KE MARKAS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection