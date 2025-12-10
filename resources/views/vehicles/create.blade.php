@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Add New Vehicle</div>
        <div class="card-body">
            <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="row">
                    <div class="col"><label>Nation</label>
                        <select name="nation_id" class="form-select">
                            @foreach($nations as $n) <option value="{{ $n->id }}">{{ $n->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col"><label>Category</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col"><label>Year</label><input type="number" name="production_year" class="form-control" required></div>
                    <div class="col"><label>Quantity</label><input type="number" name="quantity" class="form-control" required></div>
                </div>
                <div class="mt-3"><label>Battles</label><input type="text" name="battles" class="form-control" required></div>
                <div class="mt-3"><label>Description</label><textarea name="description" class="form-control" rows="3" required></textarea></div>
                <div class="mt-3"><label>Image (JPG/PNG)</label><input type="file" name="image" class="form-control"></div>
                <div class="mt-3"><label>3D Model (.glb) - Optional</label><input type="file" name="model_file" class="form-control"></div>
                <button class="btn btn-primary mt-4 w-100">Save Data</button>
            </form>
        </div>
    </div>
</div>
@endsection