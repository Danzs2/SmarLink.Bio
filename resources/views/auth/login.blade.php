<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LinkInBio</title>
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
        
        <a href="/" class="absolute top-6 left-6 md:top-10 md:left-16 lg:left-24 z-30 flex items-center space-x-2 text-gray-500 hover:text-black transition-colors group font-bold text-sm md:text-base">
            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
            <span>Kembali</span>
        </a>

        <div class="w-full lg:w-[55%] flex flex-col p-6 sm:p-12 md:p-16 lg:p-24 relative justify-center z-10 bg-white">
            
            <div class="mb-8 md:mb-12 mt-16 lg:mt-0 text-center lg:text-left">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 md:h-10 mx-auto lg:mx-0">
            </div>

            <div class="max-w-md w-full mx-auto lg:mx-0">
                <div class="mb-8 md:mb-10 text-center lg:text-left">
                    <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-2 md:mb-3 tracking-tight">Selamat datang kembali</h1>
                    <p class="text-gray-500 font-medium text-sm md:text-base">Masuk ke LinkInBio Anda</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus
                            class="w-full p-3.5 md:p-4 bg-gray-100 border-2 border-transparent focus:border-black focus:bg-white rounded-xl transition-all outline-none font-medium text-gray-700 text-sm md:text-base">
                        @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Kata sandi" required
                            class="w-full p-3.5 md:p-4 bg-gray-100 border-2 border-transparent focus:border-black focus:bg-white rounded-xl transition-all outline-none font-medium text-gray-700 text-sm md:text-base">
                        @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full p-3.5 md:p-4 bg-black text-white font-extrabold rounded-full hover:bg-gray-800 transition-all duration-300 shadow-lg active:scale-95 mt-2 text-sm md:text-base">
                        Lanjutkan
                    </button>
                </form>

                <div class="mt-8 md:mt-10 space-y-4 text-center lg:text-left border-t border-gray-100 pt-6 md:pt-8">
                    <div class="flex flex-wrap justify-center lg:justify-start gap-3 md:gap-4 text-xs md:text-sm font-bold text-blue-600">
                        <a href="{{ route('password.request') }}" class="hover:underline">Lupa kata sandi?</a>
                    </div>
                    <p class="text-xs md:text-sm font-medium text-gray-500">
                        Tidak memiliki akun? <a href="{{ route('register') }}" class="text-blue-600 font-black hover:underline">Daftar</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex lg:w-[45%] bg-[#1E41B2] relative overflow-hidden items-center justify-center">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[130%] h-[90%] bg-[#D2E823] rotate-12 rounded-[120px]"></div>

            <div class="absolute top-[10%] left-[15%] w-12 h-12 bg-[#FF0000]/80 rounded-xl flex items-center justify-center text-white shadow-lg rotate-[-15deg] floating-card" style="animation-delay: 0.5s;">
                <i class="fa-brands fa-youtube text-2xl"></i>
            </div>
            <div class="absolute bottom-[10%] right-[15%] w-10 h-10 bg-[#1DB954]/60 rounded-lg flex items-center justify-center text-white shadow-md rotate-[20deg] floating-card" style="animation-delay: 3s;">
                <i class="fa-brands fa-spotify text-xl"></i>
            </div>
            <div class="absolute bottom-[15%] left-[10%] w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white shadow-inner rotate-[-10deg] floating-card" style="animation-delay: 1.8s;">
                <i class="fa-brands fa-facebook-f text-2xl"></i>
            </div>
            <div class="absolute top-[40%] left-[5%] w-9 h-9 bg-[#0077B5]/70 rounded-lg flex items-center justify-center text-white rotate-[10deg] floating-card" style="animation-delay: 4s;">
                <i class="fa-brands fa-linkedin-in text-lg"></i>
            </div>

            <div class="absolute top-[15%] left-[10%] bg-white/95 backdrop-blur-md p-3 rounded-2xl shadow-xl border border-white/60 z-20 transform -rotate-3 floating-card">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 shadow-inner">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <div class="pr-2">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider text-left leading-none mb-1">Visits</p>
                        <p class="text-lg font-black text-gray-900 leading-none">1,204</p>
                    </div>
                </div>
            </div>

            <div class="absolute top-1/4 right-10 space-y-4 z-20">
                <div class="w-14 h-14 bg-[#FF5C00] rounded-2xl flex items-center justify-center text-white shadow-2xl rotate-12 floating-card" style="animation-delay: 1s;">
                    <i class="fa-brands fa-instagram text-2xl"></i>
                </div>
                <div class="w-14 h-14 bg-black rounded-2xl flex items-center justify-center text-white shadow-2xl -rotate-12 floating-card" style="animation-delay: 2s;">
                    <i class="fa-brands fa-github text-2xl"></i>
                </div>
            </div>

            <div class="w-64 h-[480px] bg-white rounded-[45px] border-[8px] border-slate-900 shadow-2xl relative overflow-hidden z-10">
                <div class="absolute top-0 w-full h-5 bg-slate-900 rounded-b-2xl z-20 flex justify-center">
                    <div class="w-20 h-2 bg-slate-800 mt-1 rounded-full opacity-20"></div>
                </div>
                
                <div class="w-full h-full bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-12 pb-8 px-5 overflow-hidden relative">
                    <div class="aurora absolute top-0 left-0 w-32 h-32 bg-blue-300/40 rounded-full filter blur-[35px] -ml-8 -mt-8"></div>
                    <div class="aurora absolute bottom-1/4 right-0 w-40 h-40 bg-purple-300/30 rounded-full filter blur-[35px] -mr-10" style="animation-delay: 2s;"></div>
                    
                    <div class="text-center relative z-10">
                        <img src="{{ asset('images/template1.jpg') }}" alt="Profile" class="w-20 h-20 rounded-full mx-auto border-[3px] border-white shadow-md object-cover">
                        <h3 class="mt-3 text-xl font-black text-gray-900 tracking-tight">Zhao</h3>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Artist</p>
                    </div>

                    <div class="mt-8 space-y-3 relative z-10">
                        <div class="bg-white/70 backdrop-blur-md p-3 rounded-2xl shadow-sm border border-white flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-800 text-left">GitHub Repository</span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                        </div>
                        <div class="bg-white/70 backdrop-blur-md p-3 rounded-2xl shadow-sm border border-white flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-800 text-left">Project PBL 2</span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                        </div>
                    </div>

                    <div class="absolute bottom-6 left-0 right-0 flex justify-center space-x-5 z-10">
                        <i class="fa-brands fa-x-twitter text-sm text-black/30"></i>
                        <i class="fa-brands fa-instagram text-sm text-pink-600/30"></i>
                        <i class="fa-brands fa-linkedin-in text-sm text-blue-700/30"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>