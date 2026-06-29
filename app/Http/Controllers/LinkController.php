<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class LinkController extends Controller
{
    private function checkUrlSafety($url)
    {
        $apiKey = env('GOOGLE_SAFE_BROWSING_KEY');
        if (!$apiKey) return true; 

        try {
            $response = Http::post('https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey, [
                'client' => ['clientId' => 'smartlink-bio', 'clientVersion' => '1.0'],
                'threatInfo' => [
                    'threatTypes'      => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE', 'POTENTIALLY_HARMFUL_APPLICATION'],
                    'platformTypes'    => ['ANY_PLATFORM'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries'    => [['url' => $url]]
                ]
            ]);

            $data = $response->json();
            if (isset($data['matches']) && count($data['matches']) > 0) return false; 
        } catch (\Exception $e) {
            return true; 
        }
        return true;
    }

    private function handleViolation($invalidUrl)
    {
        $user = Auth::user();
        
        // 1. Tambah poin di tabel users
        $user->increment('violation_count');
        $user->refresh();

        // 2. Catat sejarah URL jahat ke tabel violation_logs
        DB::table('violation_logs')->insert([
            'user_id' => $user->id,
            'invalid_url' => $invalidUrl,
            'threat_type' => 'Malware/Phishing',
            'detected_at' => now()
        ]);

        // 3. Kalau sudah 3 poin, ubah status jadi banned dan Kick!
        if ($user->violation_count >= 3) {
            $user->update(['status' => 'banned']); 
            Auth::logout();
            return redirect()->route('login')->with('error', 'AKUN DIBLOKIR! Kamu terdeteksi berulang kali menyebarkan tautan Phishing/Malware.');
        }

        return back()->with('error', 'TAUTAN DITOLAK! URL terdeteksi berbahaya. Poin pelanggaranmu bertambah: ' . $user->violation_count . '/3');
    }

    public function index()
    {
        $user = Auth::user();
        $links = Link::select('links.*')
            ->selectRaw('(SELECT COUNT(*) FROM analytics WHERE analytics.link_id = links.id) as clicks')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.dashboard', compact('user', 'links'));
    }

    public function store(Request $request)
    {
        if (!$this->checkUrlSafety($request->url)) {
            return $this->handleViolation($request->url);
        }

        $link = new Link();
        $link->user_id = Auth::id(); 
        $link->title = $request->title;
        $link->url = $request->url;
        $link->type = $request->type; 
        
        if ($request->type === 'social') {
            $link->platform = $request->platform;
            $link->is_private = 0; 
        } else {
            $link->is_private = $request->privacy_mode === 'public' ? 0 : 1;
            
            // Password dienkripsi menggunakan Hash sebelum disimpan
            if ($request->privacy_mode === 'password') {
                $link->link_password = Hash::make($request->link_password);
            }
        }

        $link->is_active = 1;
        $link->save();

        return back()->with('success', 'Tautan berhasil ditambahkan dan dinyatakan aman!');
    }

    public function update(Request $request, $id)
    {
        $link = Link::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($link->url !== $request->url) {
            if (!$this->checkUrlSafety($request->url)) {
                return $this->handleViolation($request->url);
            }
        }

        $link->title = $request->title;
        $link->url = $request->url;

        if ($link->type === 'custom') {
            $link->is_private = $request->privacy_mode === 'public' ? 0 : 1;
            
            if ($request->privacy_mode === 'password') {
                // Hanya enkripsi password JIKA user memasukkan teks baru
                if ($request->filled('link_password') && $request->link_password !== $link->link_password) {
                    $link->link_password = Hash::make($request->link_password);
                }
            } else { 
                // Jika dirubah jadi public, kosongkan password
                $link->link_password = null;
            }
        }

        $link->save();
        return back()->with('success', 'Tautan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $link = Link::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        DB::table('analytics')->where('link_id', $link->id)->delete();
        $link->delete();
        return back()->with('success', 'Tautan berhasil dihapus!');
    }

    public function toggle($id)
    {
        $link = Link::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $link->is_active = $link->is_active == 1 ? 0 : 1;
        $link->save();
        return response()->json(['success' => true, 'is_active' => $link->is_active]);
    }

    public function redirect($id)
    {
        $link = Link::findOrFail($id);
        if (!$link->is_active) { abort(404); }

        if (!$link->is_private || Auth::id() === $link->user_id) {
            DB::table('analytics')->insert(['link_id' => $link->id, 'clicked_at' => now()]);
            return redirect()->away($link->url);
        }

        if (!$link->link_password) {
            // Jika statusnya private tapi tidak ada password
            return redirect()->route('login')->with('info', 'Tautan ini terbatas.');
        }

        return view('public.verify', compact('link'));
    }

    public function verify(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        if ($link->link_password) {
            // Cek password menggunakan Hash::check() dan tetap dukung password lama
            if (Hash::check($request->password, $link->link_password) || $request->password === $link->link_password) {
                DB::table('analytics')->insert(['link_id' => $link->id, 'clicked_at' => now()]);
                return redirect()->away($link->url);
            }
            return back()->with('error', 'Password salah!');
        }

        if (Auth::id() === $link->user_id) {
            DB::table('analytics')->insert(['link_id' => $link->id, 'clicked_at' => now()]);
            return redirect()->away($link->url);
        }

        return back()->with('error', 'Akses Ditolak! Tautan ini terkunci.');
    }

    public function showProfile($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        
        if($user->status === 'banned') { abort(404); }

        $user->increment('visits'); 
        $links = Link::where('user_id', $user->id)->where('is_active', 1)->get();

        return view('public.profile', compact('user', 'links'));
    }

    public function updateAppearance(Request $request)
    {
        $user = auth()->user();
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->update(['profile_picture' => $path]);
        }
        $user->update(['name' => $request->name, 'bio' => $request->bio]);

        $bgImagePath = $user->pageSetting->background_image ?? null;
        if ($request->hasFile('bg_image')) { 
            $bgImagePath = $request->file('bg_image')->store('backgrounds', 'public');
        }

        $user->pageSetting()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bg_type' => $request->bg_type, 'bg_color' => $request->bg_color,
                'background_image' => $bgImagePath, 'button_color' => $request->button_color,
                'text_color' => $request->text_color, 'button_corner_style' => $request->button_corner_style,
                'button_display_style' => $request->button_display_style, 'social_position' => $request->social_position
            ]
        );
        return response()->json(['success' => true]);
    }
}