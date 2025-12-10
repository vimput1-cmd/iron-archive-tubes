@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🪖 Database Iron Archive</h2>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">+ Tambah Data Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($vehicles as $vehicle)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($vehicle->image)
                    <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-secondary text-white d-flex justify-content-center align-items-center" style="height: 200px;">No Image</div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $vehicle->name }}</h5>
                    <span class="badge bg-dark">{{ $vehicle->nation->name }}</span>
                    <span class="badge bg-info text-dark">{{ $vehicle->category->name }}</span>
                    <p class="card-text mt-2 text-truncate">{{ $vehicle->description }}</p>
                    
                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-outline-primary w-100 mb-2">Lihat Detail & 3D</a>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-warning w-50">Edit</a>
                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="w-50" onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada data kendaraan. Silakan klik tombol "+ Tambah Data Baru".
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection