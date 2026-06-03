<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #334155; }
        .bg-dots { background-image: radial-gradient(#cbd5e1 0.8px, transparent 0.8px); background-size: 24px 24px; }
        .bg-aurora { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; overflow: hidden; background: linear-gradient(135deg, #f8fafc 0%, #f1f0ff 100%); }
        .circle-purple { position: absolute; top: -10%; right: -5%; width: 500px; height: 500px; background: rgba(139, 92, 246, 0.15); filter: blur(100px); border-radius: 50%; }
        .circle-blue { position: absolute; bottom: -10%; left: -5%; width: 600px; height: 600px; background: rgba(59, 130, 246, 0.12); filter: blur(100px); border-radius: 50%; }
        .nav-active { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: #ffffff !important; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2); }
        .card-elegant { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid #CBD5E1; border-radius: 1rem; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { background-color: #F8FAFC; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid #E2E8F0; }
        td { border-bottom: 1px solid #F1F5F9; padding: 14px 24px; }
        .modal-modern { border-radius: 1.5rem !important; border: none !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
        .input-modern { border-radius: 0.75rem !important; border: 1px solid #E2E8F0 !important; background-color: #F9FAFB; color: #1F2937; font-weight: 500; transition: all 0.2s ease; }
        .input-modern:focus { background-color: #fff; border-color: #6366f1 !important; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); outline: none; }
        .label-modern { color: #4B5563; font-weight: 600; font-size: 12px; margin-bottom: 6px; display: block; }
        .select-wrapper { position: relative; }
        .select-wrapper::after { content: '\f078'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 10px; color: #94a3b8; }
        @media (max-width: 1024px) { .sidebar-closed { transform: translateX(-100%); } .sidebar-open { transform: translateX(0); } }
        .custom-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .timeline-item::before { content: ''; position: absolute; left: 11px; top: 30px; bottom: -20px; width: 2px; background: #E2E8F0; }
        .timeline-item:last-child::before { display: none; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-dots" x-data="adminDashboard()">

    <script>
        function adminDashboard() {
            return {
                currentRoute: 'dashboard',
                showCreateModal: false,
                showEditModal: false,
                showUserMenu: false,
                sidebarOpen: false,
                searchQuery: '',
                statusFilter: 'all',
                userForm: { id: '', name: '', username: '', email: '', role: 'user' },
                pengguna: {!! json_encode($pengguna ?? []) !!},
                
                get filteredPengguna() {
                    return this.pengguna.filter(u => {
                        const search = this.searchQuery.toLowerCase();
                        const matchesSearch = (u.name || '').toLowerCase().includes(search) || 
                                              (u.email || '').toLowerCase().includes(search) || 
                                              (u.username || '').toLowerCase().includes(search);
                        const matchesStatus = this.statusFilter === 'all' ? true : (u.status || '').toUpperCase() === 'BANNED';
                        return matchesSearch && matchesStatus;
                    });
                },
                openEdit(user) {
                    this.userForm = {...user};
                    this.showEditModal = true;
                }
            }
        }
    </script>

    <div class="bg-aurora">
        <div class="circle-purple"></div>
        <div class="circle-blue"></div>
    </div>

    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 flex flex-col z-50 transition-transform duration-300 lg:relative lg:translate-x-0 shadow-xl lg:shadow-none"
           :class="sidebarOpen ? 'sidebar-open' : 'sidebar-closed'">
        
        <div class="h-16 flex items-center justify-center px-6 border-b border-slate-100">
            <img src="{{ asset('images/logo.png') }}" alt="SmartLink Logo" class="h-8 w-auto">
        </div>

        <div class="p-4 border-b border-slate-100">
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md">
                    AU
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Admin</p>
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Admin Utama' }}</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <button @click="currentRoute = 'dashboard'; sidebarOpen = false" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all" :class="currentRoute === 'dashboard' ? 'nav-active' : 'text-slate-500 hover:bg-slate-50'">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
            </button>
            <button @click="currentRoute = 'pengguna'; sidebarOpen = false" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all" :class="currentRoute === 'pengguna' ? 'nav-active' : 'text-slate-500 hover:bg-slate-50'">
                <i class="fa-solid fa-users w-5 text-center"></i> Manajemen Pengguna
            </button>
        </nav>
        <div class="p-6 border-t border-slate-100 text-center">
           <p class="text-[10px] font-black text-slate-400 tracking-[0.2em]">&copy; 2026 SmartLink.</p>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40 lg:hidden" style="display: none;"></div>

    <main class="flex-1 flex flex-col min-w-0 bg-transparent overflow-hidden">
        
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between lg:justify-end px-6 lg:px-10 z-30 sticky top-0 shrink-0">
            <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <button @click="showUserMenu = !showUserMenu" @click.away="showUserMenu = false" class="flex items-center gap-2 cursor-pointer group">
                        <div class="w-9 h-9 bg-indigo-50 border-2 border-indigo-100 rounded-full flex items-center justify-center text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                            <i class="fa-solid fa-user-tie text-sm"></i>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div x-show="showUserMenu" style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-3 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 py-2 overflow-hidden">
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-rose-600 font-bold hover:bg-rose-50 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-power-off w-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 lg:p-10 custom-scroll relative">
            <div class="max-w-7xl mx-auto space-y-8">
                
                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                <template x-if="currentRoute === 'dashboard'">
                    <div class="space-y-8 animate-in fade-in">
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Ringkasan Sistem</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="card-elegant p-6 border-l-4 border-l-emerald-500 shadow-sm relative overflow-hidden group">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-2"><i class="fa-solid fa-user-check"></i> Pengguna Aktif</p>
                                    <h3 class="text-4xl font-black text-slate-900 mt-2" 
                                        x-text="pengguna.filter(u => (u.status || '').toUpperCase() === 'ACTIVE').length">
                                    </h3>
                                </div>
                            </div>

                            <div class="card-elegant p-6 border-l-4 border-l-rose-500 shadow-sm relative overflow-hidden group">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-2"><i class="fa-solid fa-user-slash"></i> Diblokir</p>
                                    <h3 class="text-4xl font-black text-slate-900 mt-2" 
                                        x-text="pengguna.filter(u => (u.status || '').toUpperCase() === 'BANNED').length">
                                    </h3>
                                </div>
                            </div>

                            <div class="card-elegant p-6 border-l-4 border-l-indigo-500 shadow-sm relative overflow-hidden group">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-2"><i class="fa-solid fa-link"></i> Total Tautan</p>
                                    <h3 class="text-4xl font-black text-slate-900 mt-2" 
                                        x-text="pengguna.filter(u => u.role !== 'admin').reduce((total, u) => total + (parseInt(u.links_count) || 0), 0)">
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="currentRoute === 'pengguna'">
                    <div class="space-y-6 animate-in fade-in">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h2 class="text-2xl font-extrabold text-slate-900 uppercase">Data Pengguna</h2>
                            <button @click="showCreateModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2 transform active:scale-95"><i class="fa-solid fa-plus text-xs"></i> Tambah Pengguna</button>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <div class="relative flex-1 w-full max-w-md">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" x-model="searchQuery" placeholder="Cari nama, username..." class="input-modern w-full pl-10 pr-5 py-3 text-sm shadow-sm bg-white">
                            </div>
                            <div class="flex p-1 bg-white border border-slate-200 rounded-2xl shadow-sm w-full md:w-auto">
                                <button @click="statusFilter = 'all'" :class="statusFilter === 'all' ? 'bg-slate-100 text-indigo-600' : 'text-slate-500 hover:text-slate-700'" class="flex-1 md:flex-none px-6 py-2 rounded-xl text-[11px] font-black uppercase transition-all">Semua</button>
                                <button @click="statusFilter = 'banned'" :class="statusFilter === 'banned' ? 'bg-slate-100 text-indigo-600' : 'text-slate-500 hover:text-slate-700'" class="flex-1 md:flex-none px-6 py-2 rounded-xl text-[11px] font-black uppercase transition-all">Diblokir</button>
                            </div>
                        </div>

                        <div class="card-elegant overflow-hidden shadow-sm flex flex-col">
                            <div class="overflow-x-auto custom-scroll">
                                <table class="text-left w-full whitespace-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-4">Detail Pengguna</th>
                                            <th class="px-6 py-4">Username</th>
                                            <th class="px-6 py-4 text-center">Status</th>
                                            <th class="px-6 py-4 text-center">Total Link</th>
                                            <th class="px-6 py-4">Peran</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        <template x-for="user in filteredPengguna" :key="user.id">
                                            <tr class="hover:bg-slate-50/80 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm border border-slate-100"
                                                             :class="user.role === 'admin' ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-600'"
                                                             x-text="user.name.charAt(0)">
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span class="font-bold text-slate-900 text-[14px]" x-text="user.name"></span>
                                                            <span class="text-[12px] text-slate-400 font-medium" x-text="user.email"></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-[13px] text-slate-600 font-semibold font-mono bg-slate-100 px-2 py-1 rounded border border-slate-200">@<span x-text="user.username"></span></span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase border" 
                                                          :class="(user.status || '').trim().toUpperCase() === 'ACTIVE' 
                                                                  ? 'bg-emerald-50 text-emerald-600 border-emerald-100' 
                                                                  : 'bg-rose-50 text-rose-600 border-rose-100'" 
                                                          x-text="(user.status || '').trim().toUpperCase() === 'ACTIVE' ? 'Active' : 'Banned'">
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200" 
                                                          x-text="(user.links_count ?? 0) + ' Link'"></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase border" :class="user.role === 'admin' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-slate-50 text-slate-500 border-slate-200'" x-text="user.role"></span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <button @click="openEdit(user)" class="text-[11px] font-black text-indigo-600 uppercase hover:text-indigo-800 transition-colors bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100"><i class="fa-solid fa-pen mr-1"></i> Edit</button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </main>

    <div x-show="showCreateModal" style="display: none;" x-transition.opacity class="fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="showCreateModal = false" class="bg-white w-full max-w-lg modal-modern animate-in zoom-in duration-200 overflow-hidden">
            <form action="{{ url('/admin/users') }}" method="POST">
                @csrf
                <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="font-extrabold text-xl text-slate-900 tracking-tight">Tambah Pengguna</h3>
                        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Akses Portal SmartLink</p>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <div class="p-6 md:p-8 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div><label class="label-modern">Nama Lengkap</label><input type="text" name="name" required placeholder="Misal: Budi" class="input-modern w-full px-4 py-3 text-sm"></div>
                        <div><label class="label-modern">Username</label><input type="text" name="username" required placeholder="Misal: budi_99" class="input-modern w-full px-4 py-3 text-sm"></div>
                    </div>
                    <div><label class="label-modern">Alamat Email</label><input type="email" name="email" required placeholder="budi@kampus.id" class="input-modern w-full px-4 py-3 text-sm"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="label-modern">Peran (Role)</label>
                            <div class="select-wrapper">
                                <select name="role" required class="input-modern w-full px-4 py-3 text-sm appearance-none cursor-pointer">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div><label class="label-modern">Password Awal</label><input type="password" name="password" required placeholder="Rahasia..." class="input-modern w-full px-4 py-3 text-sm"></div>
                    </div>
                </div>
                <div class="px-6 py-5 md:px-8 md:py-6 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-4">
                    <button type="button" @click="showCreateModal = false" class="text-xs font-bold text-slate-500 uppercase hover:text-slate-900">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 md:px-8 rounded-xl font-bold text-xs uppercase shadow-lg hover:bg-indigo-700 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showEditModal" style="display: none;" x-transition.opacity class="fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="showEditModal = false" class="bg-white w-full max-w-lg modal-modern animate-in zoom-in duration-200 overflow-hidden">
            <form :action="'{{ url('/admin/users') }}/' + userForm.id" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="font-extrabold text-xl text-slate-900 tracking-tight">Edit Profil</h3>
                        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Mengubah: <span class="text-indigo-600" x-text="userForm.name"></span></p>
                    </div>
                    <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <div class="p-6 md:p-8 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div><label class="label-modern">Nama Lengkap</label><input type="text" name="name" required x-model="userForm.name" class="input-modern w-full px-4 py-3 text-sm"></div>
                        <div><label class="label-modern">Username</label><input type="text" name="username" required x-model="userForm.username" class="input-modern w-full px-4 py-3 text-sm"></div>
                    </div>
                    <div><label class="label-modern">Alamat Email</label><input type="email" name="email" required x-model="userForm.email" class="input-modern w-full px-4 py-3 text-sm"></div>
                    <div>
                        <label class="label-modern">Peran (Role)</label>
                        <div class="select-wrapper">
                            <select name="role" required x-model="userForm.role" class="input-modern w-full px-4 py-3 text-sm appearance-none cursor-pointer">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5 md:px-8 md:py-6 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-4">
                    <button type="button" @click="showEditModal = false" class="text-xs font-bold text-slate-500 uppercase hover:text-slate-900">Batal</button>
                    <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 md:px-8 rounded-xl font-bold text-xs uppercase shadow-lg hover:bg-black transition-all">Update Profil</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>