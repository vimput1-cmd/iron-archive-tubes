@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow-sm" style="max-width: 600px; border: 2px solid #4B5320;">
        <div class="card-header text-white fw-bold" style="background-color: #4B5320;">Rekrut Personel Baru</div>
        <div class="card-body bg-light">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control border-dark" required placeholder="Nama User">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control border-dark" required placeholder="email@contoh.com">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Password</label>
                        <input type="password" name="password" class="form-control border-dark" required minlength="8">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control border-dark" required minlength="8">
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold">SIMPAN DATA PERSONEL</button>
            </form>
        </div>
    </div>
</div>
@endsection