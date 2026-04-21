<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SmartLink | Management Pro Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #334155; }
        
        .bg-dots {
            background-image: radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }

        /* Aurora Gradient Background */
        .bg-aurora {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f0ff 100%);
        }
        .circle-purple { position: absolute; top: -10%; right: -5%; width: 500px; height: 500px; background: rgba(139, 92, 246, 0.15); filter: blur(100px); border-radius: 50%; }
        .circle-blue { position: absolute; bottom: -10%; left: -5%; width: 600px; height: 600px; background: rgba(59, 130, 246, 0.12); filter: blur(100px); border-radius: 50%; }

        .nav-active { 
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); 
            color: #ffffff !important; 
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .card-elegant { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px);
            border: 1px solid #CBD5E1; 
            border-radius: 1rem; 
        }

        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th { background-color: #F8FAFC; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid #E2E8F0; }
        td { border-bottom: 1px solid #F1F5F9; padding: 14px 24px; }

        /* Modern Form Styling */
        .modal-modern { border-radius: 1.5rem !important; border: none !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
        .input-modern {
            border-radius: 0.75rem !important;
            border: 1px solid #E2E8F0 !important;
            background-color: #F9FAFB;
            color: #1F2937;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .input-modern:focus { 
            background-color: #fff; 
            border-color: #6366f1 !important; 
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); 
            outline: none;
        }
        .label-modern { color: #4B5563; font-weight: 600; font-size: 12px; margin-bottom: 6px; display: block; }

        .select-wrapper { position: relative; }
        .select-wrapper::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute; right: 15px; top: 50%;
            transform: translateY(-50%);
            pointer-events: none; font-size: 10px; color: #94a3b8;
        }

        @media (max-width: 1024px) {
            .sidebar-closed { transform: translateX(-100%); }
            .sidebar-open { transform: translateX(0); }
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-dots" x-data="{ 
    currentRoute: 'dashboard',
    showCreateModal: false,
    showEditModal: false,
    showUserMenu: false,
    sidebarOpen: false,
    searchQuery: '',
    statusFilter: 'all',
    userForm: { name: '', email: '', role: 'User' },
    users: [
        { id: 1, name: 'Zhao', email: 'zhao@smartlink.id', role: 'USER', status: 'ACTIVE' },
        { id: 2, name: 'Daniel Tech', email: 'daniel@smartlink.id', role: 'ADMIN', status: 'ACTIVE' },
        { id: 3, name: 'Saeed Example', email: 'saeed@example.com', role: 'USER', status: 'ACTIVE' },
        { id: 4, name: 'Kevin Bryan', email: 'kevin@ibio.test', role: 'ADMIN', status: 'ACTIVE' },
        { id: 5, name: 'Banned User 1', email: 'toxic@spammer.com', role: 'USER', status: 'BANNED' },
        { id: 6, name: 'Banned User 2', email: 'bot@system.com', role: 'USER', status: 'BANNED' }
    ],
    get filteredUsers() {
        return this.users.filter(u => {
            const matchesSearch = u.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || u.email.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesStatus = this.statusFilter === 'all' ? true : u.status === 'BANNED';
            return matchesSearch && matchesStatus;
        });
    },
    toggleBan(user) { user.status = user.status === 'ACTIVE' ? 'BANNED' : 'ACTIVE'; },
    openEdit(user) {
        this.userForm = {...user};
        this.showEditModal = true;
    }
}">

    <div class="bg-aurora">
        <div class="circle-purple"></div>
        <div class="circle-blue"></div>
    </div>

    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 flex flex-col z-50 transition-transform duration-300 lg:relative lg:translate-x-0 shadow-xl lg:shadow-none"
           :class="sidebarOpen ? 'sidebar-open' : 'sidebar-closed'">
        
        <div class="h-16 flex items-center justify-center px-6 border-b border-slate-100">
            <img src="/images/logo.png" alt="SmartLink" class="h-8 w-auto">
        </div>

        <nav class="flex-1 p-4 space-y-2 mt-4">
            <button @click="currentRoute = 'dashboard'; sidebarOpen = false" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all" :class="currentRoute === 'dashboard' ? 'nav-active' : 'text-slate-500 hover:bg-slate-50'">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
            </button>
            <button @click="currentRoute = 'users'; sidebarOpen = false" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all" :class="currentRoute === 'users' ? 'nav-active' : 'text-slate-500 hover:bg-slate-50'">
                <i class="fa-solid fa-users w-5 text-center"></i> User Management
            </button>
        </nav>
        <div class="p-6 border-t border-slate-100 text-center">
           <p class="text-[10px] font-black text-slate-350 tracking-[0.3em]">&copy; 2026 SmartLink. All rights reserved.
</p>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40 lg:hidden"></div>

    <main class="flex-1 flex flex-col min-w-0 bg-transparent">
        
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between lg:justify-end px-6 lg:px-10 z-30 sticky top-0">
            <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>

            <div class="relative">
                <button @click="showUserMenu = !showUserMenu" @click.away="showUserMenu = false" class="w-9 h-9 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-200 transition-colors">
                    <i class="fa-solid fa-user text-lg"></i>
                </button>

                <div x-show="showUserMenu" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute right-0 mt-3 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 py-2 overflow-hidden">
                    <div class="px-4 py-2 border-b border-slate-50">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Administrator</p>
                        <p class="text-sm font-bold text-slate-900 truncate">Admin SmartLink</p>
                    </div>
                    <button @click="alert('Berhasil Logout!'); window.location.reload();" class="w-full text-left px-4 py-3 text-sm text-red-600 font-bold hover:bg-red-50 transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-power-off"></i> Logout
                    </button>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 lg:p-10 custom-scroll">
            <div class="max-w-6xl mx-auto space-y-8">

                <template x-if="currentRoute === 'dashboard'">
                    <div class="space-y-8 animate-in fade-in">
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Overview</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="card-elegant p-6 border-l-4 border-l-emerald-500 shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Active Users</p>
                                <h3 class="text-4xl font-black text-slate-900" x-text="users.filter(u => u.status === 'ACTIVE').length"></h3>
                            </div>
                            <div class="card-elegant p-6 border-l-4 border-l-rose-500 shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Banned</p>
                                <h3 class="text-4xl font-black text-slate-900" x-text="users.filter(u => u.status === 'BANNED').length"></h3>
                            </div>
                            <div class="card-elegant p-6 border-l-4 border-l-indigo-500 shadow-sm">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Links</p>
                                <h3 class="text-4xl font-black text-slate-900">8,432</h3>
                            </div>
                        </div>

                        <div class="card-elegant overflow-hidden shadow-sm">
                            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white/50">
                                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 bg-indigo-500 rounded-full shadow-[0_0_8px_rgba(99,102,241,0.8)]"></span> Platform Insights
                                </h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Apr 2026</span>
                            </div>
                            <div class="p-8">
                                <div class="h-64 relative">
                                    <svg viewBox="0 0 400 100" class="w-full h-full overflow-visible">
                                        <defs>
                                            <linearGradient id="lineGrad" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#6366f1" stop-opacity="0.2" /><stop offset="100%" stop-color="#6366f1" stop-opacity="0" /></linearGradient>
                                        </defs>
                                        <path d="M0,80 C50,85 100,60 150,70 S250,30 350,50 L400,20 V100 H0 Z" fill="url(#lineGrad)" />
                                        <path d="M0,80 C50,85 100,60 150,70 S250,30 350,50 L400,20" fill="none" stroke="#6366f1" stroke-width="3" stroke-linecap="round" />
                                        <circle cx="400" cy="20" r="4" fill="white" stroke="#6366f1" stroke-width="2" class="animate-pulse" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="currentRoute === 'users'">
                    <div class="space-y-6 animate-in fade-in">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h2 class="text-2xl font-extrabold text-slate-900 uppercase">User Management</h2>
                            <button @click="showCreateModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all flex items-center justify-center gap-2"><i class="fa-solid fa-plus text-xs"></i> Create User</button>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <input type="text" x-model="searchQuery" placeholder="Search by name or email..." class="input-pro flex-1 max-w-md px-5 py-3 text-sm font-medium shadow-sm bg-white">
                            <div class="flex p-1 bg-white border border-slate-200 rounded-2xl shadow-sm">
                                <button @click="statusFilter = 'all'" :class="statusFilter === 'all' ? 'bg-slate-100 text-indigo-600' : 'text-slate-500'" class="px-6 py-2 rounded-xl text-[11px] font-black uppercase transition-all">All</button>
                                <button @click="statusFilter = 'banned'" :class="statusFilter === 'banned' ? 'bg-slate-100 text-indigo-600' : 'text-slate-500'" class="px-6 py-2 rounded-xl text-[11px] font-black uppercase transition-all">Banned</button>
                            </div>
                        </div>

                        <div class="card-elegant overflow-hidden shadow-sm">
                            <div class="overflow-x-auto custom-scroll">
                                <table class="text-left w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-8 py-4">User Details</th>
                                            <th class="px-8 py-4">Role</th>
                                            <th class="px-8 py-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        <template x-for="user in filteredUsers" :key="user.id">
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-8 py-5">
                                                    <div class="flex flex-col">
                                                        <span class="font-bold text-slate-900 text-[14px]" x-text="user.name"></span>
                                                        <span class="text-[12px] text-slate-400 font-medium" x-text="user.email"></span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase border" :class="user.role === 'ADMIN' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-slate-50 text-slate-500 border-slate-200'" x-text="user.role"></span>
                                                </td>
                                                <td class="px-8 py-5 text-right">
                                                    <div class="flex items-center justify-end gap-4">
                                                        <button @click="openEdit(user)" class="text-[11px] font-black text-indigo-600 uppercase hover:underline">Edit</button>
                                                        <button @click="toggleBan(user)" class="text-[11px] font-black uppercase transition-colors" :class="user.status === 'ACTIVE' ? 'text-rose-500 hover:text-rose-700' : 'text-emerald-500 hover:text-emerald-700'" x-text="user.status === 'ACTIVE' ? 'Ban' : 'Unban'"></button>
                                                    </div>
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

    <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="showCreateModal = false" class="bg-white w-full max-w-lg modal-modern animate-in zoom-in duration-200 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="font-extrabold text-xl text-slate-900 tracking-tight">Create User</h3>
                    <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Management Portal Access</p>
                </div>
                <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-8 space-y-5">
                <div><label class="label-modern">Full Name</label><input type="text" placeholder="e.g. Zhao" class="input-modern w-full px-4 py-3 text-sm"></div>
                <div><label class="label-modern">Email Address</label><input type="email" placeholder="user@example.com" class="input-modern w-full px-4 py-3 text-sm"></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="label-modern">Assign Role</label>
                        <div class="select-wrapper"><select class="input-modern w-full px-4 py-3 text-sm appearance-none cursor-pointer"><option>User</option><option>Admin</option></select></div>
                    </div>
                    <div><label class="label-modern">Initial Password</label><input type="password" class="input-modern w-full px-4 py-3 text-sm"></div>
                </div>
            </div>
            <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-4">
                <button @click="showCreateModal = false" class="text-xs font-bold text-slate-500 uppercase hover:text-slate-900">Cancel</button>
                <button @click="showCreateModal = false" class="bg-indigo-600 text-white px-8 py-2.5 rounded-xl font-bold text-xs uppercase shadow-lg hover:bg-indigo-700 transition-all">Save Member</button>
            </div>
        </div>
    </div>

    <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="showEditModal = false" class="bg-white w-full max-w-lg modal-modern animate-in zoom-in duration-200 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="font-extrabold text-xl text-slate-900 tracking-tight">Edit Profile</h3>
                    <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Updating: <span class="text-indigo-600" x-text="userForm.name"></span></p>
                </div>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-8 space-y-5">
                <div><label class="label-modern">Full Name</label><input type="text" x-model="userForm.name" class="input-modern w-full px-4 py-3 text-sm"></div>
                <div><label class="label-modern">Email Address</label><input type="email" x-model="userForm.email" class="input-modern w-full px-4 py-3 text-sm"></div>
                <div>
                    <label class="label-modern">Assign Role</label>
                    <div class="select-wrapper"><select x-model="userForm.role" class="input-modern w-full px-4 py-3 text-sm appearance-none cursor-pointer"><option value="USER">User</option><option value="ADMIN">Admin</option></select></div>
                </div>
            </div>
            <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/50 flex justify-end gap-4">
                <button @click="showEditModal = false" class="text-xs font-bold text-slate-500 uppercase hover:text-slate-900">Cancel</button>
                <button @click="showEditModal = false; alert('User Updated!')" class="bg-slate-900 text-white px-8 py-2.5 rounded-xl font-bold text-xs uppercase shadow-lg hover:bg-black transition-all">Update Info</button>
            </div>
        </div>
    </div>

</body>
</html>