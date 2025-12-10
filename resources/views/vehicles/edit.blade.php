@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <strong>Edit Data: {{ $vehicle->name }}</strong>
                </div>

                <div class="card-body">
                    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label>Nama Kendaraan</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $vehicle->name) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Negara Pembuat</label>
                                <select name="nation_id" class="form-select" required>
                                    @foreach ($nations as $nation)
                                        <option value="{{ $nation->id }}" {{ $vehicle->nation_id == $nation->id ? 'selected' : '' }}>
                                            {{ $nation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $vehicle->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tahun Produksi</label>
                                <input type="number" name="production_year" class="form-control" value="{{ $vehicle->production_year }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jumlah Produksi</label>
                                <input type="number" name="quantity" class="form-control" value="{{ $vehicle->quantity }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pertempuran (Battles)</label>
                            <input type="text" name="battles" class="form-control" value="{{ $vehicle->battles }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi Sejarah</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $vehicle->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Ganti Foto (Kosongkan jika tidak ingin mengganti)</label>
                            <input type="file" name="image" class="form-control mb-2">
                            @if($vehicle->image)
                                <small class="text-muted">Foto saat ini:</small>
                                <img src="{{ asset('storage/' . $vehicle->image) }}" width="80" class="d-block rounded">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label>Ganti File 3D (.glb) (Kosongkan jika tidak ingin mengganti)</label>
                            <input type="file" name="model_file" class="form-control">
                            @if($vehicle->model_file)
                                <small class="text-success">✔ File 3D sudah ada</small>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Update Data</button>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary w-25">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection