<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Preview - SmartLink Bio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
            /* Grid Dot Background - 1 titik = 24px */
            background-image: radial-gradient(#e5e7eb 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }

        .edit-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-card {
            border-radius: 3.5rem;
            background: white;
            box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.08);
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
                    <a href="{{ route('user-dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Dashboard</a>
                    <a href="{{ route('user-link') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Links</a>
                    <a href="#" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Appearance</a>
                    <a href="#" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Analytics</a>
                    <a href="#" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Profile</a>
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

    <main class="flex-grow flex items-center justify-center px-4 py-16 relative z-10">
        <div class="absolute inset-0 overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[20%] left-[25%] w-[400px] h-[400px] bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-40"></div>
            <div class="absolute bottom-[20%] right-[25%] w-[400px] h-[400px] bg-purple-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-40"></div>
        </div>

        <div class="profile-card w-full max-w-[460px] p-10 md:p-12 border border-white relative z-20">
            <div class="flex flex-col items-center">
                <div class="relative mb-8 group cursor-pointer">
                    <div class="h-28 w-28 rounded-full bg-gray-50 border-4 border-white shadow-xl overflow-hidden edit-transition group-hover:scale-105">
                        <img src="{{ asset('images/template1.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-black/20 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center edit-transition">
                        <i class="fa-solid fa-camera text-white text-xl"></i>
                    </div>
                </div>

                <div class="text-center mb-10 group cursor-pointer px-6 py-2 rounded-2xl edit-transition hover:bg-gray-50">
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center justify-center">
                            Zhao Zendaya
                        <i class="fa-solid fa-pen text-[10px] ml-3 opacity-0 group-hover:opacity-20"></i>
                    </h1>
                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-[0.3em] mt-1">Pelajar & Kreator</p>
                </div>
                
                <div class="w-full space-y-4">
                    <a href="#" class="edit-transition flex items-center p-4 bg-gray-50 border border-transparent rounded-[1.8rem] hover:bg-white hover:border-blue-100 hover:shadow-md group">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mr-4 edit-transition group-hover:bg-blue-600 group-hover:text-white">
                            <i class="fa-solid fa-code text-sm"></i>
                        </div>
                        <div class="flex-grow text-left">
                            <h4 class="text-xs font-bold text-gray-900">Tutorial Programming</h4>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-blue-500 mr-1 edit-transition group-hover:translate-x-1"></i>
                    </a>

                    <a href="#" class="edit-transition flex items-center p-4 bg-gray-50 border border-transparent rounded-[1.8rem] hover:bg-white hover:border-purple-100 hover:shadow-md group">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mr-4 edit-transition group-hover:bg-purple-600 group-hover:text-white">
                            <i class="fa-solid fa-box-open text-sm"></i>
                        </div>
                        <div class="flex-grow text-left">
                            <h4 class="text-xs font-bold text-gray-900">Kumpulan Open Source</h4>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-purple-500 mr-1 edit-transition group-hover:translate-x-1"></i>
                    </a>
                </div>

                <div class="w-full max-w-7xl mx-auto p-4 md:p-6 relative z-20">
                    <div class="flex items-center justify-center"> 
                        <a href="/">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-5 w-auto">
                        </a>
                    </div>
                </div>
    </main>

    <footer class="w-full py-6">
        <p class="text-gray-400 text-[10px] font-bold text-center tracking-[0.2em] uppercase">
            &copy; 2026 SmartLink Bio Project
        </p>
    </footer>

</body>
</html>
