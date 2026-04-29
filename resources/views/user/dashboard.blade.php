<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pro - SmartLink Bio</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ tab: 'links', showAddLink: false }">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex z-20 shadow-sm">
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <i class="fa-solid fa-link text-brand-600 text-2xl mr-2"></i>
                <span class="text-xl font-black tracking-tight text-gray-900">SMART<span class="text-brand-600">LINK</span></span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <button @click="tab = 'links'" :class="tab === 'links' ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-list-ul w-6"></i> Tautan Saya
                </button>
                <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-palette w-6"></i> Desain Tampilan
                </button>
                <button @click="tab = 'analytics'" :class="tab === 'analytics' ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-chart-line w-6"></i> Analitik & Trafik
                </button>
                <button @click="tab = 'settings'" :class="tab === 'settings' ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-shield-halved w-6"></i> Keamanan & Akun
                </button>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Andi') . '&background=2563eb&color=fff' }}" alt="Avatar" class="w-10 h-10 rounded-full border border-gray-200">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name ?? 'Andi Pratama' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ '@' . (Auth::user()->username ?? 'andipratama') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50/50">
            
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 lg:px-10 z-10">
                <h1 class="text-2xl font-bold text-gray-800 capitalize" x-text="tab === 'links' ? 'Manajemen Tautan' : (tab === 'appearance' ? 'Kustomisasi Desain' : (tab === 'analytics' ? 'Statistik Kunjungan' : 'Pengaturan Akun'))"></h1>
                <div class="flex items-center gap-4">
                    <a href="#" target="_blank" class="text-sm font-medium text-gray-500 hover:text-brand-600 hidden sm:block">
                        smartlink.com/{{ '@' . (Auth::user()->username ?? 'andipratama') }}
                    </a>
                    <button class="bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-gray-800 transition shadow-md">
                        Bagikan
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
                <div class="max-w-3xl mx-auto">

                    <div x-show="tab === 'links'" x-transition.opacity.duration.300ms>
                        
                        <button @click="showAddLink = !showAddLink" class="w-full bg-brand-600 text-white rounded-2xl p-4 font-bold text-lg hover:bg-brand-700 transition shadow-lg shadow-brand-500/30 flex items-center justify-center gap-2 mb-8">
                            <i class="fa-solid fa-plus" x-show="!showAddLink"></i>
                            <i class="fa-solid fa-xmark" x-show="showAddLink" x-cloak></i>
                            <span x-text="showAddLink ? 'Batal Tambah Tautan' : 'Tambah Tautan Baru'"></span>
                        </button>

                        <div x-show="showAddLink" x-collapse class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 mb-8" x-data="{ linkType: 'public' }">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Buat Tautan Baru</h3>
                            <form action="#" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Judul Tautan</label>
                                    <input type="text" placeholder="Contoh: Portofolio Terbaru" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-brand-500 focus:ring-0 outline-none transition font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">URL Tujuan</label>
                                    <input type="url" placeholder="https://" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-brand-500 focus:ring-0 outline-none transition font-medium">
                                </div>

                                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3"><i class="fa-solid fa-shield-halved"></i> Tingkat Keamanan Tautan</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="privacy" value="public" x-model="linkType" class="peer sr-only">
                                            <div class="p-3 border-2 border-gray-200 rounded-xl text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-100 transition">
                                                <i class="fa-solid fa-globe text-gray-400 peer-checked:text-green-600 block mb-1 text-lg"></i>
                                                <span class="text-sm font-bold text-gray-600 peer-checked:text-green-700">Publik</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="privacy" value="password" x-model="linkType" class="peer sr-only">
                                            <div class="p-3 border-2 border-gray-200 rounded-xl text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:bg-gray-100 transition">
                                                <i class="fa-solid fa-key text-gray-400 peer-checked:text-orange-600 block mb-1 text-lg"></i>
                                                <span class="text-sm font-bold text-gray-600 peer-checked:text-orange-700">Sandi (PIN)</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="privacy" value="private" x-model="linkType" class="peer sr-only">
                                            <div class="p-3 border-2 border-gray-200 rounded-xl text-center peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-gray-100 transition">
                                                <i class="fa-solid fa-envelope-open-text text-gray-400 peer-checked:text-brand-600 block mb-1 text-lg"></i>
                                                <span class="text-sm font-bold text-gray-600 peer-checked:text-brand-700">Private Email</span>
                                            </div>
                                        </label>
                                    </div>

                                    <div x-show="linkType === 'password'" x-collapse class="mt-4">
                                        <input type="text" placeholder="Masukkan Sandi/PIN (Maks 8 Karakter)" class="w-full border-2 border-orange-200 focus:border-orange-500 rounded-xl p-3 outline-none transition bg-white text-sm">
                                    </div>
                                    <div x-show="linkType === 'private'" x-collapse class="mt-4">
                                        <input type="text" placeholder="Masukkan Email yang diizinkan (pisahkan dengan koma)" class="w-full border-2 border-brand-200 focus:border-brand-500 rounded-xl p-3 outline-none transition bg-white text-sm">
                                        <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-circle-info"></i> Fitur ala Google Drive: Hanya email terdaftar yang bisa mengakses tautan ini.</p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800 shadow-md">Simpan Tautan</button>
                                </div>
                            </form>
                        </div>

                        <div class="space-y-5">
                            
                            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col sm:flex-row justify-between sm:items-center gap-4 group">
                                <div class="flex items-start gap-4">
                                    <div class="cursor-move text-gray-300 hover:text-gray-500 pt-1">
                                        <i class="fa-solid fa-grip-vertical text-xl"></i>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-2xl overflow-hidden">
                                        <i class="fa-brands fa-github text-gray-800"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg group-hover:text-brand-600 transition-colors">Portofolio GitHub</h4>
                                        <a href="#" class="text-gray-500 text-sm hover:underline"><i class="fa-solid fa-turn-up fa-rotate-90 text-xs"></i> https://github.com/andi</a>
                                        <div class="flex gap-2 mt-2">
                                            <span class="px-2.5 py-1 bg-green-50 text-green-600 text-xs font-bold rounded-lg"><i class="fa-solid fa-globe"></i> Publik</span>
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg"><i class="fa-solid fa-chart-simple"></i> 450 Klik</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                    </label>
                                    <button class="text-gray-400 hover:text-brand-600 p-2"><i class="fa-solid fa-pen"></i></button>
                                    <button class="text-gray-400 hover:text-red-600 p-2"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>

                            <div class="bg-white rounded-3xl p-5 shadow-sm border border-brand-100 bg-brand-50/30 hover:shadow-md transition-shadow flex flex-col sm:flex-row justify-between sm:items-center gap-4 group">
                                <div class="flex items-start gap-4">
                                    <div class="cursor-move text-gray-300 hover:text-gray-500 pt-1">
                                        <i class="fa-solid fa-grip-vertical text-xl"></i>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-white border border-brand-100 flex items-center justify-center text-2xl overflow-hidden shadow-sm">
                                        <i class="fa-brands fa-google-drive text-brand-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg group-hover:text-brand-600 transition-colors">Dokumen PBL (Laporan)</h4>
                                        <a href="#" class="text-gray-500 text-sm hover:underline"><i class="fa-solid fa-turn-up fa-rotate-90 text-xs"></i> https://docs.google.com/xyz...</a>
                                        <div class="flex gap-2 mt-2">
                                            <span class="px-2.5 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded-lg border border-brand-200"><i class="fa-solid fa-lock"></i> Private Email</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 bg-white px-2 py-1 border border-gray-100 rounded-md inline-block"><i class="fa-regular fa-envelope"></i> Akses: dosen_pbd@kampus.ac.id</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                    </label>
                                    <button class="text-gray-400 hover:text-brand-600 p-2"><i class="fa-solid fa-pen"></i></button>
                                    <button class="text-gray-400 hover:text-red-600 p-2"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div x-show="tab === 'appearance'" x-cloak x-transition.opacity.duration.300ms class="space-y-8">
                        
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 text-xl mb-6">Profil Identitas</h3>
                            <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                                <div class="relative">
                                    <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name=Andi+P&background=2563eb&color=fff' }}" alt="Profile" class="w-28 h-28 rounded-full border-4 border-white shadow-lg object-cover">
                                    <button class="absolute bottom-0 right-0 bg-gray-900 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-brand-600 transition border-2 border-white">
                                        <i class="fa-solid fa-camera text-xs"></i>
                                    </button>
                                </div>
                                <div class="flex-1 w-full space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Tampilan</label>
                                        <input type="text" value="{{ Auth::user()->name ?? 'Andi Pratama' }}" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-brand-500 outline-none font-bold text-gray-900">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Biodata Singkat</label>
                                        <textarea rows="2" class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-brand-500 outline-none text-gray-600 resize-none">{{ Auth::user()->bio ?? 'Mahasiswa TRPL Semester 2 | Web Dev Enthusiast' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 text-xl mb-6">Bentuk & Gaya Tombol</h3>
                            
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-3">Bentuk Tombol (Corner Style)</label>
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <button class="py-4 border-2 border-brand-500 bg-brand-50 flex justify-center items-center">
                                    <div class="w-16 h-4 bg-brand-600"></div> </button>
                                <button class="py-4 border-2 border-gray-200 hover:border-brand-300 rounded-xl flex justify-center items-center transition">
                                    <div class="w-16 h-4 bg-gray-300 rounded-md"></div> </button>
                                <button class="py-4 border-2 border-gray-200 hover:border-brand-300 rounded-xl flex justify-center items-center transition">
                                    <div class="w-16 h-4 bg-gray-300 rounded-full"></div> </button>
                            </div>

                            <label class="block text-xs font-bold text-gray-500 uppercase mb-3">Gaya Tampilan (Display Style)</label>
                            <div class="grid grid-cols-3 gap-4">
                                <button class="py-4 border-2 border-gray-200 hover:border-brand-300 rounded-xl flex justify-center items-center transition">
                                    <div class="w-20 h-6 bg-gray-800 rounded-md"></div> </button>
                                <button class="py-4 border-2 border-brand-500 bg-brand-50 rounded-xl flex justify-center items-center transition">
                                    <div class="w-20 h-6 border-2 border-brand-600 rounded-md"></div> </button>
                                <button class="py-4 border-2 border-gray-200 hover:border-brand-300 rounded-xl flex justify-center items-center transition">
                                    <div class="w-20 h-6 bg-white shadow-md border border-gray-100 rounded-md"></div> </button>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Warna Tombol</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" value="#2563eb" class="w-10 h-10 rounded cursor-pointer border-0 p-0">
                                        <span class="font-mono text-sm text-gray-600 border px-2 py-1 rounded bg-gray-50">#2563eb</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Warna Teks</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" value="#ffffff" class="w-10 h-10 rounded cursor-pointer border-0 p-0">
                                        <span class="font-mono text-sm text-gray-600 border px-2 py-1 rounded bg-gray-50">#ffffff</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div x-show="tab === 'analytics'" x-cloak x-transition.opacity.duration.300ms class="space-y-6">
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-900 rounded-3xl p-6 shadow-xl text-white">
                                <p class="text-gray-400 font-medium mb-1">Total Kunjungan Profil</p>
                                <h2 class="text-5xl font-black mb-2">1,240</h2>
                                <p class="text-sm text-green-400"><i class="fa-solid fa-arrow-trend-up"></i> +12% dari minggu lalu</p>
                            </div>
                            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                                <p class="text-gray-500 font-medium mb-1">Total Tautan Aktif</p>
                                <h2 class="text-5xl font-black text-brand-600 mb-2">8</h2>
                                <p class="text-sm text-gray-500">Tautan sehat dan berjalan</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 text-lg mb-6">Performa Link Tertinggi</h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm font-bold text-gray-700 mb-1">
                                        <span>Portofolio GitHub</span>
                                        <span>450 Klik</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-brand-500 h-3 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm font-bold text-gray-700 mb-1">
                                        <span>Instagram Personal</span>
                                        <span>320 Klik</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-brand-400 h-3 rounded-full" style="width: 60%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm font-bold text-gray-700 mb-1">
                                        <span>Dokumen PBL</span>
                                        <span>95 Klik</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-gray-400 h-3 rounded-full" style="width: 20%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div x-show="tab === 'settings'" x-cloak x-transition.opacity.duration.300ms class="space-y-6">
                        
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-red-100">
                            <h3 class="font-bold text-red-600 text-xl mb-2"><i class="fa-solid fa-shield-virus"></i> Keamanan Akun (Auto-Ban System)</h3>
                            <p class="text-gray-600 text-sm mb-6">Sistem mendeteksi tautan yang didaftarkan. Akun akan diblokir otomatis jika mencapai 3 poin pelanggaran (Phishing/Malware).</p>
                            
                            <div class="flex items-center gap-4 bg-red-50 p-4 rounded-2xl border border-red-100 mb-6">
                                <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl font-black">
                                    {{ Auth::user()->violation_count ?? '0' }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-red-900 text-lg">Poin Pelanggaran Kamu</h4>
                                    <p class="text-red-700 text-sm">Status Akun: <span class="bg-green-500 text-white px-2 py-0.5 rounded text-xs ml-1 uppercase">Aman</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email Terdaftar</label>
                                <input type="email" value="{{ Auth::user()->email ?? 'andi@trpl.kampus.ac.id' }}" disabled class="w-full border border-gray-200 bg-gray-50 rounded-xl p-3 text-gray-500 font-medium cursor-not-allowed">
                            </div>
                            <button class="text-brand-600 font-bold text-sm hover:underline">Ubah Kata Sandi (Reset Password)</button>
                        </div>

                    </div>

                </div>
            </div>
        </main>

        <aside class="w-[400px] bg-gray-50 border-l border-gray-200 hidden xl:flex items-center justify-center p-8 z-10 shadow-inner">
            
            <div class="relative w-[320px] h-[650px] border-[10px] border-gray-900 rounded-[3rem] shadow-2xl bg-white overflow-hidden flex flex-col">
                
                <div class="absolute top-0 inset-x-0 h-6 bg-gray-900 rounded-b-3xl w-40 mx-auto z-20"></div>

                <div class="flex-1 w-full h-full overflow-y-auto bg-gray-50 flex flex-col items-center pt-16 px-5 pb-10 scrollbar-hide">
                    
                    <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name=Andi+P&background=2563eb&color=fff' }}" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white shadow-md mb-4 object-cover">
                    
                    <h2 class="text-lg font-black text-gray-900">{{ Auth::user()->name ?? 'Andi Pratama' }}</h2>
                    <p class="text-sm text-gray-600 text-center mt-1 font-medium">{{ Auth::user()->bio ?? 'Mahasiswa TRPL Semester 2 | Web Dev Enthusiast' }}</p>

                    <div class="w-full space-y-4 mt-8">
                        
                        <a href="#" class="flex items-center justify-center w-full py-3.5 px-4 bg-transparent border-2 border-brand-600 text-brand-700 font-bold rounded-lg hover:bg-brand-50 transition transform hover:scale-105">
                            <i class="fa-brands fa-github text-xl absolute left-6"></i>
                            Portofolio GitHub
                        </a>

                        <a href="#" class="flex items-center justify-center w-full py-3.5 px-4 bg-transparent border-2 border-brand-600 text-brand-700 font-bold rounded-lg hover:bg-brand-50 transition transform hover:scale-105 opacity-80">
                            <i class="fa-solid fa-lock text-sm absolute left-6 text-gray-400"></i>
                            Dokumen PBL
                        </a>

                    </div>

                    <div class="mt-auto pt-10 pb-2">
                        <a href="#" class="text-xs font-black tracking-widest text-gray-400 hover:text-gray-600 transition">SMARTLINK BIO</a>
                    </div>

                </div>
            </div>

        </aside>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="flex items-center space-x-2 text-red-500 hover:text-red-700 font-bold transition-colors">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
    </button>
</form>
<p>Role saya saat ini adalah: {{ auth()->user()->role }}</p>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>