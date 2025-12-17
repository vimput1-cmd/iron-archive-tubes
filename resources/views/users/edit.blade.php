@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow-sm" style="max-width: 600px; border: 2px solid #4B5320;">
        <div class="card-header text-white fw-bold" style="background-color: #8B0000;">Edit Data Personel</div>
        <div class="card-body bg-light">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-3">
                    <label class="fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control border-dark" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control border-dark" value="{{ $user->email }}" required>
                </div>
                
                <hr>
                <p class="small text-muted mb-2">*Kosongkan password jika tidak ingin mengganti.</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control border-dark" placeholder="********">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control border-dark" placeholder="********">
                    </div>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold">UPDATE DATA</button>
            </form>
        </div>
    </div>
</div>
@endsection