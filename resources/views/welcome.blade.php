<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkInBio - Satu Link Untuk Semua</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
            background-image: radial-gradient(#e5e7eb 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
        }

        .blob {
            animation: pulse-slow 8s infinite;
        }
    </style>
</head>
<body class="text-gray-900 flex flex-col min-h-screen overflow-x-hidden relative z-0">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="blob absolute top-[-5%] left-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-blue-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-40"></div>
        <div class="blob absolute top-[10%] right-[-5%] w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-purple-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-40" style="animation-delay: 2s;"></div>
    </div>

    <header class="w-full max-w-6xl mx-auto p-4 md:p-6 relative z-20">
        <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-full shadow-sm px-4 py-2 md:px-6 md:py-3 flex justify-between items-center">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="LinkInBio Logo" class="h-7 md:h-10 w-auto object-contain transition-transform hover:scale-105">
            </a>
            <a href="/login" class="px-4 md:px-7 py-1.5 md:py-2 bg-blue-600 text-white text-xs md:text-base font-bold rounded-full hover:bg-blue-700 transition shadow">Log In</a>
        </div>
    </header>

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 py-8 md:py-12 relative z-10">
        
        <div class="flex flex-col items-center text-center mb-12 md:mb-16">
            <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-4 md:mb-6 tracking-tight leading-tight md:leading-[1.1]">
                Satu Link Untuk <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Semua Kebutuhanmu!</span>
            </h1>
            <p class="text-xs sm:text-base md:text-xl text-gray-600 mb-8 md:mb-10 max-w-2xl px-2 font-medium leading-relaxed">
                Kumpulkan semua tautan sosial media, portofolio, dan kontakmu dalam satu halaman rapi. Tambahkan tanpa batas.
            </p>
            <a href="/register" class="px-7 md:px-10 py-3.5 md:py-4 text-sm md:text-lg font-bold text-white bg-gray-900 rounded-full hover:bg-black shadow-xl transform hover:-translate-y-1 transition-all border-2 border-transparent hover:border-gray-700">
                Buat Link-mu Sekarang &rarr;
            </a>
        </div>

<div class="relative flex justify-center w-full max-w-2xl mx-auto mt-8 md:mt-20 px-4 mb-10 md:mb-20">
    
    <div class="absolute inset-0 bg-gradient-to-b from-blue-400/20 to-purple-500/20 blur-3xl w-full max-w-xs md:max-w-md mx-auto h-[300px] md:h-[500px] rounded-full -z-10"></div>

    <div class="absolute top-[10%] left-0 sm:left-[-5%] md:left-[-15%] lg:left-[-25%] bg-white/95 backdrop-blur-md p-2.5 md:p-4 rounded-xl md:rounded-2xl shadow-xl border border-white/60 z-20 transform -rotate-3 scale-75 sm:scale-90 md:scale-100 animate-[float_4s_ease-in-out_infinite] origin-right">
        <div class="flex items-center space-x-2 md:space-x-3">
            <div class="w-8 h-8 md:w-12 md:h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 shadow-inner">
                <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div class="pr-1 md:pr-2">
                <p class="text-[8px] md:text-xs text-gray-500 font-bold uppercase tracking-tighter">Total Kunjungan</p>
                <p class="text-xs md:text-lg font-extrabold text-gray-900">1,204</p>
            </div>
        </div>
    </div>

    <div class="absolute bottom-[20%] right-0 sm:right-[-5%] md:right-[-15%] lg:right-[-25%] bg-white/95 backdrop-blur-md p-2.5 md:p-4 rounded-xl md:rounded-2xl shadow-xl border border-white/60 z-20 transform rotate-3 scale-75 sm:scale-90 md:scale-100 animate-[float_5s_ease-in-out_infinite_reverse] origin-left">
         <div class="flex items-center space-x-2 md:space-x-3">
            <div class="w-8 h-8 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 shadow-inner">
                <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </div>
            <div class="pr-1 md:pr-2">
                <p class="text-[8px] md:text-xs text-gray-500 font-bold uppercase tracking-tighter">Link Baru</p>
                <p class="text-xs md:text-sm font-bold text-gray-900">LinkedIn</p>
            </div>
        </div>
    </div>

    <div class="relative w-[220px] sm:w-[280px] md:w-[320px] h-[450px] sm:h-[560px] md:h-[650px] bg-white rounded-[35px] md:rounded-[50px] shadow-2xl border-[6px] md:border-[10px] border-gray-900 z-10 overflow-hidden ring-4 ring-gray-200/50">
                
                <div class="absolute top-0 inset-x-0 h-5 md:h-8 flex justify-center z-30">
                    <div class="w-20 md:w-32 h-3.5 md:h-6 bg-gray-900 rounded-b-xl md:rounded-b-2xl"></div>
                </div>

                <div class="w-full h-full bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-12 md:pt-16 pb-6 px-4 md:px-6 overflow-y-auto relative z-0">
                    <div class="absolute top-0 left-0 w-24 h-24 bg-blue-300/30 rounded-full blur-2xl -ml-6 -mt-6"></div>
                    
                    <div class="text-center relative z-10">
                        <img src="{{ asset('images/template1.jpg') }}" alt="Profile" class="w-16 h-16 md:w-24 md:h-24 rounded-full mx-auto border-2 md:border-[3px] border-white shadow-md object-cover">
                        <h3 class="mt-3 md:mt-4 text-lg md:text-2xl font-black text-gray-900 tracking-tight">Zhao</h3>
                        <p class="text-[10px] md:text-sm text-gray-500 font-medium">Artist</p>
                    </div>

                    <div class="mt-6 md:mt-8 space-y-3 relative z-10">
                        <div class="bg-white/70 backdrop-blur-md p-3 md:p-4 rounded-xl border border-white flex items-center justify-between hover:bg-white transition cursor-pointer group shadow-sm">
                            <span class="text-xs md:text-base font-bold text-gray-800">GitHub Repository</span>
                            <span class="text-gray-400 text-xs">&rarr;</span>
                        </div>
                        <div class="bg-white/70 backdrop-blur-md p-3 md:p-4 rounded-xl border border-white flex items-center justify-between hover:bg-white transition cursor-pointer group shadow-sm">
                            <span class="text-xs md:text-base font-bold text-gray-800">Project PBL 2</span>
                            <span class="text-gray-400 text-xs">&rarr;</span>
                        </div>
                        <div class="bg-white/70 backdrop-blur-md p-3 md:p-4 rounded-xl border border-white flex items-center justify-between hover:bg-white transition cursor-pointer group shadow-sm">
                            <span class="text-xs md:text-base font-bold text-gray-800">LinkedIn Profile</span>
                            <span class="text-gray-400 text-xs">&rarr;</span>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center space-x-4 md:space-x-6">
                        <i class="fa-brands fa-x-twitter text-base md:text-xl"></i>
                        <i class="fa-brands fa-instagram text-base md:text-xl text-pink-600"></i>
                        <i class="fa-brands fa-linkedin-in text-base md:text-xl text-blue-700"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full bg-white/60 backdrop-blur-lg border-t-2 border-gray-300 relative z-20 py-6 md:py-8 mt-auto">
        <div class="max-w-6xl mx-auto px-6 relative">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-0">
                
                <div class="order-1 flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 md:h-9 object-contain">
                </div>

                <div class="order-3 md:order-2 md:absolute md:left-1/2 md:-translate-x-1/2">
                    <p class="text-gray-500 text-[10px] md:text-xs font-bold tracking-[0.15em] uppercase text-center">
                        &copy; 2026 LinkInBio Project
                    </p>
                </div>

                <div class="order-2 md:order-3 flex items-center space-x-6">
                    <a href="https://www.instagram.com/smartlink.bio/" target="_blank" class="text-xl text-pink-600 hover:scale-110 transition">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://github.com/Danzs2/LinkInBio.git" target="_blank" class="text-xl text-gray-900 hover:scale-110 transition">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>