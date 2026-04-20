<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Links - LinkInBio</title>
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
                    <a href="{{ route('user-dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition">Dashboard</a>
                    <a href="#" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Links</a>
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