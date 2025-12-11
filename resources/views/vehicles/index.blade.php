@extends('layouts.app') 

@section('content')
<div class="container py-5">
    
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5" style="color: #3F3B2E; font-family: 'Courier New', monospace;">
            🪖 IRON ARCHIVE
        </h1>
        <p class="text-muted">Top Secret Database of WW2 Vehicles</p>
    </div>

    <div class="card mb-5 p-4 shadow-sm" style="background-color: #DAD3C1; border: 2px solid #3F3B2E;">
        <form action="/vehicles" method="GET">
            <div class="row g-2 align-items-end">
                
                <div class="col-md-4">
                    <label class="fw-bold mb-1 small" style="color: #3F3B2E;">Cari Nama:</label>
                    <input type="text" name="search" class="form-control border-2 border-dark form-control-sm" 
                           placeholder="Misal: Tiger..." 
                           value="{{ request('search') }}"
                           style="background-color: #FDFBF7;">
                </div>

                <div class="col-md-2">
                    <label class="fw-bold mb-1 small" style="color: #3F3B2E;">Negara:</label>
                    <select name="nation" class="form-select border-2 border-dark form-select-sm" style="background-color: #FDFBF7;">
                        <option value="">Semua Negara</option>
                        @foreach($nations as $nat)
                            <option value="{{ $nat->id }}" {{ request('nation') == $nat->id ? 'selected' : '' }}>
                                {{ $nat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="fw-bold mb-1 small" style="color: #3F3B2E;">Tahun:</label>
                    <select name="year" class="form-select border-2 border-dark form-select-sm" style="background-color: #FDFBF7;">
                        <option value="">Semua Era</option>
                        @foreach(range(1939, 1945) as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="fw-bold mb-1 small" style="color: #3F3B2E;">Jenis Unit:</label>
                    <select name="category" class="form-select border-2 border-dark form-select-sm" style="background-color: #FDFBF7;">
                        <option value="">Semua Jenis</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn w-100 fw-bold text-white shadow-sm btn-sm" 
                            style="background-color: #8B0000; border: 2px solid #3F3B2E;">
                        SEARCH 🎯
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color: #4B5320;">Deployments List:</h4>
        <a href="/vehicles/create" class="btn text-white fw-bold" style="background-color: #4B5320;">
            + TAMBAH UNIT BARU
        </a>
    </div>

    <div class="row">
        @forelse($vehicles as $vehicle)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm vehicle-card">
                <div style="height: 200px; overflow: hidden; background: #ccc;">
                    @if($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top" alt="{{ $vehicle->name }}" style="object-fit: cover; height: 100%; width: 100%;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">No Image</div>
                    @endif
                </div>
                
                <div class="card-body d-flex flex-column" style="background-color: #F4F1EA;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold mb-0" style="font-family: 'Courier New', monospace;">
                            {{ $vehicle->name }}
                        </h5>
                        <span class="badge bg-dark">{{ $vehicle->production_year }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="badge" style="background-color: #3F3B2E;">{{ $vehicle->nation->name ?? 'Unknown' }}</span>
                        <span class="badge" style="background-color: #4B5320;">{{ $vehicle->category->name ?? 'Unknown' }}</span>
                    </div>
                    
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($vehicle->description, 80) }}
                    </p>

                    <div class="d-grid gap-2 mt-3">
                        <a href="/vehicles/{{ $vehicle->id }}" class="btn btn-outline-dark btn-sm fw-bold">
                            👁️ LIHAT DATA & 3D
                        </a>
                        <div class="btn-group">
                            <a href="/vehicles/{{ $vehicle->id }}/edit" class="btn btn-warning btn-sm" style="border: 1px solid #333;">EDIT</a>
                            <form action="/vehicles/{{ $vehicle->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau menghapus arsip ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100" style="border: 1px solid #333;">HAPUS</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="text-muted">Arsip Tidak Ditemukan, Komandan! 🚫</h3>
            <p>Coba ganti filter pencarian kamu.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection