<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Terbatas | SmartLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto; }
        
        /* Tema Background Konsisten dengan Dashboard */
        .bg-dots {
            background-color: #F8FAFC;
            background-image: radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }
        .bg-aurora {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1; overflow: hidden;
            background: linear-gradient(135deg, rgba(248,250,252,0.8) 0%, rgba(241,240,255,0.8) 100%);
        }
        .circle-purple { position: absolute; top: -10%; right: -5%; width: 500px; height: 500px; background: rgba(139, 92, 246, 0.15); filter: blur(100px); border-radius: 50%; animation: float 6s ease-in-out infinite; }
        .circle-blue { position: absolute; bottom: -10%; left: -5%; width: 600px; height: 600px; background: rgba(59, 130, 246, 0.12); filter: blur(100px); border-radius: 50%; animation: float 8s ease-in-out infinite reverse; }
        
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }
        
        /* Efek Kaca */
        .card-glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
    </style>
</head>
<body class="bg-dots flex items-center justify-center min-h-screen p-4 relative overflow-hidden">
    
    <div class="bg-aurora">
        <div class="circle-purple"></div>
        <div class="circle-blue"></div>
    </div>

    <div class="card-glass p-8 sm:p-10 rounded-[32px] shadow-2xl shadow-indigo-900/10 w-full max-w-md relative z-10 transition-all">
        
        <div class="text-center mb-8 relative">
            <div class="absolute inset-0 bg-indigo-400 blur-[30px] opacity-20 rounded-full h-24 w-24 mx-auto"></div>
            
            <div class="relative w-20 h-20 bg-gradient-to-br from-indigo-50 to-white text-indigo-600 rounded-[20px] shadow-sm border border-indigo-100 flex items-center justify-center mx-auto mb-5 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                <i class="fa-solid fa-shield-halved text-4xl bg-gradient-to-br from-indigo-600 to-purple-600 bg-clip-text text-transparent"></i>
            </div>
            
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Akses Terkunci</h2>
            <p class="text-gray-500 text-sm mt-2 leading-relaxed">Tautan ini dilindungi privasi. Silakan verifikasi untuk membuka <br><strong class="text-indigo-600 font-bold"><?= $link->title ?></strong></p>
        </div>

        <?php if(session('error')): ?>
            <div class="bg-rose-50/80 backdrop-blur-sm border border-rose-100/50 text-rose-600 px-4 py-3 rounded-2xl text-sm font-bold text-center mb-6 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-exclamation animate-pulse"></i> <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= route('link.verify', $link->id) ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>
            
            <?php if($link->link_password): ?>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-key text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="password" name="password" placeholder="Masukkan Sandi Rahasia" required
                        class="w-full bg-white/60 border-2 border-white focus:border-indigo-500/50 focus:bg-white rounded-2xl pl-12 pr-5 py-4 outline-none transition-all font-bold tracking-widest text-gray-900 placeholder:tracking-normal placeholder:font-medium shadow-inner shadow-gray-100/50 focus:ring-4 focus:ring-indigo-500/10">
                </div>
            <?php else: ?>
                <div class="bg-white/60 backdrop-blur-sm p-5 rounded-2xl border border-white shadow-sm text-left mb-4 group hover:bg-white transition-colors cursor-default">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2 flex items-center gap-1.5"><i class="fa-solid fa-fingerprint"></i> Autentikasi Pengguna</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center border border-indigo-200">
                            <i class="fa-solid fa-user text-indigo-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 font-medium truncate">Akan diverifikasi sebagai:</p>
                            <p class="text-sm font-bold text-gray-900 truncate"><?= optional(Auth::user())->email ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <button type="submit" class="w-full relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-gray-900 font-pj rounded-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 hover:bg-black shadow-xl shadow-gray-900/20 transform active:scale-[0.98]">
                <?= $link->link_password ? '<i class="fa-solid fa-unlock mr-2"></i> Buka Tautan Sekarang' : '<i class="fa-solid fa-check-double mr-2"></i> Konfirmasi Izin Akses' ?>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200/50 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="SmartLink" class="h-4 w-auto object-contain mx-auto opacity-30 grayscale hover:opacity-100 hover:grayscale-0 transition-all">
        </div>

    </div>
</body>
</html>