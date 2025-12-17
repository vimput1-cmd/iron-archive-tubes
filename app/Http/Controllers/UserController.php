<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Fungsi Cek Admin (Sekarang pakai Role, bukan Email lagi)
    private function checkAdmin() {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'AKSES DITOLAK! Area ini hanya untuk Komandan (Admin).');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        
        // Ambil semua user
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->checkAdmin();
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user', // Bisa pilih role pas bikin baru
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Personel baru berhasil direkrut!');
    }

    public function edit(User $user)
    {
        $this->checkAdmin();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->checkAdmin();

        // Validasi: Kalau cuma ganti Role (dari halaman index)
        if ($request->has('role') && count($request->all()) == 3) { // 3 itu token, method, role
            $request->validate(['role' => 'in:admin,user']);
            $user->update(['role' => $request->role]);
            return back()->with('success', 'Pangkat personel berhasil diubah!');
        }

        // Validasi: Kalau Edit Profil Lengkap
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data personel diperbarui!');
    }

    public function destroy(User $user)
    {
        $this->checkAdmin();
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa memecat diri sendiri, Komandan!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Personel diberhentikan!');
    }
}