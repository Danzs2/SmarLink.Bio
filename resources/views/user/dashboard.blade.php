<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LinkInBio</title>
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
        <div class="blob absolute top-[-5%] left-[-5%] w-[400px] h-[400px] bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-50"></div>
        <div class="blob absolute bottom-[10%] right-[-5%] w-[400px] h-[400px] bg-purple-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-50" style="animation-delay: 3s;"></div>
    </div>

    <header class="w-full max-w-7xl mx-auto p-4 md:p-6 relative z-20">
        <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                </a>
                <nav class="hidden md:flex space-x-6">
                    <a href="#" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Dashboard</a>
                    <a href="{{ route('user-link') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Links</a>

                    <a href="#" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Appearance</a>
                    <a href="#" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Analytics</a>
    
                    <a href="{{ route('user-profile') }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition">Profile</a>
                </nav>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 text-gray-400 hover:text-gray-600"><i class="fa-regular fa-bell text-xl"></i></button>
                <div class="h-10 w-10 rounded-full bg-gray-200 border-2 border-white shadow-sm overflow-hidden">
                    <img src="{{ asset('images/template1.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-6 py-8 relative z-10">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-gray-900">Halo, Zhao Zendaya! 👋</h1>
                <p class="text-gray-500 font-medium">Berikut ringkasan performa link-mu hari ini.</p>
            </div>
            <button class="px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition shadow-lg flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Link Baru</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-[2rem] border border-white shadow-sm">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-4">
                    <i class="fa-solid fa-eye text-xl"></i>
                </div>
                <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest">Total Views</p>
                <h3 class="text-3xl font-black text-gray-900 mt-1">12,402</h3>
            </div>
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-[2rem] border border-white shadow-sm">
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-4">
                    <i class="fa-solid fa-mouse-pointer text-xl"></i>
                </div>
                <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest">Total Clicks</p>
                <h3 class="text-3xl font-black text-gray-900 mt-1">4,821</h3>
            </div>
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-[2rem] border border-white shadow-sm">
                <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-4">
                    <i class="fa-solid fa-link text-xl"></i>
                </div>
                <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest">Active Links</p>
                <h3 class="text-3xl font-black text-gray-900 mt-1">8</h3>
            </div>
            <div class="bg-white/70 backdrop-blur-md p-6 rounded-[2rem] border border-white shadow-sm">
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-4">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xl"></i>
                </div>
                <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest">CTR Avg.</p>
                <h3 class="text-3xl font-black text-gray-900 mt-1">38.4%</h3>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2.5rem] shadow-xl overflow-hidden">
            <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-black text-gray-900">Kelola Tautan</h2>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Terakhir diperbarui: Hari ini</span>
            </div>
            
            <div class="p-4 md:p-8 space-y-4">
                <div class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-white border border-transparent hover:border-gray-200 rounded-2xl transition-all cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-black text-white rounded-xl flex items-center justify-center text-xl">
                            <i class="fa-brands fa-github"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">GitHub Repository</h4>
                            <p class="text-xs text-gray-500 font-medium">github.com/zhao/project-x</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="hidden md:block text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Clicks</p>
                            <p class="text-sm font-black">1.2k</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="p-2 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="p-2 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-red-600 transition"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <div class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-white border border-transparent hover:border-gray-200 rounded-2xl transition-all cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-tr from-pink-500 to-yellow-500 text-white rounded-xl flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Instagram Art</h4>
                            <p class="text-xs text-gray-500 font-medium">instagram.com/zhao_art</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="hidden md:block text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Clicks</p>
                            <p class="text-sm font-black">842</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="p-2 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="p-2 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-red-600 transition"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                
                <p class="text-center py-4 text-gray-400 text-xs font-bold uppercase tracking-widest">
                    Lihat Semua Tautan <i class="fa-solid fa-chevron-down ml-1 text-[10px]"></i>
                </p>
            </div>
        </div>
    </main>

</body>
</html>