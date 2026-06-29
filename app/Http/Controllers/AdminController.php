<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link; // <-- WAJIB DITAMBAH BIAR BISA NGITUNG TAUTAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class AdminController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman dashboard & data tabel
    public function index() {
        // Tarik data statistik untuk Kartu "Ringkasan Sistem"
        $totalAktif = User::where('status', '!=', 'banned')->count(); // Hitung user aktif
        $totalBlokir = User::where('status', 'banned')->count();      // Hitung user diblokir
        $totalTautan = Link::count();                                 // Hitung SEMUA tautan di database

        // Ambil data pengguna yang ada beserta jumlah link-nya untuk tabel
        $pengguna = User::withCount('links')->get();
        
        // Kirim semua datanya (termasuk statistik) ke view
        return view('admin.dashboard', compact('pengguna', 'totalAktif', 'totalBlokir', 'totalTautan'));
    }

    // 2. Fungsi untuk menyimpan data pengguna baru (Create)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 'ACTIVE', 
            'password' => Hash::make($request->password), 
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

  // 3. Fungsi untuk mengupdate data pengguna (Edit)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
        ]);

        // --- FITUR CUCI GUDANG START ---
        // Jika statusnya mau diubah jadi 'admin' (dan sebelumnya bukan admin)
        if ($request->role === 'admin' && $user->role !== 'admin') {
            
            // 1. Hapus semua link milik dia (Analitiknya otomatis ikut kehapus kalau pakai Delete Cascade di database)
            Link::where('user_id', $user->id)->delete();
            
            // 2. Bersihkan catatan pelanggaran dia di log satpam
            \Illuminate\Support\Facades\DB::table('violation_logs')->where('user_id', $user->id)->delete();
            
            // 3. Reset poin pelanggaran kembali ke 0
            $user->violation_count = 0;
            // Jangan lupa save perubahan poin
            $user->save(); 
        }
        // --- FITUR CUCI GUDANG END ---

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Profil pengguna berhasil diperbarui & data dibersihkan jika jadi Admin!');
    }
}