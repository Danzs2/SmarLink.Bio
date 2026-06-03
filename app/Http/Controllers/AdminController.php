<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Wajib ditambahkan untuk hash password

class AdminController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman dashboard & data tabel
    public function index() {
        // Cukup ambil data pengguna yang ada beserta jumlah link-nya
        $pengguna = User::withCount('links')->get();
        
        // Kirim data pengguna saja ke view
        return view('admin.dashboard', compact('pengguna'));
    }

    // 2. Fungsi untuk menyimpan data pengguna baru (Create)
    public function store(Request $request)
    {
        // Validasi inputan form
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        // Simpan ke database
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 'ACTIVE', // Otomatis aktif saat baru dibuat
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Kembalikan ke halaman sebelumnya (dashboard)
        return back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // 3. Fungsi untuk mengupdate data pengguna (Edit)
    public function update(Request $request, $id)
    {
        // Cari data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi inputan form (pastikan username/email bisa sama dengan miliknya sendiri)
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
        ]);

        // Update ke database (tanpa mengubah password)
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Kembalikan ke halaman sebelumnya
        return back()->with('success', 'Profil pengguna berhasil diperbarui!');
    }
}