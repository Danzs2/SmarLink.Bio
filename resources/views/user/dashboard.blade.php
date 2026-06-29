<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Tautan | SmartLink Bio</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        linktree: { bg: '#F3F3F1', surface: '#FFFFFF', purple: '#8129D9', purpleHover: '#6919B4', text: '#222222', textMuted: '#676B6F' }
                    },
                    boxShadow: { soft: '0px 4px 20px rgba(0, 0, 0, 0.05)', hover: '0px 8px 24px rgba(0, 0, 0, 0.08)' }
                }
            }
        }
    </script>
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; color: #334155; overflow: hidden; }
        
        input[type="color"] { -webkit-appearance: none; border: none; width: 32px; height: 32px; border-radius: 50%; overflow: hidden; cursor: pointer; padding: 0; }
        input[type="color"]::-webkit-color-swatch-wrapper { padding: 0; }
        input[type="color"]::-webkit-color-swatch { border: none; border-radius: 50%; }

        .bg-dots {
            background-color: #F8FAFC;
            background-image: radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }
        .bg-aurora {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1; overflow: hidden;
            background: linear-gradient(135deg, rgba(248,250,252,0.8) 0%, rgba(241,240,255,0.8) 100%);
        }
        .circle-purple { position: absolute; top: -10%; right: -5%; width: 500px; height: 500px; background: rgba(139, 92, 246, 0.15); filter: blur(100px); border-radius: 50%; }
        .circle-blue { position: absolute; bottom: -10%; left: -5%; width: 600px; height: 600px; background: rgba(59, 130, 246, 0.12); filter: blur(100px); border-radius: 50%; }
        
        .card-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>

    <script>
        window.dbLinks = @json($links ?? []);
    </script>
</head>
<body class="bg-dots antialiased" 
      x-data="{ 
          tab: 'links', 
          addMode: '',
          showEditModal: false,
          editData: {}, 

          profileImagePreview: '{!! Auth::user()->profile_picture ? asset('storage/'.str_replace('\\', '/', Auth::user()->profile_picture)) : '' !!}',
          bgImagePreview: '{!! optional(Auth::user()->pageSetting)->background_image ? asset('storage/'.str_replace('\\', '/', optional(Auth::user()->pageSetting)->background_image)) : 'https://images.unsplash.com/photo-1557683316-973673baf926?w=400&q=80' !!}',
          
          userProfile: {
              name: '{!! addslashes(Auth::user()->name ?? 'Andi Pratama') !!}',
              bio: '{!! addslashes(Auth::user()->bio ?? 'Mahasiswa TRPL | Web Dev') !!}',
              bg_type: '{!! optional(Auth::user()->pageSetting)->bg_type ?? 'solid' !!}', 
              bg_color: '{!! optional(Auth::user()->pageSetting)->bg_color ?? '#F3F4F6' !!}',
              button_corner_style: '{!! optional(Auth::user()->pageSetting)->button_corner_style ?? 'rounded' !!}', 
              button_display_style: '{!! optional(Auth::user()->pageSetting)->button_display_style ?? 'fill' !!}', 
              button_color: '{!! optional(Auth::user()->pageSetting)->button_color ?? '#8129D9' !!}',
              text_color: '{!! optional(Auth::user()->pageSetting)->text_color ?? '#FFFFFF' !!}',
              social_position: '{!! optional(Auth::user()->pageSetting)->social_position ?? 'bottom' !!}' 
          },
          
          platforms: [
              { id: 'instagram', icon: 'fa-brands fa-instagram', name: 'Instagram' },
              { id: 'tiktok', icon: 'fa-brands fa-tiktok', name: 'TikTok' },
              { id: 'youtube', icon: 'fa-brands fa-youtube', name: 'YouTube' },
              { id: 'whatsapp', icon: 'fa-brands fa-whatsapp', name: 'WhatsApp' },
              { id: 'linkedin', icon: 'fa-brands fa-linkedin', name: 'LinkedIn' },
              { id: 'jobstreet', icon: 'fa-solid fa-briefcase', name: 'JobStreet' },
              { id: 'github', icon: 'fa-brands fa-github', name: 'GitHub' },
              { id: 'facebook', icon: 'fa-brands fa-facebook', name: 'Facebook' },
              { id: 'x-twitter', icon: 'fa-brands fa-x-twitter', name: 'X / Twitter' },
              { id: 'telegram', icon: 'fa-brands fa-telegram', name: 'Telegram' },
              { id: 'shopee', icon: 'fa-solid fa-bag-shopping', name: 'Shopee' },
              { id: 'tokopedia', icon: 'fa-solid fa-store', name: 'Tokopedia' }
          ],

          newCustom: { title: '', url: '', is_private: 0, privacy_mode: 'public', link_password: '' },
          newSocial: { platform: null, url: '' },
          links: window.dbLinks || [],

          get totalClicks() { 
              return this.links.reduce((acc, curr) => acc + (Number(curr.clicks) || 0), 0); 
          },

          saveAppearance() {
              let formData = new FormData();
              
              Object.keys(this.userProfile).forEach(key => {
                  formData.append(key, this.userProfile[key]);
              });

              let profileInput = document.getElementById('profile_upload');
              if (profileInput && profileInput.files[0]) {
                  formData.append('profile_picture', profileInput.files[0]);
              }

              let bgInput = document.getElementById('bg_upload');
              if (bgInput && bgInput.files[0]) {
                  formData.append('bg_image', bgInput.files[0]);
              }

              fetch('{{ route('appearance.update') }}', {
                  method: 'POST',
                  headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                  },
                  body: formData
              })
              .then(res => res.json())
              .then(data => {
                  if(data.success) {
                      alert('Desain & Gambar berhasil disimpan permanen! 🔥');
                      if(profileInput) profileInput.value = '';
                      if(bgInput) bgInput.value = '';
                  }
              })
              .catch(err => {
                  alert('Terjadi kesalahan saat menyimpan data gambar.');
              });
          },

          get bgStyle() {
              if (this.userProfile.bg_type === 'solid') return `background-color: ${this.userProfile.bg_color}`;
              if (this.userProfile.bg_type === 'gradient') return `background: linear-gradient(135deg, ${this.userProfile.bg_color}, #ffffff)`;
              if (this.userProfile.bg_type === 'image') return `background-image: url('${this.bgImagePreview}'); background-size: cover; background-position: center;`;
              return '';
          },

          get btnRadiusClass() {
              if (this.userProfile.button_corner_style === 'square') return 'rounded-none';
              if (this.userProfile.button_corner_style === 'rounded') return 'rounded-xl';
              return 'rounded-full'; 
          },

          updatePrivacy() { this.newCustom.is_private = this.newCustom.privacy_mode === 'public' ? 0 : 1; },

          openEdit(link) {
              this.editData = { ...link, privacy_mode: link.is_private === 1 ? 'password' : 'public' };
              this.showEditModal = true;
          },

          toggleLink(id) {
              const link = this.links.find(l => l.id === id);
              if (link) {
                  link.is_active = link.is_active === 1 ? 0 : 1; 
                  fetch(`/links/${id}/toggle`, {
                      method: 'PATCH',
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                          'Content-Type': 'application/json',
                          'Accept': 'application/json'
                      }
                  });
              }
          },

          getPlatformIcon(platform) {
              const p = this.platforms.find(x => x.id === platform);
              return p ? p.icon : 'fa-solid fa-link';
          },

          copyToClipboard() {
              const text = '{{ url("/") }}/@' + '{{ Auth::user()->username }}';
              if (navigator.clipboard && window.isSecureContext) {
                  navigator.clipboard.writeText(text).then(() => {
                      alert('Tautan berhasil disalin ke clipboard!\n\n' + text);
                  }).catch(err => {
                      console.error('Gagal copy modern: ', err);
                  });
              } else {
                  let textArea = document.createElement('textarea');
                  textArea.value = text;
                  textArea.style.position = 'fixed'; 
                  textArea.style.left = '-999999px';
                  textArea.style.top = '-999999px';
                  document.body.appendChild(textArea);
                  textArea.focus();
                  textArea.select();
                  try {
                      document.execCommand('copy');
                      alert('Tautan berhasil disalin!\n\n' + text);
                  } catch (err) {
                      alert('Gagal menyalin tautan.');
                  }
                  document.body.removeChild(textArea);
              }
          }
      }">

    <div class="bg-aurora">
        <div class="circle-purple"></div>
        <div class="circle-blue"></div>
    </div>

    <div class="flex flex-row flex-nowrap w-full h-screen overflow-hidden pb-16 md:pb-0 z-10 relative">

        <aside class="w-64 bg-white/90 backdrop-blur-xl border-r border-gray-200 shrink-0 shadow-lg shadow-gray-200/50 hidden md:flex flex-col h-full">
            <div class="h-20 flex items-center justify-center w-full shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="SmartLink Logo" class="h-10 w-auto object-contain">
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto scrollbar-hide">
                <button @click="tab = 'links'" :class="tab === 'links' ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-layer-group w-6 text-lg"></i> Manajemen Tautan
                </button>
                <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-shapes w-6 text-lg"></i> Kustom Desain
                </button>
                <button @click="tab = 'analytics'" :class="tab === 'analytics' ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-chart-simple w-6 text-lg"></i> Analitik Trafik
                </button>
                <button @click="tab = 'settings'" :class="tab === 'settings' ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 rounded-xl transition-all">
                    <i class="fa-solid fa-gear w-6 text-lg"></i> Pengaturan Akun
                </button>
            </nav>

            <div class="p-6 border-t border-gray-100 bg-white/50 shrink-0">
                <div class="flex items-center gap-3 mb-4 cursor-pointer hover:bg-white p-2 -mx-2 rounded-xl transition shadow-sm">
                    <img :src="profileImagePreview || 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=000&color=fff'" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate" x-text="userProfile.name"></p>
                        <p class="text-[10px] font-bold text-indigo-600 tracking-wide uppercase">{{ auth()->user()->role ?? 'PENGGUNA' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 text-rose-500 hover:text-rose-600 hover:bg-rose-50 py-2.5 rounded-xl font-bold transition-colors text-sm border border-rose-100 bg-white">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 min-w-0 flex flex-col h-full overflow-hidden relative bg-transparent">
            
            @if(session('success'))
            <div class="absolute top-20 sm:top-4 left-1/2 transform -translate-x-1/2 z-50 bg-emerald-500 text-white px-6 py-3 rounded-full font-bold shadow-lg flex items-center gap-2 text-sm w-[90%] sm:w-auto justify-center">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            <header class="h-16 sm:h-20 flex items-center justify-between px-4 sm:px-6 lg:px-12 z-10 shrink-0 bg-white/80 sm:bg-white/60 backdrop-blur-xl border-b border-gray-200 shadow-sm sticky top-0">
                <div class="hidden sm:block">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-0.5">Tautan Publik SmartLink-mu</p>
                    <a href="{{ url('/@'.Auth::user()->username) }}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:underline truncate inline-block max-w-[200px] lg:max-w-none">smartlink.com/{{ '@' . (Auth::user()->username ?? 'username') }}</a>
                </div>
                <h1 class="text-lg font-bold sm:hidden text-gray-900 ml-2" x-text="tab === 'links' ? 'Tautan' : (tab === 'appearance' ? 'Desain' : (tab === 'analytics' ? 'Analitik' : 'Pengaturan'))"></h1>
                <div class="flex items-center gap-3">
                    <button @click="copyToClipboard()" class="bg-gray-900 text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold hover:bg-black transition shadow-lg shadow-gray-900/20 flex items-center gap-2 transform active:scale-95">
                        <i class="fa-solid fa-share-nodes"></i> <span class="hidden sm:inline">Bagikan</span>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:px-12 pb-24 sm:pb-24 lg:pb-24 scroll-smooth scrollbar-hide">
                <div class="max-w-[640px] mx-auto">

                    <div x-show="tab === 'links'" x-transition.opacity.duration.300ms>
                        
                        <div x-show="addMode === ''" class="flex flex-row gap-2 sm:gap-4 mb-6 sm:mb-8">
                            <button @click="addMode = 'custom'" class="flex-1 bg-indigo-600 text-white rounded-2xl py-3 sm:py-4 font-bold text-xs sm:text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2 transform active:scale-95">
                                <i class="fa-solid fa-plus"></i> Kustom
                            </button>
                            <button @click="addMode = 'social'" class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-2xl py-3 sm:py-4 font-bold text-xs sm:text-sm hover:bg-gray-50 transition shadow-sm flex items-center justify-center gap-2 transform active:scale-95">
                                <i class="fa-solid fa-icons text-blue-500"></i> Ikon Sosial
                            </button>
                        </div>

                        <div x-show="addMode === 'custom'" x-collapse class="card-glass rounded-[24px] shadow-soft mb-8 overflow-hidden">
                            <div class="p-4 sm:p-5 border-b border-gray-100 flex justify-between items-center bg-white/50">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base"><i class="fa-solid fa-link text-indigo-600"></i> Tautan Kustom Baru</h3>
                                <button @click="addMode = ''" class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center text-gray-500 transition"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            
                            <form action="{{ route('links.store') }}" method="POST" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                                @csrf
                                <input type="hidden" name="type" value="custom">
                                <div class="space-y-4">
                                    <div class="relative">
                                        <input type="text" name="title" x-model="newCustom.title" required placeholder="Judul Tautan" class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-5 pb-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition placeholder-transparent">
                                        <label class="absolute left-4 top-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wide transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:text-indigo-600 peer-focus:font-bold">Judul Tombol (Bebas)</label>
                                    </div>
                                    <div class="relative">
                                        <input type="url" name="url" x-model="newCustom.url" required placeholder="URL Tujuan" class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-5 pb-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition placeholder-transparent">
                                        <label class="absolute left-4 top-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wide transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:text-indigo-600 peer-focus:font-bold">URL Tujuan (http://...)</label>
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl border border-gray-200 bg-white/50">
                                    <p class="text-xs font-bold text-gray-500 mb-3 uppercase tracking-wide">Pengaturan Privasi Tautan</p>
                                    <div class="flex flex-wrap gap-2">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="privacy_mode" value="public" x-model="newCustom.privacy_mode" @change="updatePrivacy()" class="peer sr-only" checked>
                                            <div class="px-4 py-2 border-2 border-gray-200 bg-white rounded-full text-xs sm:text-sm font-semibold text-gray-500 peer-checked:border-indigo-600 peer-checked:text-indigo-600 peer-checked:bg-indigo-50 transition flex items-center gap-2">
                                                <i class="fa-solid fa-globe"></i> Publik
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="privacy_mode" value="password" x-model="newCustom.privacy_mode" @change="updatePrivacy()" class="peer sr-only">
                                            <div class="px-4 py-2 border-2 border-gray-200 bg-white rounded-full text-xs sm:text-sm font-semibold text-gray-500 peer-checked:border-orange-500 peer-checked:text-orange-600 peer-checked:bg-orange-50 transition flex items-center gap-2">
                                                <i class="fa-solid fa-key"></i> Sandi/PIN
                                            </div>
                                        </label>
                                    </div>
                                    <div x-show="newCustom.privacy_mode === 'password'" x-collapse class="mt-3">
                                        <input type="text" name="link_password" x-model="newCustom.link_password" placeholder="Masukkan kata sandi..." class="w-full bg-white border border-orange-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-700 transition shadow-md w-full sm:w-auto text-sm">Simpan Kustom</button>
                                </div>
                            </form>
                        </div>

                        <div x-show="addMode === 'social'" x-collapse class="card-glass rounded-[24px] shadow-soft mb-8 overflow-hidden">
                            <div class="p-4 sm:p-5 border-b border-gray-100 flex justify-between items-center bg-white/50">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base"><i class="fa-solid fa-icons text-blue-500"></i> Tambah Ikon Sosial</h3>
                                <button @click="addMode = ''" class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center text-gray-500 transition"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            
                            <form action="{{ route('links.store') }}" method="POST" class="p-4 sm:p-6 space-y-4 sm:space-y-5">
                                @csrf
                                <input type="hidden" name="type" value="social">
                                <input type="hidden" name="platform" :value="newSocial.platform">
                                <input type="hidden" name="title" :value="platforms.find(p => p.id === newSocial.platform)?.name">

                                <div>
                                    <p class="text-xs font-bold text-gray-500 mb-3 uppercase tracking-wide">Pilih Platform</p>
                                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 sm:gap-3 max-h-[160px] overflow-y-auto pr-2">
                                        <template x-for="plat in platforms" :key="plat.id">
                                            <button type="button" @click="newSocial.platform = plat.id" 
                                                    :class="newSocial.platform === plat.id ? 'bg-indigo-50 text-indigo-600 border-indigo-600 shadow-sm' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50'"
                                                    class="flex flex-col items-center justify-center p-2 sm:p-3 rounded-2xl border-2 transition aspect-square">
                                                <i :class="plat.icon" class="text-xl sm:text-2xl mb-1.5"></i>
                                                <span class="text-[9px] sm:text-[10px] font-bold leading-tight" x-text="plat.name"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <div x-show="newSocial.platform" x-collapse>
                                    <div class="relative mt-2">
                                        <input type="url" name="url" x-model="newSocial.url" required placeholder="URL / Link Profil" class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-5 pb-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition placeholder-transparent">
                                        <label class="absolute left-4 top-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wide transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:text-indigo-600 peer-focus:font-bold">URL Sosial Media</label>
                                    </div>
                                    <div class="flex justify-end pt-4">
                                        <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-full font-bold hover:bg-black transition shadow-md w-full sm:w-auto text-sm">Simpan Sosial</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            <template x-for="link in links" :key="link.id">
                                <div class="card-glass rounded-[20px] sm:rounded-[24px] p-4 sm:p-5 shadow-soft hover:shadow-hover transition-shadow flex flex-col sm:flex-row gap-3 sm:gap-4 relative group mb-3 sm:mb-4">
                                    <div class="hidden sm:flex flex-col items-center justify-center text-gray-300 px-2 cursor-grab hover:text-gray-500">
                                        <i class="fa-solid fa-grip-vertical"></i>
                                    </div>

                                    <div class="flex-1 min-w-0 pr-10 sm:pr-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="w-6 h-6 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
                                                <i :class="link.type === 'social' ? getPlatformIcon(link.platform) : 'fa-solid fa-link'" class="text-[10px] sm:text-xs text-indigo-600"></i>
                                            </div>
                                            <h4 class="font-bold text-gray-900 text-sm sm:text-base truncate" x-text="link.title"></h4>
                                            <button @click="openEdit(link)" class="text-gray-400 hover:text-indigo-600 transition p-1">
                                                <i class="fa-solid fa-pen text-[10px] sm:text-xs"></i>
                                            </button>
                                        </div>

                                        <div class="flex items-center gap-2 pl-8">
                                            <a :href="link.url" target="_blank" class="text-gray-500 text-xs sm:text-sm hover:underline truncate" x-text="link.url"></a>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 sm:gap-4 mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                                            <span class="flex items-center gap-1.5 text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                <span x-text="link.type"></span>
                                            </span>
                                            
                                            <span x-show="link.type === 'custom'" class="flex items-center gap-1 text-[10px] sm:text-[11px] font-bold" :class="link.is_private === 0 ? 'text-emerald-600 bg-emerald-50 px-1.5 sm:px-2 py-0.5 rounded' : 'text-rose-600 bg-rose-50 px-1.5 sm:px-2 py-0.5 rounded'">
                                                <i class="fa-solid" :class="link.is_private === 0 ? 'fa-globe' : 'fa-lock'"></i> 
                                                <span class="uppercase tracking-wide" x-text="link.is_private === 0 ? 'Publik' : 'Private'"></span>
                                            </span>

                                            <span class="flex items-center gap-1.5 text-[10px] sm:text-xs font-bold text-indigo-600 bg-indigo-50 px-1.5 sm:px-2 py-0.5 rounded ml-1 sm:ml-2">
                                                <i class="fa-solid fa-chart-simple"></i> <span x-text="link.clicks || 0"></span>
                                            </span>
                                            
                                            <form :action="'{{ url('/links') }}/' + link.id" method="POST" class="ml-auto m-0" onsubmit="return confirm('Yakin ingin menghapus tautan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-rose-500 transition px-2">
                                                    <i class="fa-regular fa-trash-can text-sm sm:text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="absolute top-4 right-4 sm:relative sm:top-0 sm:right-0 flex items-start">
                                        <button @click="toggleLink(link.id)" :class="link.is_active === 1 ? 'bg-emerald-500' : 'bg-gray-200'" class="relative inline-flex h-5 w-9 sm:h-6 sm:w-11 items-center rounded-full transition-colors focus:outline-none">
                                            <span :class="link.is_active === 1 ? 'translate-x-4 sm:translate-x-6' : 'translate-x-1'" class="inline-block h-3.5 w-3.5 sm:h-4 sm:w-4 transform rounded-full bg-white transition-transform shadow-sm"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="links.length === 0" class="text-center py-10">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-2xl">
                                    <i class="fa-solid fa-link-slash"></i>
                                </div>
                                <p class="text-gray-500 font-semibold text-sm">Tautan kamu masih kosong.</p>
                            </div>
                        </div>
                    </div>

                    <div x-show="tab === 'appearance'" x-cloak x-transition.opacity.duration.300ms class="space-y-6 sm:space-y-8">
                        <div class="card-glass rounded-[20px] sm:rounded-[24px] p-5 sm:p-8 shadow-soft">
                            <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-4 sm:mb-6">Profil</h3>
                            <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center sm:items-start">
                                <div class="relative shrink-0 group">
                                    <img :src="profileImagePreview || 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=000&color=fff'" alt="Profile" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border border-gray-200 object-cover shadow-sm group-hover:opacity-70 transition">
                                    <label class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                        <i class="fa-solid fa-camera text-gray-800 text-xl drop-shadow-md"></i>
                                        <input type="file" id="profile_upload" accept="image/*" class="hidden" @change="profileImagePreview = URL.createObjectURL($event.target.files[0])">
                                    </label>
                                </div>
                                <div class="flex-1 w-full space-y-4">
                                    <div class="relative">
                                        <input type="text" x-model="userProfile.name" class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-5 pb-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition">
                                        <label class="absolute left-4 top-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wide">Judul Profil (name)</label>
                                    </div>
                                    <div class="relative">
                                        <textarea x-model="userProfile.bio" rows="3" class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-6 pb-2 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition resize-none"></textarea>
                                        <label class="absolute left-4 top-2 text-[10px] font-bold text-gray-500 uppercase tracking-wide">Bio</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-glass rounded-[20px] sm:rounded-[24px] p-5 sm:p-8 shadow-soft">
                            <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-4">Latar Belakang Profil</h3>
                            <div class="flex gap-2 sm:gap-4 mb-6 bg-gray-50 p-2 rounded-2xl border border-gray-200">
                                <button @click="userProfile.bg_type = 'solid'" :class="userProfile.bg_type === 'solid' ? 'bg-white shadow-sm font-bold text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm transition">Solid</button>
                                <button @click="userProfile.bg_type = 'gradient'" :class="userProfile.bg_type === 'gradient' ? 'bg-white shadow-sm font-bold text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm transition">Gradient</button>
                                <button @click="userProfile.bg_type = 'image'" :class="userProfile.bg_type === 'image' ? 'bg-white shadow-sm font-bold text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm transition">Gambar</button>
                            </div>

                            <div x-show="userProfile.bg_type === 'solid' || userProfile.bg_type === 'gradient'" class="flex items-center gap-3 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                <input type="color" x-model="userProfile.bg_color">
                                <span class="font-mono text-sm font-bold text-gray-700 uppercase" x-text="userProfile.bg_color"></span>
                            </div>

                            <div x-show="userProfile.bg_type === 'image'" x-collapse class="mt-4">
                                <label class="block w-full border-2 border-dashed border-gray-300 bg-white rounded-xl p-6 text-center cursor-pointer hover:bg-gray-50 transition">
                                    <i class="fa-solid fa-cloud-arrow-up text-indigo-400 text-2xl sm:text-3xl mb-2"></i>
                                    <p class="text-xs sm:text-sm text-gray-600 font-bold">Klik unggah gambar latar</p>
                                    <input type="file" id="bg_upload" accept="image/*" class="hidden" @change="bgImagePreview = URL.createObjectURL($event.target.files[0])">
                                </label>
                            </div>
                        </div>

                        <div class="card-glass rounded-[20px] sm:rounded-[24px] p-5 sm:p-8 shadow-soft">
                            <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-4">Posisi Ikon Sosial</h3>
                            <div class="flex gap-4">
                                <button @click="userProfile.social_position = 'top'" :class="userProfile.social_position === 'top' ? 'ring-2 ring-indigo-500 bg-indigo-50 border-transparent' : 'border-gray-200 bg-white hover:bg-gray-50'" class="flex-1 py-4 border-2 rounded-xl text-xs sm:text-sm font-bold text-gray-700 transition flex flex-col items-center gap-2">
                                    <div class="w-12 h-1 bg-gray-300 rounded-full mb-1"></div>
                                    <div class="flex gap-1"><div class="w-3 h-3 bg-gray-800 rounded-full"></div><div class="w-3 h-3 bg-gray-800 rounded-full"></div><div class="w-3 h-3 bg-gray-800 rounded-full"></div></div>
                                    <div class="w-16 h-4 bg-gray-300 rounded-md mt-1"></div>
                                    <span class="mt-1">Di Atas</span>
                                </button>
                                <button @click="userProfile.social_position = 'bottom'" :class="userProfile.social_position === 'bottom' ? 'ring-2 ring-indigo-500 bg-indigo-50 border-transparent' : 'border-gray-200 bg-white hover:bg-gray-50'" class="flex-1 py-4 border-2 rounded-xl text-xs sm:text-sm font-bold text-gray-700 transition flex flex-col items-center gap-2">
                                    <div class="w-12 h-1 bg-gray-300 rounded-full mb-1"></div>
                                    <div class="w-16 h-4 bg-gray-300 rounded-md"></div>
                                    <div class="flex gap-1 mt-1"><div class="w-3 h-3 bg-gray-800 rounded-full"></div><div class="w-3 h-3 bg-gray-800 rounded-full"></div><div class="w-3 h-3 bg-gray-800 rounded-full"></div></div>
                                    <span class="mt-1">Di Bawah</span>
                                </button>
                            </div>
                        </div>

                        <div class="card-glass rounded-[20px] sm:rounded-[24px] p-5 sm:p-8 shadow-soft">
                            <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-4">Pengaturan Tombol Kustom</h3>
                            <p class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 sm:mb-3">Bentuk Tombol</p>
                            <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <button @click="userProfile.button_corner_style = 'square'" :class="userProfile.button_corner_style === 'square' ? 'ring-2 ring-black bg-gray-100' : 'border-gray-200 bg-white hover:bg-gray-50'" class="py-4 sm:py-5 border-2 rounded-xl flex justify-center transition">
                                    <div class="w-12 sm:w-16 h-3 sm:h-4 bg-gray-800"></div> 
                                </button>
                                <button @click="userProfile.button_corner_style = 'rounded'" :class="userProfile.button_corner_style === 'rounded' ? 'ring-2 ring-black bg-gray-100' : 'border-gray-200 bg-white hover:bg-gray-50'" class="py-4 sm:py-5 border-2 rounded-xl flex justify-center transition">
                                    <div class="w-12 sm:w-16 h-3 sm:h-4 bg-gray-800 rounded-md"></div> 
                                </button>
                                <button @click="userProfile.button_corner_style = 'capsule'" :class="userProfile.button_corner_style === 'capsule' ? 'ring-2 ring-black bg-gray-100' : 'border-gray-200 bg-white hover:bg-gray-50'" class="py-4 sm:py-5 border-2 rounded-xl flex justify-center transition">
                                    <div class="w-12 sm:w-16 h-3 sm:h-4 bg-gray-800 rounded-full"></div> 
                                </button>
                            </div>
                            
                            <p class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 sm:mb-3">Gaya Tampilan</p>
                            <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-4 sm:mb-6">
                                <button @click="userProfile.button_display_style = 'fill'" :class="userProfile.button_display_style === 'fill' ? 'ring-2 ring-black bg-gray-100' : 'border-gray-200 bg-white hover:bg-gray-50'" class="py-4 sm:py-5 border-2 rounded-xl flex justify-center transition">
                                    <div class="w-14 sm:w-20 h-4 sm:h-6 bg-gray-900 rounded-md"></div> 
                                </button>
                                <button @click="userProfile.button_display_style = 'outline'" :class="userProfile.button_display_style === 'outline' ? 'ring-2 ring-black bg-gray-100' : 'border-gray-200 bg-white hover:bg-gray-50'" class="py-4 sm:py-5 border-2 rounded-xl flex justify-center transition">
                                    <div class="w-14 sm:w-20 h-4 sm:h-6 border-2 border-gray-900 rounded-md"></div> 
                                </button>
                                <button @click="userProfile.button_display_style = 'shadow'" :class="userProfile.button_display_style === 'shadow' ? 'ring-2 ring-black bg-gray-100' : 'border-gray-200 bg-white hover:bg-gray-50'" class="py-4 sm:py-5 border-2 rounded-xl flex justify-center transition">
                                    <div class="w-14 sm:w-20 h-4 sm:h-6 bg-white shadow-md border border-gray-200 rounded-md"></div> 
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                <div class="bg-white p-2 sm:p-3 rounded-xl border border-gray-200 shadow-sm">
                                    <p class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Warna Tombol</p>
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <input type="color" x-model="userProfile.button_color">
                                        <span class="font-mono text-xs sm:text-sm font-bold text-gray-800 uppercase" x-text="userProfile.button_color"></span>
                                    </div>
                                </div>
                                <div class="bg-white p-2 sm:p-3 rounded-xl border border-gray-200 shadow-sm">
                                    <p class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Warna Teks</p>
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <input type="color" x-model="userProfile.text_color">
                                        <span class="font-mono text-xs sm:text-sm font-bold text-gray-800 uppercase" x-text="userProfile.text_color"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 sm:mt-8 flex justify-end">
                            <button @click="saveAppearance()" class="bg-indigo-600 text-white px-8 sm:px-10 py-3 sm:py-4 rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform active:scale-95 w-full sm:w-auto text-sm">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Desain
                            </button>
                        </div>
                    </div>

                    <div x-show="tab === 'analytics'" x-cloak x-transition.opacity.duration.300ms class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-900 rounded-[20px] sm:rounded-[24px] p-5 sm:p-6 shadow-xl text-white relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full"></div>
                                <p class="text-gray-400 font-medium mb-1 text-sm">Kunjungan Profil</p>
                                <h2 class="text-4xl sm:text-5xl font-black mb-2">{{ Auth::user()->visits ?? 0 }}</h2>
                            </div>
                            <div class="card-glass rounded-[20px] sm:rounded-[24px] p-5 sm:p-6 shadow-soft">
                                <p class="text-gray-500 font-semibold mb-1 text-sm">Total Klik Semua Tautan</p>
                                <h2 class="text-4xl sm:text-5xl font-black text-indigo-600 mb-2" x-text="totalClicks"></h2>
                            </div>
                        </div>
                    </div>

                    <div x-show="tab === 'settings'" x-cloak x-transition.opacity.duration.300ms class="space-y-6">
                        <div class="card-glass rounded-[20px] sm:rounded-[24px] p-5 sm:p-8 shadow-soft border-t-4 border-t-rose-500">
                            <h3 class="font-bold text-rose-600 text-base sm:text-lg mb-2"><i class="fa-solid fa-shield-virus mr-1"></i> Keamanan Akun</h3>
                            <div class="flex items-center gap-3 sm:gap-4 bg-white p-3 sm:p-4 rounded-xl border border-rose-100 mt-4 shadow-sm">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg sm:text-xl font-black shrink-0">
                                    {{ Auth::user()->violation_count ?? '0' }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Poin Pelanggaran</h4>
                                    <p class="text-gray-500 text-[10px] sm:text-xs mt-0.5">Batas maksimal: 3 poin</p>
                                </div>
                            </div>
                        </div>

                        <div class="md:hidden mt-4">
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center space-x-2 text-white bg-rose-500 hover:bg-rose-600 py-3.5 rounded-2xl font-bold transition-all text-sm shadow-md shadow-rose-200 transform active:scale-95">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    <span>Keluar Akun (Logout)</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <aside class="w-[360px] xl:w-[400px] border-l border-white/40 shrink-0 bg-white/20 backdrop-blur-sm relative hidden lg:flex items-center justify-center p-8 h-full">
            <div class="relative w-[280px] h-[580px] border-[10px] border-gray-900 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col z-10 ring-1 ring-gray-200 bg-white">
                <div class="absolute top-0 inset-x-0 h-5 bg-gray-900 rounded-b-xl w-28 mx-auto z-20"></div>
                <div class="flex-1 w-full h-full overflow-y-auto flex flex-col items-center pt-14 pb-10 scrollbar-hide transition-all duration-300 relative" :style="bgStyle">
                    <div class="relative z-10 flex flex-col items-center w-full px-4">
                        <img :src="profileImagePreview || 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=000&color=fff'" alt="Profile" class="w-20 h-20 rounded-full mb-4 object-cover shadow-md border-2 border-white/20">
                        <h2 class="text-[17px] font-bold text-center leading-tight px-2" :style="userProfile.bg_type === 'solid' && userProfile.bg_color === '#1E1E1E' ? 'color: white' : (userProfile.bg_type === 'image' ? 'color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.8);' : 'color: #111827')" x-text="userProfile.name"></h2>
                        <p class="text-[13px] text-center mt-2 font-medium leading-snug px-2" :style="userProfile.bg_type === 'solid' && userProfile.bg_color === '#1E1E1E' ? 'color: #D1D5DB' : (userProfile.bg_type === 'image' ? 'color: #E5E7EB; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : 'color: #4B5563')" x-text="userProfile.bio"></p>

                        <div x-show="userProfile.social_position === 'top'" class="flex flex-wrap justify-center gap-4 w-full px-4 mt-5">
                            <template x-for="link in links.filter(l => l.type === 'social' && l.is_active === 1)" :key="link.id">
                                <a :href="link.url" target="_blank" class="text-[26px] hover:scale-110 transition-transform drop-shadow-sm" 
                                   :style="userProfile.bg_type === 'image' ? 'color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));' : `color: ${userProfile.text_color === '#FFFFFF' && userProfile.bg_color !== '#1E1E1E' ? '#111827' : userProfile.text_color}`">
                                    <i :class="getPlatformIcon(link.platform)"></i>
                                </a>
                            </template>
                        </div>

                        <div class="w-full space-y-3 mt-6">
                            <template x-for="link in links.filter(l => l.type === 'custom' && l.is_active === 1)" :key="link.id">
                                <a :href="link.url" target="_blank" 
                                   :class="btnRadiusClass"
                                   :style="
                                      userProfile.button_display_style === 'fill' ? `background-color: ${userProfile.button_color}; color: ${userProfile.text_color}; border: 2px solid ${userProfile.button_color};` :
                                      (userProfile.button_display_style === 'outline' ? `background-color: transparent; color: ${userProfile.button_color}; border: 2px solid ${userProfile.button_color}; backdrop-filter: blur(4px);` :
                                      `background-color: #ffffff; color: ${userProfile.button_color}; border: 2px solid transparent; box-shadow: 0 4px 10px rgba(0,0,0,0.1);`)
                                   "
                                   class="flex items-center justify-center w-full py-3.5 px-4 font-semibold text-[14px] transition transform hover:scale-[1.02] relative overflow-hidden">
                                    <span x-text="link.title" class="truncate px-6"></span>
                                    <i x-show="link.is_private === 1" class="fa-solid fa-lock absolute right-4 text-xs opacity-50"></i>
                                </a>
                            </template>
                        </div>

                        <div x-show="userProfile.social_position === 'bottom'" class="flex flex-wrap justify-center gap-4 w-full px-4 mt-6">
                            <template x-for="link in links.filter(l => l.type === 'social' && l.is_active === 1)" :key="link.id">
                                <a :href="link.url" target="_blank" class="text-[26px] hover:scale-110 transition-transform drop-shadow-sm" 
                                   :style="userProfile.bg_type === 'image' ? 'color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));' : `color: ${userProfile.text_color === '#FFFFFF' && userProfile.bg_color !== '#1E1E1E' ? '#111827' : userProfile.text_color}`">
                                    <i :class="getPlatformIcon(link.platform)"></i>
                                </a>
                            </template>
                        </div>
                    </div>
                    <div class="mt-auto pt-10 pb-2 relative z-10 flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="SmartLink" class="h-5 w-auto object-contain opacity-80 hover:opacity-100 transition filter grayscale contrast-200">
                    </div>
                </div>
            </div>
        </aside>

    </div> <nav class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 flex justify-around items-center h-16 z-[60] shadow-[0_-4px_10px_rgba(0,0,0,0.05)] pb-safe">
        <button @click="tab = 'links'" :class="tab === 'links' ? 'text-indigo-600' : 'text-gray-400'" class="flex flex-col items-center justify-center w-full h-full space-y-1 hover:bg-gray-50 transition">
            <i class="fa-solid fa-layer-group text-lg"></i>
            <span class="text-[10px] font-bold">Tautan</span>
        </button>
        <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'text-indigo-600' : 'text-gray-400'" class="flex flex-col items-center justify-center w-full h-full space-y-1 hover:bg-gray-50 transition">
            <i class="fa-solid fa-shapes text-lg"></i>
            <span class="text-[10px] font-bold">Desain</span>
        </button>
        <button @click="tab = 'analytics'" :class="tab === 'analytics' ? 'text-indigo-600' : 'text-gray-400'" class="flex flex-col items-center justify-center w-full h-full space-y-1 hover:bg-gray-50 transition">
            <i class="fa-solid fa-chart-simple text-lg"></i>
            <span class="text-[10px] font-bold">Analitik</span>
        </button>
        <button @click="tab = 'settings'" :class="tab === 'settings' ? 'text-indigo-600' : 'text-gray-400'" class="flex flex-col items-center justify-center w-full h-full space-y-1 hover:bg-gray-50 transition">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[10px] font-bold">Akun</span>
        </button>
    </nav>

    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-gray-900/60 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="showEditModal = false" class="bg-white rounded-t-[32px] sm:rounded-[24px] w-full max-w-lg shadow-2xl shadow-indigo-900/20 mt-auto sm:mt-0 max-h-[90vh] flex flex-col transition-transform transform translate-y-0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full sm:translate-y-0 sm:scale-95 opacity-0" x-transition:enter-end="translate-y-0 sm:scale-100 opacity-100">
            
            <div class="w-full flex justify-center pt-3 pb-1 sm:hidden cursor-pointer" @click="showEditModal = false">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
            </div>

            <div class="p-4 sm:p-5 border-b border-gray-100 flex justify-between items-center bg-white shrink-0">
                <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fa-solid fa-pen-to-square text-indigo-600"></i> Edit Tautan
                </h3>
                <button @click="showEditModal = false" class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center text-gray-500 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <form :action="'{{ url('/links') }}/' + editData.id" method="POST" class="p-4 sm:p-6 space-y-4 sm:space-y-5 overflow-y-auto scrollbar-hide">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="relative">
                        <input type="text" name="title" x-model="editData.title" required class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-5 pb-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition placeholder-transparent">
                        <label class="absolute left-4 top-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wide transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:text-indigo-600 peer-focus:font-bold">Judul Tautan</label>
                    </div>
                    <div class="relative">
                        <input type="url" name="url" x-model="editData.url" required class="w-full bg-white border border-gray-200 rounded-xl px-4 pt-5 pb-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 peer transition placeholder-transparent">
                        <label class="absolute left-4 top-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wide transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:text-indigo-600 peer-focus:font-bold">URL Tujuan</label>
                    </div>
                </div>
                
                <div x-show="editData.type === 'custom'" class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                    <p class="text-xs font-bold text-gray-500 mb-3 uppercase tracking-wide">Pengaturan Privasi Tautan</p>
                    <div class="flex flex-wrap gap-2">
                        <label class="cursor-pointer flex-1 sm:flex-none">
                            <input type="radio" name="privacy_mode" value="public" x-model="editData.privacy_mode" class="peer sr-only">
                            <div class="px-3 sm:px-4 py-2 sm:py-2 border-2 border-gray-200 bg-white rounded-full text-xs sm:text-sm font-semibold text-gray-500 peer-checked:border-indigo-600 peer-checked:text-indigo-600 peer-checked:bg-indigo-50 transition flex items-center justify-center gap-1 sm:gap-2">
                                <i class="fa-solid fa-globe"></i> Publik
                            </div>
                        </label>
                        <label class="cursor-pointer flex-1 sm:flex-none">
                            <input type="radio" name="privacy_mode" value="password" x-model="editData.privacy_mode" class="peer sr-only">
                            <div class="px-3 sm:px-4 py-2 sm:py-2 border-2 border-gray-200 bg-white rounded-full text-xs sm:text-sm font-semibold text-gray-500 peer-checked:border-orange-500 peer-checked:text-orange-600 peer-checked:bg-orange-50 transition flex items-center justify-center gap-1 sm:gap-2">
                                <i class="fa-solid fa-key"></i> Sandi/PIN
                            </div>
                        </label>
                    </div>
                    <div x-show="editData.privacy_mode === 'password'" class="mt-3">
                        <input type="text" name="link_password" x-model="editData.link_password" placeholder="Masukkan kata sandi baru (kosongkan jika tidak diubah)" class="w-full bg-white border border-orange-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>

                <div class="flex justify-end pt-4 pb-2 sm:pb-0 border-t border-gray-100 shrink-0">
                    <button type="submit" class="bg-gray-900 text-white px-8 py-3.5 rounded-full font-bold hover:bg-black transition shadow-md w-full text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>