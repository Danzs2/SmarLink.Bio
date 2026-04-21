<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SmartLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; color: #111827; }
        
        /* Toggle Switch Custom */
        .toggle-checkbox:checked { right: 0; border-color: #10B981; }
        .toggle-checkbox:checked + .toggle-label { background-color: #10B981; }
        
        /* Smooth Input */
        .admin-input {
            width: 100%; padding: 12px 16px; background-color: #F3F4F6; 
            border: 2px solid transparent; border-radius: 12px; font-size: 14px;
            transition: all 0.2s ease; outline: none; color: #111827;
        }
        .admin-input:focus { border-color: #6366F1; background-color: #FFFFFF; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        
        /* Card Shadow */
        .admin-card { background: #FFFFFF; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #E5E7EB; }
    </style>
</head>
<body class="h-screen overflow-hidden flex flex-col" 
    x-data="{ 
        activeTab: 'links', 
        
        // Data Profil (Ganti src logo di bawah nanti)
        profile: { 
            title: '@daniel_tech', 
            bio: 'Mahasiswa TRPL - Software Engineering',
            logoPreview: null // Tempat nyimpen preview gambar kalau diupload
        },

        // Pilihan Desain yang Diperbanyak
        design: {
            bgType: 'flat', // flat, gradient
            bgColor1: '#F3F4F6',
            bgColor2: '#E5E7EB',
            fontFamily: 'Inter',
            fontColor: '#111827',
            btnShape: 'rounded-full', // rounded-none, rounded-xl, rounded-full
            btnStyle: 'fill', // fill, outline, shadow
            btnColor: '#6366F1',
            btnTextColor: '#FFFFFF'
        },

        // Database Link
        links: [
            { id: 1, title: 'Portfolio Project Laravel', url: 'https://github.com/danzz', active: true, clicks: 125, isLocked: false, password: '' },
            { id: 2, title: 'Materi Kuliah Semester 2', url: 'https://drive.google.com', active: true, clicks: 42, isLocked: true, password: 'rahasiaadmin' }
        ],

        // Fungsi Tambah Link
        addLink() {
            this.links.unshift({ 
                id: Date.now(), 
                title: '', 
                url: '', 
                active: true, 
                clicks: 0, 
                isLocked: false, 
                password: '' 
            });
        },

        // Fungsi Hapus Link
        removeLink(id) { 
            this.links = this.links.filter(l => l.id !== id); 
        },

        // Fungsi Preview Logo Upload
        handleLogoUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.profile.logoPreview = URL.createObjectURL(file);
            }
        }
    }">

    <header class="bg-white h-[72px] border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0 z-50 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md"><i class="fa-solid fa-link"></i></div>
            <span class="font-extrabold text-xl tracking-tight text-gray-900 hidden md:block">SmartLink Admin</span>
        </div>

        <nav class="flex space-x-2 bg-gray-100 p-1 rounded-xl">
            <button @click="activeTab = 'links'" class="px-6 py-2 rounded-lg font-bold text-sm transition-all" :class="activeTab === 'links' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-900'">
                <i class="fa-solid fa-list-ul mr-2"></i> Links
            </button>
            <button @click="activeTab = 'design'" class="px-6 py-2 rounded-lg font-bold text-sm transition-all" :class="activeTab === 'design' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-900'">
                <i class="fa-solid fa-palette mr-2"></i> Design
            </button>
            <button @click="activeTab = 'analytics'" class="px-6 py-2 rounded-lg font-bold text-sm transition-all" :class="activeTab === 'analytics' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-900'">
                <i class="fa-solid fa-chart-line mr-2"></i> Analytics
            </button>
        </nav>

        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center bg-gray-50 rounded-full pl-5 pr-2 py-1.5 gap-3 border border-gray-200">
                <span class="text-sm font-semibold text-gray-600">smartlink.id/daniel</span>
                <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-200 hover:bg-gray-100 text-indigo-600"><i class="fa-solid fa-share-nodes text-xs"></i></button>
            </div>
            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border-2 border-gray-300">
                <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin" class="w-full h-full object-cover">
            </div>
        </div>
    </header>

    <main class="flex-1 h-full overflow-y-auto p-6 md:p-10 flex justify-center custom-scroll">
        
        <div class="w-full max-w-[800px]">

            <template x-if="activeTab === 'links'">
                <div class="space-y-6 animate-in fade-in duration-300 pb-20">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-extrabold text-gray-900">Manajemen Tautan</h1>
                        <button class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 flex items-center gap-2">
                            <i class="fa-regular fa-folder-open"></i> Kategori Baru
                        </button>
                    </div>

                    <button @click="addLink()" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-base transition-all shadow-lg hover:shadow-indigo-500/30 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-plus"></i> Tambah Tautan Baru
                    </button>

                    <div class="space-y-5 mt-8">
                        <template x-for="(link, index) in links" :key="link.id">
                            <div class="admin-card overflow-hidden transition-all hover:border-indigo-300">
                                
                                <div class="flex p-6 gap-4">
                                    <div class="pt-3 text-gray-300 hover:text-gray-500 cursor-grab">
                                        <i class="fa-solid fa-grip-vertical text-lg"></i>
                                    </div>
                                    
                                    <div class="flex-1 space-y-3">
                                        <div>
                                            <input type="text" x-model="link.title" class="admin-input font-bold text-gray-900" placeholder="Judul Tautan (Contoh: Instagram Saya)">
                                        </div>
                                        <div class="flex items-center">
                                            <div class="bg-gray-100 border-y border-l border-gray-200 px-4 py-3 rounded-l-xl text-gray-500 text-sm"><i class="fa-solid fa-link"></i></div>
                                            <input type="url" x-model="link.url" class="admin-input rounded-l-none border-l-0" placeholder="https://url-tujuan.com">
                                        </div>
                                    </div>
                                    
                                    <div class="pt-3 flex flex-col items-center gap-4">
                                        <div class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                                            <input type="checkbox" x-model="link.active" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer transition-transform duration-200 ease-in-out z-10" style="top: 2px; left: 2px;" :class="link.active ? 'translate-x-[24px] border-emerald-500' : ''"/>
                                            <label class="toggle-label block overflow-hidden h-[28px] rounded-full bg-gray-200 cursor-pointer transition-colors duration-200 ease-in-out" :class="link.active ? 'bg-emerald-500' : ''"></label>
                                        </div>
                                        <button @click="removeLink(link.id)" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center" title="Hapus Link">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    
                                    <div class="flex items-center gap-2">
                                        <button @click="link.isLocked = !link.isLocked" class="px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 transition-colors" :class="link.isLocked ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-100'">
                                            <i class="fa-solid fa-lock"></i> Kunci Password
                                        </button>
                                        
                                        <div class="ml-4 flex items-center gap-2 text-sm font-semibold text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200">
                                            <i class="fa-solid fa-chart-simple text-indigo-500"></i>
                                            <span x-text="link.clicks + ' Klik'"></span>
                                        </div>
                                    </div>

                                    <div x-show="link.isLocked" x-transition class="w-full sm:w-auto flex-1 max-w-xs flex items-center">
                                        <div class="bg-indigo-50 border-y border-l border-indigo-200 px-3 py-2 rounded-l-lg text-indigo-500 text-xs font-bold">Password:</div>
                                        <input type="text" x-model="link.password" placeholder="Masukkan sandi..." class="w-full px-3 py-2 border-y border-r border-indigo-200 rounded-r-lg outline-none text-sm font-semibold focus:border-indigo-500">
                                    </div>
                                </div>

                            </div>
                        </template>

                        <div x-show="links.length === 0" class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl"><i class="fa-solid fa-link-slash"></i></div>
                            <h3 class="font-bold text-xl text-gray-800">Belum ada tautan</h3>
                            <p class="text-gray-500 mt-2 text-sm">Klik tombol di atas untuk menambahkan tautan pertama Anda.</p>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'design'">
                <div class="space-y-8 animate-in fade-in duration-300 pb-20">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Kustomisasi Desain</h1>

                    <div class="admin-card p-8">
                        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">Profil & Logo Anda</h2>
                        
                        <div class="flex flex-col sm:flex-row gap-8 items-start">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-32 h-32 rounded-full border-4 border-gray-100 overflow-hidden bg-gray-50 flex items-center justify-center relative group">
                                    <template x-if="profile.logoPreview">
                                        <img :src="profile.logoPreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!profile.logoPreview">
                                        <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                                    </template>
                                    
                                    <label class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center cursor-pointer transition-all">
                                        <span class="text-white text-xs font-bold uppercase"><i class="fa-solid fa-upload mb-1 block"></i> Upload Logo</span>
                                        <input type="file" accept="image/*" class="hidden" @change="handleLogoUpload">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 font-medium">Format: JPG, PNG (Max 2MB)</p>
                            </div>

                            <div class="flex-1 w-full space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Halaman (Page Title)</label>
                                    <input type="text" x-model="profile.title" class="admin-input" placeholder="Nama Brand / Profil Anda">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Bio Singkat</label>
                                    <textarea x-model="profile.bio" class="admin-input h-24 resize-none" placeholder="Tuliskan deskripsi singkat..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card p-8">
                        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">Latar Belakang (Background)</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Tipe Background</label>
                                <div class="flex gap-4">
                                    <button @click="design.bgType = 'flat'" class="px-6 py-3 rounded-xl border-2 font-bold text-sm transition-all" :class="design.bgType === 'flat' ? 'border-indigo-600 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'">Warna Solid</button>
                                    <button @click="design.bgType = 'gradient'" class="px-6 py-3 rounded-xl border-2 font-bold text-sm transition-all" :class="design.bgType === 'gradient' ? 'border-indigo-600 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'">Gradasi (Gradient)</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Warna Utama</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" x-model="design.bgColor1" class="w-12 h-12 rounded cursor-pointer border border-gray-200 p-1 bg-white">
                                        <input type="text" x-model="design.bgColor1" class="admin-input uppercase font-mono text-center w-32">
                                    </div>
                                </div>
                                <div x-show="design.bgType === 'gradient'">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Warna Gradasi Kedua</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" x-model="design.bgColor2" class="w-12 h-12 rounded cursor-pointer border border-gray-200 p-1 bg-white">
                                        <input type="text" x-model="design.bgColor2" class="admin-input uppercase font-mono text-center w-32">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card p-8">
                        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">Gaya Tombol (Buttons)</h2>
                        
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Bentuk Sudut</label>
                                <div class="grid grid-cols-3 gap-4">
                                    <button @click="design.btnShape = 'rounded-none'" class="h-14 bg-gray-900 text-white rounded-none font-bold text-xs" :class="design.btnShape === 'rounded-none' ? 'ring-4 ring-indigo-500 ring-offset-2' : ''">Kotak Tajam</button>
                                    <button @click="design.btnShape = 'rounded-xl'" class="h-14 bg-gray-900 text-white rounded-xl font-bold text-xs" :class="design.btnShape === 'rounded-xl' ? 'ring-4 ring-indigo-500 ring-offset-2' : ''">Sedikit Melengkung</button>
                                    <button @click="design.btnShape = 'rounded-full'" class="h-14 bg-gray-900 text-white rounded-full font-bold text-xs" :class="design.btnShape === 'rounded-full' ? 'ring-4 ring-indigo-500 ring-offset-2' : ''">Bulat Kapsul</button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Gaya Tampilan</label>
                                <div class="grid grid-cols-3 gap-4">
                                    <button @click="design.btnStyle = 'fill'" class="h-14 bg-indigo-600 text-white rounded-lg font-bold text-xs" :class="design.btnStyle === 'fill' ? 'ring-4 ring-indigo-500 ring-offset-2' : ''">Warna Penuh</button>
                                    <button @click="design.btnStyle = 'outline'" class="h-14 bg-white border-2 border-indigo-600 text-indigo-600 rounded-lg font-bold text-xs" :class="design.btnStyle === 'outline' ? 'ring-4 ring-indigo-500 ring-offset-2' : ''">Garis Tepi</button>
                                    <button @click="design.btnStyle = 'shadow'" class="h-14 bg-white border-2 border-gray-900 shadow-[4px_4px_0px_0px_rgba(17,24,39,1)] text-gray-900 rounded-lg font-bold text-xs" :class="design.btnStyle === 'shadow' ? 'ring-4 ring-indigo-500 ring-offset-2' : ''">Hard Shadow</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Warna Background Tombol</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" x-model="design.btnColor" class="w-12 h-12 rounded cursor-pointer border border-gray-200 p-1 bg-white">
                                        <input type="text" x-model="design.btnColor" class="admin-input uppercase font-mono text-center w-32">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Warna Teks Tombol / Profil</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" x-model="design.btnTextColor" class="w-12 h-12 rounded cursor-pointer border border-gray-200 p-1 bg-white">
                                        <input type="text" x-model="design.btnTextColor" class="admin-input uppercase font-mono text-center w-32">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button class="px-8 py-4 bg-gray-900 text-white rounded-xl font-bold hover:bg-black shadow-lg transition-all flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Desain
                        </button>
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'analytics'">
                <div class="space-y-6 animate-in fade-in duration-300 pb-20">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-extrabold text-gray-900">Analitik Pengunjung</h1>
                        <select class="admin-input w-auto font-bold cursor-pointer">
                            <option>Semua Waktu</option>
                            <option>30 Hari Terakhir</option>
                            <option>7 Hari Terakhir</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="admin-card p-8 border-t-4 border-t-blue-500">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4"><i class="fa-solid fa-eye"></i></div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Total Views</p>
                            <h3 class="text-4xl font-black text-gray-900">1,250</h3>
                        </div>
                        <div class="admin-card p-8 border-t-4 border-t-emerald-500">
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4"><i class="fa-solid fa-hand-pointer"></i></div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Total Clicks</p>
                            <h3 class="text-4xl font-black text-gray-900" x-text="links.reduce((sum, link) => sum + link.clicks, 0)"></h3>
                        </div>
                        <div class="admin-card p-8 border-t-4 border-t-purple-500">
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl mb-4"><i class="fa-solid fa-percent"></i></div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Click-Through Rate</p>
                            <h3 class="text-4xl font-black text-gray-900" x-text="Math.round((links.reduce((sum, link) => sum + link.clicks, 0) / 1250) * 100) + '%'"></h3>
                        </div>
                    </div>
                    
                    <div class="admin-card p-8 min-h-[400px] flex flex-col items-center justify-center mt-8">
                        <i class="fa-solid fa-chart-area text-6xl text-gray-200 mb-4"></i>
                        <h3 class="text-lg font-bold text-gray-700">Grafik Aktivitas</h3>
                        <p class="text-sm text-gray-500 mt-2 text-center max-w-sm">Integrasikan dengan pustaka seperti Chart.js atau ApexCharts di backend Laravel Anda untuk menampilkan data historis.</p>
                    </div>
                </div>
            </template>

        </div>
    </main>
</body>
</html>