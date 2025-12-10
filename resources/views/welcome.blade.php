@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="fw-bold mb-0">🪖 Iron Archive</h1>
                    <p class="mb-0">Database Kendaraan Perang Dunia II</p>
                </div>
                <div class="card-body text-center p-5">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Tiger_I_at_the_Tank_Museum_Bovington.jpg/640px-Tiger_I_at_the_Tank_Museum_Bovington.jpg" 
                         alt="WW2 Tank" class="img-fluid rounded mb-4 shadow" style="max-height: 300px; object-fit: cover;">
                    
                    <h3 class="mb-3">Selamat Datang, Komandan!</h3>
                    <p class="lead text-muted mb-4">
                        Sistem arsip digital untuk mencatat, mengelola, dan memvisualisasikan kendaraan tempur bersejarah.
                    </p>
                    
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        @auth
                            <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg px-4 gap-3">
                                Buka Database Kendaraan
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 gap-3">
                                Login Admin
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">
                                Daftar Akun
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="card-footer text-muted text-center py-3">
                    &copy; {{ date('Y') }} Iron Archive Project
                </div>
            </div>
        </div>
    </div>
</div>
@endsection