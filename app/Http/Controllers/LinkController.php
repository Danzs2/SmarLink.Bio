<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // PERBAIKAN: Ambil data link, dan hitung jumlah klik langsung dari tabel 'analytics'
        $links = Link::select('links.*')
            ->selectRaw('(SELECT COUNT(*) FROM analytics WHERE analytics.link_id = links.id) as clicks')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.dashboard', compact('user', 'links'));
    }

    public function store(Request $request)
    {
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
            if ($request->privacy_mode === 'password') {
                $link->link_password = $request->link_password;
            }
        }

        $link->is_active = 1;
        $link->save();

        if ($request->type === 'custom' && $request->privacy_mode === 'email' && $request->allowed_emails) {
            $emails = explode(',', $request->allowed_emails);
            foreach ($emails as $email) {
                DB::table('link_permissions')->insert([
                    'link_id' => $link->id,
                    'allowed_email' => trim($email),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Tautan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $link = Link::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $link->title = $request->title;
        $link->url = $request->url;

        if ($link->type === 'custom') {
            $link->is_private = $request->privacy_mode === 'public' ? 0 : 1;
            
            if ($request->privacy_mode === 'password') {
                $link->link_password = $request->link_password;
                DB::table('link_permissions')->where('link_id', $link->id)->delete();
            } 
            elseif ($request->privacy_mode === 'email') {
                $link->link_password = null;
                DB::table('link_permissions')->where('link_id', $link->id)->delete();
                if ($request->allowed_emails) {
                    $emails = explode(',', $request->allowed_emails);
                    foreach ($emails as $email) {
                        DB::table('link_permissions')->insert([
                            'link_id' => $link->id,
                            'allowed_email' => trim($email),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            } 
            else { 
                $link->link_password = null;
                DB::table('link_permissions')->where('link_id', $link->id)->delete();
            }
        }

        $link->save();
        return back()->with('success', 'Tautan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $link = Link::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        DB::table('link_permissions')->where('link_id', $link->id)->delete();
        
        // Hapus juga riwayat kliknya biar databasenya bersih
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

    // =========================================================================
    // REDIRECT & CATAT KE TABEL ANALYTICS
    // =========================================================================
    public function redirect($id)
    {
        $link = Link::findOrFail($id);
        if (!$link->is_active) { abort(404); }

        if (!$link->is_private || Auth::id() === $link->user_id) {
            
            // PERBAIKAN: Masukkan data ke tabel analytics
            DB::table('analytics')->insert([
                'link_id' => $link->id,
                'clicked_at' => now()
            ]);

            return redirect()->away($link->url);
        }

        if (!$link->link_password && !Auth::check()) {
            return redirect()->route('login')->with('info', 'Tautan ini terbatas, silakan login dulu.');
        }

        return view('public.verify', compact('link'));
    }

    public function verify(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        if ($link->link_password) {
            if ($request->password === $link->link_password) {
                // PERBAIKAN: Masukkan data ke tabel analytics
                DB::table('analytics')->insert([
                    'link_id' => $link->id,
                    'clicked_at' => now()
                ]);
                return redirect()->away($link->url);
            }
            return back()->with('error', 'Password salah!');
        }

        $userEmail = Auth::user()->email;

        if (Auth::id() === $link->user_id) {
            // PERBAIKAN: Masukkan data ke tabel analytics
            DB::table('analytics')->insert([
                'link_id' => $link->id,
                'clicked_at' => now()
            ]);
            return redirect()->away($link->url);
        }

        $isAllowed = DB::table('link_permissions')
            ->where('link_id', $link->id)
            ->where('allowed_email', $userEmail)
            ->exists();

        if ($isAllowed) {
            // PERBAIKAN: Masukkan data ke tabel analytics
            DB::table('analytics')->insert([
                'link_id' => $link->id,
                'clicked_at' => now()
            ]);
            return redirect()->away($link->url);
        }

        return back()->with('error', 'Akses Ditolak! Email kamu (' . $userEmail . ') tidak ada di daftar izin.');
    }

    public function showProfile($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        $user->increment('visits'); 
        
        $links = Link::where('user_id', $user->id)
                     ->where('is_active', 1)
                     ->get();

        return view('public.profile', compact('user', 'links'));
    }

    public function updateAppearance(Request $request)
    {
        $user = auth()->user();
        
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->update(['profile_picture' => $path]);
        }

        $user->update([
            'name' => $request->name,
            'bio' => $request->bio
        ]);

        $bgImagePath = $user->pageSetting->background_image ?? null;
        if ($request->hasFile('bg_image')) { 
            $bgImagePath = $request->file('bg_image')->store('backgrounds', 'public');
        }

        $user->pageSetting()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bg_type' => $request->bg_type,
                'bg_color' => $request->bg_color,
                'background_image' => $bgImagePath, 
                'button_color' => $request->button_color,
                'text_color' => $request->text_color,
                'button_corner_style' => $request->button_corner_style,
                'button_display_style' => $request->button_display_style,
                'social_position' => $request->social_position
            ]
        );

        return response()->json(['success' => true]);
    }
}