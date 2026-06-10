<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - LinkInBio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .floating-card {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
        }
        .aurora {
            animation: pulse-slow 8s infinite;
        }
    </style>
</head>
<body class="bg-white overflow-x-hidden">

    <div class="flex min-h-screen relative">
        
        <a href="{{ route('login') }}" class="absolute top-6 left-6 md:top-10 md:left-16 lg:left-24 z-50 flex items-center space-x-2 text-gray-500 hover:text-black transition-colors group font-bold text-sm md:text-base bg-white/50 backdrop-blur-sm p-2 rounded-lg lg:bg-transparent lg:p-0">
            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
            <span>Kembali ke Login</span>
        </a>

        <div class="w-full lg:w-[55%] flex flex-col p-6 sm:p-12 md:p-16 lg:p-24 relative justify-center z-10 bg-white">
            
            <div class="mb-8 md:mb-12 mt-16 lg:mt-0 text-center lg:text-left">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 md:h-10 mx-auto lg:mx-0">
            </div>

            <div class="max-w-md w-full mx-auto lg:mx-0">
                <div class="mb-8 md:mb-10 text-center lg:text-left">
                    <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-2 md:mb-3 tracking-tight">Lupa sandi?</h1>
                    <p class="text-gray-500 font-medium text-sm md:text-base">Tenang, masukkan emailmu di bawah dan kami akan kirimkan link resetnya.</p>
                </div>

                @if (session('status'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl shadow-sm animate-bounce">
                        <p class="font-bold text-sm">Berhasil!</p>
                        <p class="text-xs">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Terdaftar" required autofocus
                            class="w-full p-3.5 md:p-4 bg-gray-100 border-2 border-transparent focus:border-black focus:bg-white rounded-xl transition-all outline-none font-medium text-gray-700 text-sm md:text-base">
                        @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full p-3.5 md:p-4 bg-black text-white font-extrabold rounded-full hover:bg-gray-800 transition-all duration-300 shadow-lg active:scale-95 mt-2 text-sm md:text-base">
                        Kirim Link Reset
                    </button>
                </form>
            </div>
        </div>

        <div class="hidden lg:flex lg:w-[45%] bg-[#1E41B2] relative overflow-hidden items-center justify-center border-l border-gray-100">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] h-[110%] bg-[#D2E823] rotate-12 rounded-[120px] z-0"></div>

            <div class="relative z-10 w-full h-full flex items-center justify-center">
                
                <div class="absolute top-[10%] left-[10%] w-12 h-12 bg-[#FF0000] rounded-xl flex items-center justify-center text-white shadow-lg rotate-[-15deg] floating-card" style="animation-delay: 0.5s;">
                    <i class="fa-brands fa-youtube text-2xl"></i>
                </div>
                <div class="absolute bottom-[10%] right-[10%] w-10 h-10 bg-[#1DB954] rounded-lg flex items-center justify-center text-white shadow-md rotate-[20deg] floating-card" style="animation-delay: 3s;">
                    <i class="fa-brands fa-spotify text-xl"></i>
                </div>

                <div class="w-64 h-[500px] bg-white rounded-[45px] border-[8px] border-slate-900 shadow-2xl relative overflow-hidden z-10 scale-95 md:scale-100">
                    <div class="absolute top-0 w-full h-5 bg-slate-900 rounded-b-2xl z-20"></div>
                    
                    <div class="w-full h-full bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-12 pb-8 px-5 overflow-hidden relative text-center">
                        <div class="aurora absolute top-0 left-0 w-32 h-32 bg-blue-300/40 rounded-full filter blur-[35px] -ml-8 -mt-8"></div>
                        
                        <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto border-2 border-white shadow flex items-center justify-center mb-4">
                            <i class="fa-solid fa-key text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-black text-gray-900">Reset Sandi</h3>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Keamanan Nomor 1</p>

                        <div class="mt-8 space-y-3">
                            <div class="h-8 bg-white/70 rounded-xl animate-pulse"></div>
                            <div class="h-8 bg-white/70 rounded-xl animate-pulse" style="animation-delay: 0.2s;"></div>
                        </div>
                    </div>
                </div>

                <div class="absolute top-[18%] left-[8%] bg-white/95 backdrop-blur-md p-3 rounded-2xl shadow-2xl border border-white z-20 transform -rotate-3 floating-card">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-envelope-circle-check"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-gray-400 font-bold uppercase leading-none mb-1">Status</p>
                            <p class="text-xs font-black text-gray-900 leading-none">Email Terkirim</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('components.alerts')
</body>
</html>