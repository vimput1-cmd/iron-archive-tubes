@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #4B5320; font-family: 'Courier New', monospace;">
            👮‍♂️ MANAJEMEN PERSONEL
        </h2>
        
        <a href="{{ route('users.create') }}" class="btn text-white fw-bold" style="background-color: #4B5320;">
            + REKRUT BARU
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm" style="border: 2px solid #3F3B2E;">
        <div class="card-header text-white fw-bold" style="background-color: #3F3B2E;">
            Daftar Pasukan Iron Archive
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead style="background-color: #DAD3C1;">
                        <tr>
                            <th class="ps-3">Nama Personel</th>
                            <th>Email Address</th>
                            <th>Pangkat (Role)</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-3 align-middle fw-bold">{{ $user->name }}</td>
                            <td class="align-middle text-muted">{{ $user->email }}</td>
                            
                            <td class="align-middle">
                                @if(Auth::id() != $user->id)
                                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="form-select form-select-sm border-dark" 
                                                style="width: 140px; background-color: #FDFBF7;"
                                                onchange="this.form.submit()">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>👤 Prajurit</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Komandan</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge bg-danger">KOMANDAN (ANDA)</span>
                                @endif
                            </td>

                            <td class="text-end pe-3 align-middle">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit Profil">✏️</a>
                                
                                @if(Auth::id() != $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin memecat personel ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus User">🗑️</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3 text-muted small">
        *Tips: Ubah dropdown Pangkat untuk langsung mengganti role user.
    </div>
</div>
@endsection