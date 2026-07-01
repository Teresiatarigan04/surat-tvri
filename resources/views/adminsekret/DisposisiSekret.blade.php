<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebar: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposisi Sekretariat | TVRI Sumut</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,
<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
  <defs>
    <linearGradient id='g' x1='0' y1='0' x2='1' y2='1'>
      <stop offset='0%' stop-color='%230A2A66'/>
      <stop offset='100%' stop-color='%23071C45'/>
    </linearGradient>
  </defs>
  <rect width='100' height='100' rx='18' fill='url(%23g)'/>
  <text x='50' y='64' font-size='36' font-weight='700' text-anchor='middle' fill='white' font-family='Arial, Helvetica, sans-serif'>TVRI</text>
</svg>">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617;
            background-image: radial-gradient(circle at top right, rgba(30, 58, 138, 0.2), transparent),
                radial-gradient(circle at bottom left, rgba(15, 23, 42, 0.2), transparent);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Gunakan selector yang spesifik */
        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 100%);
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }


        .sidebar-item-active i,
        .sidebar-item-active span {
            color: #3b82f6 !important;
            /* Paksa ikon dan teks jadi biru */
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #020617;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        .premium-swal-popup {
            background: rgba(15, 23, 42, 0.9) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 32px !important;
            color: #f8fafc !important;
        }

        .premium-swal-confirm {
            background: linear-gradient(135deg, #ef4444, #991b1b) !important;
            border-radius: 14px !important;
            padding: 12px 30px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 1px !important;
        }

        .premium-swal-cancel {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #94a3b8 !important;
            border-radius: 14px !important;
            padding: 12px 30px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 1px !important;
        }

        [x-cloak] {
            display: none !important;
        }

        @keyframes shake {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
        }

        .group\/btn:hover .fa-trash-can {
            animation: shake 0.3s ease-in-out infinite;
        }

        /* Responsivitas: Sembunyikan kolom catatan di layar kecil untuk ruang tombol */
        @media (max-width: 768px) {
            .p-6 {
                padding: 1rem !important;
            }
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden">

    <div x-show="mobileSidebar" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900/50 backdrop-blur-xl border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

        <div class="p-6 shrink-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-8" alt="Logo">
                <span class="text-sm font-black tracking-tighter text-white uppercase">E-Secretary</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto scrollbar-hide pb-4">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2 ">Main Menu</p>

            <a href="{{ route('admin.sekret.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*/dashboard') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-house-chimney text-sm"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.suratsekret.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Kirim Surat</span>
            </a>

            <a href="{{ route('admin.surat.masuk') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*surat-masuk*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-envelope-open-text text-sm"></i>
                <span class="text-sm font-semibold">Surat Masuk</span>
            </a>

            <a href="{{ route('admin.surat.keluar') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*surat-keluar*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Surat Keluar</span>
            </a>

            <a href="{{ route('admin.disposisi.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*disposisi*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-share-nodes text-sm"></i>
                <span class="text-sm font-semibold">Disposisi Surat</span>
            </a>

            <a href="{{ route('admin.arsip.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*arsip*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-box-archive text-sm"></i>
                <span class="text-sm font-semibold">Arsip Surat</span>
            </a>

            <a href="{{ route('admin.tracking.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*tracking*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-map-location-dot text-sm"></i>
                <span class="text-sm font-semibold">Tracking Surat</span>
            </a>

            <div x-data="{ open: {{ request()->is('*/kelola-akun*') || request()->is('*/log*') ? 'true' : 'false' }} }" class="pt-4">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">System Control</p>
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                        <span class="text-sm font-semibold">Administrator</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-cloak x-transition class="ml-9 mt-1 space-y-1">
                    <a href="{{ route('kelola-akun.index') }}"
                        class="flex items-center gap-3 px-4 py-2 text-xs font-medium transition-colors group {{ request()->is('*/kelola-akun*') ? 'text-blue-400' : 'text-slate-500 hover:text-blue-400' }}">
                        <i class="fa-solid fa-users-gear text-[10px] {{ request()->is('*/kelola-akun*') ? 'opacity-100' : 'opacity-50' }} group-hover:opacity-100"></i>
                        <span>Kelola Akun</span>
                    </a>
                    <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-medium text-slate-500 hover:text-blue-400 transition-colors group">
                        <i class="fa-solid fa-clock-rotate-left text-[10px] opacity-50 group-hover:opacity-100"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="p-4 border-t border-white/5 bg-slate-900/80 backdrop-blur-md shrink-0">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-500/10">
                    <i class="fa-solid fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="lg:ml-72 min-h-screen bg-slate-50 transition-all duration-300"
        :class="showModal ? 'relative z-[60]' : ''"
        x-data="{ showModal: false, loaded: false }"
        x-init="setTimeout(() => loaded = true, 100)">

        <!-- HEADER: Putih Bersih dengan Blur -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4 group">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 hover:text-blue-600 transition-all duration-300">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div class="transition-transform duration-500 group-hover:translate-x-1">
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight italic uppercase">Disposisi Surat</h1>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">Sekretariat • TVRI Sumatera Utara</p>
                </div>
            </div>

            <!-- USER PROFILE -->
            <!-- Wrapper Utama Profile -->
            <div x-data="{ profileOpen: false }" class="relative">

                <!-- Tombol Pemicu (Trigger) -->
                <button @click="profileOpen = true" class="flex items-center gap-3 focus:outline-none group transition-all duration-300">
                    <div class="hidden sm:flex flex-col items-end mr-1 text-right">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-tighter group-hover:text-blue-600 transition-colors">
                            {{ Auth::user()->nama }}
                        </span>
                        <span class="text-[9px] text-emerald-600 flex items-center gap-1 font-black tracking-widest">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            ONLINE
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-emerald-500 p-0.5 shadow-lg shadow-blue-600/10 group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center border border-white/50">
                            <i class="fa-solid fa-user-tie text-blue-600"></i>
                        </div>
                    </div>
                </button>

                <!-- Modal Kontainer (Slide-out dari Kanan) -->
                <template x-teleport="body">
                    <div x-show="profileOpen" class="fixed inset-0 z-[9999] overflow-hidden" style="display: none;">

                        <!-- Latar Belakang Blur -->
                        <div x-show="profileOpen"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-400"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            @click="profileOpen = false"
                            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm">
                        </div>

                        <!-- Panel Konten -->
                        <div class="absolute inset-y-0 right-0 flex max-w-full">
                            <div x-show="profileOpen"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full"
                                x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0"
                                x-transition:leave-end="translate-x-full"
                                @click.away="profileOpen = false"
                                class="w-screen max-w-sm">

                                <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-[40px] border-l border-slate-100 overflow-hidden">

                                    <!-- Bagian Header (Visual) -->
                                    <div class="relative h-72 bg-slate-950 flex flex-col items-center justify-center text-center p-6 rounded-bl-[80px] shadow-inner">
                                        <!-- Efek Dekoratif Cahaya (Mesh) -->
                                        <div class="absolute inset-0 overflow-hidden opacity-40">
                                            <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-600 rounded-full blur-[100px]"></div>
                                            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-emerald-500 rounded-full blur-[100px]"></div>
                                        </div>

                                        <div class="relative group">
                                            <div class="w-28 h-28 rounded-[35px] bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-5 shadow-2xl transition-transform duration-700 group-hover:rotate-[360deg]">
                                                <i class="fa-solid fa-user-tie text-5xl text-white"></i>
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 bg-emerald-500 border-4 border-slate-950 w-6 h-6 rounded-full shadow-lg"></div>
                                        </div>

                                        <h2 class="relative text-white font-black italic tracking-widest uppercase text-xl leading-tight">
                                            {{ Auth::user()->nama }}
                                        </h2>
                                        <div class="relative mt-2 px-4 py-1 rounded-full bg-blue-500/20 border border-blue-400/30">
                                            <p class="text-blue-300 text-[10px] font-black tracking-[0.4em] uppercase">
                                                {{ Auth::user()->role }}
                                            </p>
                                        </div>

                                        <!-- Tombol Tutup -->
                                        <button @click="profileOpen = false" class="absolute top-10 right-10 text-white/30 hover:text-white transition-all duration-300 hover:rotate-90">
                                            <i class="fa-solid fa-xmark text-2xl"></i>
                                        </button>
                                    </div>

                                    <!-- Daftar Informasi (Data List) -->
                                    <div class="flex-1 px-10 py-12 overflow-y-auto">
                                        <div class="space-y-8">
                                            <div>
                                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-6 flex items-center gap-4 italic">
                                                    <span class="w-10 h-[1px] bg-slate-200"></span>
                                                    Detail Akun Personal
                                                </h3>

                                                <div class="grid gap-4">
                                                    <!-- Username -->
                                                    <div class="group flex flex-col gap-1 p-5 rounded-[24px] bg-slate-50 border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-300">
                                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Nama Pengguna</span>
                                                        <div class="flex items-center gap-3">
                                                            <i class="fa-solid fa-at text-blue-500/50 text-sm group-hover:scale-110 transition-transform"></i>
                                                            <span class="text-sm font-bold text-slate-900 italic">{{ Auth::user()->username }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Hak Akses -->
                                                    <div class="group flex flex-col gap-1 p-5 rounded-[24px] bg-slate-50 border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all duration-300">
                                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Role</span>
                                                        <div class="flex items-center gap-3">
                                                            <i class="fa-solid fa-shield-halved text-emerald-500/50 text-sm group-hover:scale-110 transition-transform"></i>
                                                            <span class="text-sm font-bold text-slate-900 italic tracking-tight">{{ Auth::user()->role }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Tanggal Bergabung -->
                                                    <div class="group flex flex-col gap-1 p-5 rounded-[24px] bg-slate-50 border border-slate-100 hover:border-slate-300 transition-all duration-300">
                                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tanggal Bergabung</span>
                                                        <div class="flex items-center gap-3">
                                                            <i class="fa-solid fa-calendar-day text-slate-400/50 text-sm group-hover:scale-110 transition-transform"></i>
                                                            <span class="text-sm font-bold text-slate-900 italic">
                                                                {{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bagian Bawah (Footer) -->
                                    <div class="p-10 border-t border-slate-50 text-center bg-slate-50/30">
                                        <div class="flex items-center justify-center gap-2 mb-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-600"></div>
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic">
                                            TVRI System
                                        </p>
                                        <p class="text-[8px] font-bold text-slate-300 uppercase tracking-tighter mt-1">
                                            Versi Aplikasi 1.0.4 • 2026
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </header>

        <!-- CONTAINER UTAMA -->
        <div class="p-4 lg:p-8 space-y-12 max-w-[1600px] mx-auto"
            x-data="{ 
        loaded: false,
        init() {
            setTimeout(() => this.loaded = true, 100);
        }
    }">

            <!-- STATS CARDS dengan Staggered Animation -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-500 delay-[100ms]"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white group p-6 rounded-[30px] border border-slate-200 border-l-4 border-l-blue-500 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest group-hover:text-blue-600 transition-colors">Total Disposisi</p>
                            <h3 class="text-4xl font-black text-slate-900 mt-2 tracking-tighter">{{ $stats['total'] ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-500">
                            <i class="fa-solid fa-folder-tree"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-4 uppercase font-bold italic tracking-tighter border-t border-slate-50 pt-4">Semua periode aktif</p>
                </div>

                <!-- Card 2 -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-500 delay-[200ms]"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white group p-6 rounded-[30px] border border-slate-200 border-l-4 border-l-amber-500 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest group-hover:text-amber-600 transition-colors">Sedang Berjalan</p>
                            <h3 class="text-4xl font-black text-amber-600 mt-2 tracking-tighter">{{ $stats['pending'] ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-500">
                            <i class="fa-solid fa-spinner fa-spin-slow"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-4 uppercase font-bold italic tracking-tighter border-t border-slate-50 pt-4">Butuh Tindak Lanjut segera</p>
                </div>

                <!-- Card 3 -->
                <div x-show="loaded"
                    x-transition:enter="transition ease-out duration-500 delay-[300ms]"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white group p-6 rounded-[30px] border border-slate-200 border-l-4 border-l-emerald-500 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest group-hover:text-emerald-600 transition-colors">Tuntas</p>
                            <h3 class="text-4xl font-black text-emerald-600 mt-2 tracking-tighter">{{ $stats['selesai'] ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-500">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-4 uppercase font-bold italic tracking-tighter border-t border-slate-50 pt-4">Arsip Selesai diverifikasi</p>
                </div>
            </div>

            <div class="space-y-6" x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-[400ms]" x-transition:enter-start="opacity-0 scale-[0.98]">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-2">
                    <div class="group cursor-default">
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase italic flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                            </span>
                            Kontrol Disposisi
                        </h2>
                        <p class="text-xs text-slate-500 font-medium ml-6 uppercase tracking-[0.1em] transition-all group-hover:ml-8 group-hover:text-blue-500">Kelola instruksi pimpinan dan delegasi surat</p>
                    </div>
                    <button @click="showModal = true" class="group bg-blue-600 hover:bg-slate-900 text-white px-8 py-4 rounded-[20px] text-xs font-bold transition-all duration-500 flex items-center justify-center gap-3 shadow-lg shadow-blue-600/20 active:scale-95 uppercase tracking-[0.2em]">
                        <i class="fa-solid fa-paper-plane group-hover:-translate-y-6 group-hover:translate-x-6 group-hover:opacity-0 transition-all duration-300"></i>
                        <span class="relative">
                            <span class="group-hover:translate-x-[-10px] transition-all duration-300 inline-block">BUAT DISPOSISI</span>
                        </span>
                    </button>
                </div>

                <div class="bg-white rounded-[30px] p-2 overflow-hidden border border-slate-200 shadow-2xl shadow-slate-200/50 transition-all duration-500">
                    <div class="overflow-x-auto backend-scroll">
                        <table class="w-full text-left border-collapse min-w-[1000px]">
                            <thead>
                                <tr class="bg-slate-900">
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] italic w-[22%] rounded-tl-2xl">Identitas Surat</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] italic w-[28%]">Penerima & Peran Tujuan</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] italic w-[25%]">Instruksi</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] italic text-center w-[13%]">Status / Update</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] italic text-center w-[12%] rounded-tr-2xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php $hasData = false; @endphp

                                @foreach($disposisis->groupBy('surat_id') as $suratId => $groupDisposisi)
                                @php
                                $hasData = true;
                                $rowCount = $groupDisposisi->count();
                                @endphp

                                @foreach($groupDisposisi as $index => $d)
                                @php
                                $isFirstRowInGroup = ($index === 0);
                                $isLastRowInGroup = ($index === $rowCount - 1);
                                $isAdminSekret = ($d->ke_admin == 1 || (isset($d->penerima) && strtolower($d->penerima->nama) == 'admin secretariat'));
                                @endphp

                                {{-- Baris Data Utama --}}
                                <tr class="hover:bg-blue-50/30 transition-all duration-200 group/row bg-white">

                                    {{-- KOLOM 1: IDENTITAS SURAT --}}
                                    @if($isFirstRowInGroup)
                                    <td class="p-5 align-middle border-r border-slate-200 bg-slate-50/50" rowspan="{{ $rowCount }}">
                                        <div class="space-y-3 py-1 max-w-[220px] mx-auto">
                                            {{-- Kotak Nomor Surat --}}
                                            <div class="block bg-white border border-blue-200 rounded-xl px-2.5 py-1.5 shadow-sm max-w-full truncate text-center" title="{{ $d->surat->no_surat ?? '-' }}">
                                                <p class="text-[11px] font-extrabold text-blue-700 tracking-tight block truncate">{{ $d->surat->no_surat ?? '-' }}</p>
                                            </div>

                                            {{-- Informasi Detail Perihal & Jumlah Tujuan --}}
                                            <div class="space-y-1.5 bg-white p-2.5 rounded-xl border border-slate-200 shadow-inner text-left">
                                                <div class="space-y-0.5">
                                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-wider block">Perihal:</span>
                                                    <p class="text-[10px] text-slate-700 leading-relaxed font-semibold line-clamp-3 hover:line-clamp-none transition-all duration-300 cursor-help" title="{{ $d->surat->perihal ?? 'Tidak ada perihal' }}">
                                                        {{ $d->surat->perihal ?? 'Tidak ada perihal' }}
                                                    </p>
                                                </div>

                                                <div class="pt-1.5 border-t border-dashed border-slate-200 flex items-center justify-between">
                                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Tujuan:</span>
                                                    <span class="inline-flex items-center justify-center bg-blue-600 text-white font-black text-[9px] px-2 py-0.5 rounded-full shadow-sm">
                                                        {{ $rowCount }} orang
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endif

                                    {{-- KOLOM 2: PENERIMA & PERAN TUJUAN --}}
                                    <td class="p-4 align-middle border-b border-slate-100">
                                        <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200 shadow-sm max-w-full md:max-w-xs">
                                            <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-[10px] text-white shrink-0 shadow-sm">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>

                                            <div class="space-y-0.5 min-w-0 flex-1">
                                                <p class="text-xs font-bold text-slate-900 tracking-tight leading-tight block truncate" title="{{ $d->penerima->nama ?? 'N/A' }}">
                                                    {{ $d->penerima->nama ?? 'N/A' }}
                                                </p>

                                                <div class="flex items-center gap-1">
                                                    <span class="px-1.5 py-0.5 text-[7.5px] font-black uppercase rounded tracking-wider border shadow-sm shrink-0
                                        {{ $d->peran == 'pelaksana' 
                                            ? 'bg-rose-50 text-rose-600 border-rose-100' 
                                            : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                                                        {{ $d->peran }}
                                                    </span>

                                                    @if(!empty($d->ketua_tim) && $d->ketua_tim !== 'NULL')
                                                    <span class="px-1.5 py-0.5 text-[7.5px] font-extrabold uppercase rounded tracking-wider border bg-slate-50 text-slate-600 border-slate-200 max-w-[100px] truncate" title="Ketua Tim: {{ $d->ketua_tim }}">
                                                        Tim: {{ $d->ketua_tim }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KOLOM 3: INSTRUKSI / CATATAN --}}
                                    <td class="p-4 align-middle border-b border-slate-100">
                                        <div class="flex flex-wrap gap-1 max-w-[260px]">
                                            @if($d->catatan)
                                            @foreach(explode(',', explode('|', $d->catatan)[0]) as $part)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-[9px] font-medium tracking-tight max-w-full break-all">
                                                {{ trim($part) }}
                                            </span>
                                            @endforeach
                                            @else
                                            <span class="text-[9px] font-black uppercase text-slate-300 italic tracking-widest">No Instruction</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- KOLOM 4: STATUS UPDATE --}}
                                    <td class="p-4 text-center align-middle whitespace-nowrap border-b border-slate-100">
                                        <div class="inline-block text-left">
                                            @if($isAdminSekret)
                                            <div x-data="{ 
                                open: false, 
                                currentStatus: '{{ $d->status }}',
                                peran: '{{ $d->peran }}',
                                getColorClass(status) {
                                    if(status === 'pending') return 'bg-amber-500';
                                    if(status === 'sedang dilaksanakan' || status === 'diproses') return 'bg-blue-500';
                                    if(status === 'selesai dilaksanakan' || status === 'sudah dibaca') return 'bg-emerald-500';
                                    return 'bg-slate-500';
                                },
                                getBgClass(status) {
                                    if(status === 'pending') return 'bg-amber-50 text-amber-700 border-amber-200 hover:border-amber-400';
                                    if(status === 'sedang dilaksanakan' || status === 'diproses') return 'bg-blue-50 text-blue-700 border-blue-200 hover:border-blue-400';
                                    if(status === 'selesai dilaksanakan' || status === 'sudah dibaca') return 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:border-emerald-400';
                                    return 'bg-slate-50 text-slate-700 border-slate-200';
                                }
                             }"
                                                @click.away="open = false"
                                                class="relative inline-block text-left">

                                                <form id="form-status-{{ $d->id }}" action="{{ route('adminsekret.disposisi.updateStatus', $d->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" :value="currentStatus">
                                                </form>

                                                <button @click="open = !open" type="button" :class="getBgClass(currentStatus)"
                                                    class="inline-flex items-center justify-between gap-2.5 px-3 py-1.5 rounded-xl border text-[10px] font-black uppercase tracking-wider italic shadow-sm min-w-[160px] active:scale-95">
                                                    <span class="flex items-center gap-1.5">
                                                        <span :class="getColorClass(currentStatus)" class="w-1.5 h-1.5 rounded-full animate-pulse"></span>
                                                        <span x-text="currentStatus"></span>
                                                    </span>
                                                    <i class="fa-solid fa-chevron-down text-[7px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                                                </button>

                                                <div x-show="open" x-transition class="absolute z-50 mt-1 w-48 rounded-xl bg-slate-900 border border-slate-800 p-1 shadow-xl left-1/2 -translate-x-1/2 whitespace-nowrap" style="display: none;">
                                                    <div class="space-y-0.5">
                                                        <button @click="currentStatus = 'pending'; open = false; $nextTick(() => document.getElementById('form-status-{{ $d->id }}').submit())" type="button" class="w-full flex items-center gap-2 px-2.5 py-1.5 text-[9px] font-black uppercase italic tracking-wide text-amber-400 hover:bg-amber-500/10 rounded-lg transition-all">
                                                            <span class="w-1 h-1 rounded-full bg-amber-500"></span> Pending
                                                        </button>

                                                        <template x-if="peran === 'pelaksana'">
                                                            <div class="space-y-0.5 pt-0.5 border-t border-slate-800/60">
                                                                <button @click="currentStatus = 'sedang dilaksanakan'; open = false; $nextTick(() => document.getElementById('form-status-{{ $d->id }}').submit())" type="button" class="w-full flex items-center gap-2 px-2.5 py-1.5 text-[9px] font-black uppercase italic tracking-wide text-blue-400 hover:bg-blue-500/10 rounded-lg transition-all">
                                                                    <span class="w-1 h-1 rounded-full bg-blue-500"></span> Sedang Dilaksanakan
                                                                </button>
                                                                <button @click="currentStatus = 'selesai dilaksanakan'; open = false; $nextTick(() => document.getElementById('form-status-{{ $d->id }}').submit())" type="button" class="w-full flex items-center gap-2 px-2.5 py-1.5 text-[9px] font-black uppercase italic tracking-wide text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition-all">
                                                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Selesai Dilaksanakan
                                                                </button>
                                                            </div>
                                                        </template>

                                                        <template x-if="peran === 'pemantau'">
                                                            <div class="space-y-0.5 pt-0.5 border-t border-slate-800/60">
                                                                <button @click="currentStatus = 'diproses'; open = false; $nextTick(() => document.getElementById('form-status-{{ $d->id }}').submit())" type="button" class="w-full flex items-center gap-2 px-2.5 py-1.5 text-[9px] font-black uppercase italic tracking-wide text-blue-400 hover:bg-blue-500/10 rounded-lg transition-all">
                                                                    <span class="w-1 h-1 rounded-full bg-blue-500"></span> Diproses
                                                                </button>
                                                                <button @click="currentStatus = 'sudah dibaca'; open = false; $nextTick(() => document.getElementById('form-status-{{ $d->id }}').submit())" type="button" class="w-full flex items-center gap-2 px-2.5 py-1.5 text-[9px] font-black uppercase italic tracking-wide text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition-all">
                                                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Sudah Dibaca
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl border text-[9px] font-black uppercase tracking-wider italic shadow-sm
                                {{ $d->status === 'pending' ? 'bg-amber-50/60 text-amber-700 border-amber-200' : '' }}
                                {{ in_array($d->status, ['sedang dilaksanakan', 'diproses']) ? 'bg-blue-50/60 text-blue-700 border-blue-200' : '' }}
                                {{ in_array($d->status, ['selesai dilaksanakan', 'sudah dibaca']) ? 'bg-emerald-50/60 text-emerald-700 border-emerald-200' : '' }}">
                                                <span class="w-1 h-1 rounded-full 
                                    {{ $d->status === 'pending' ? 'bg-amber-500' : '' }}
                                    {{ in_array($d->status, ['sedang dilaksanakan', 'diproses']) ? 'bg-blue-500' : '' }}
                                    {{ in_array($d->status, ['selesai dilaksanakan', 'sudah dibaca']) ? 'bg-emerald-500' : '' }}">
                                                </span>
                                                {{ $d->status }}
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- KOLOM 5: AKSI --}}
                                    <td class="p-4 align-middle text-center whitespace-nowrap border-b border-slate-100">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="$dispatch('open-detail', { id: {{ $d->id }}, is_balasan: false, file_url: '{{ $d->file_disposisi ? asset('uploads/surat_disposisi/' . $d->file_disposisi) : '' }}' })" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-sm flex items-center justify-center active:scale-90">
                                                <i class="fa-solid fa-eye text-[10px]"></i>
                                            </button>
                                            <button @click="$dispatch('open-edit', { id: '{{ $d->id }}', surat_id: '{{ $d->surat_id }}', ke_admin: '{{ $d->ke_admin }}', catatan: '{{ addslashes($d->catatan) }}', peran: '{{ $d->peran }}', ketua_tim: '{{ $d->ketua_tim }}', file_url: '{{ $d->file_disposisi ? asset('uploads/surat_disposisi/' . $d->file_disposisi) : '' }}' })" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-amber-600 hover:bg-amber-500 hover:text-white transition-all duration-200 shadow-sm flex items-center justify-center active:scale-90">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                            </button>

                                            {{-- FORM HAPUS DAN TOMBOL --}}
                                            <form id="delete-disposisi-{{ $d->id }}" action="{{ route('admindivisi.disposisi.destroy', $d->id) }}" method="POST" class="inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete('{{ $d->id }}')" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200 shadow-sm flex items-center justify-center active:scale-90">
                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- PERBAIKAN UTAMA: Baris Spacer Transparan Khusus Antar Kelompok Surat --}}
                                @if($isLastRowInGroup)
                                <tr class="bg-slate-100/50 h-3.5">
                                    <td colspan="5" class="p-0 border-none"></td>
                                </tr>
                                @endif

                                @endforeach
                                @endforeach

                                @if(!$hasData)
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400 italic text-xs">Belum ada data disposisi.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- BAGIAN TABEL BALASAN SURAT --}}
                <div class="space-y-6" x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-[500ms]" x-transition:enter-start="opacity-0 translate-y-8">
                    <div class="group px-2">
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase italic flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            Surat Balasan Disposisi
                        </h2>
                        <p class="text-xs text-slate-500 font-medium ml-6 uppercase tracking-[0.1em] transition-all group-hover:ml-8 group-hover:text-emerald-500">Monitoring Feedback & Progress dari Divisi</p>
                    </div>

                    <div class="bg-white rounded-[40px] overflow-hidden border-2 border-slate-300 shadow-2xl shadow-slate-200/60 transition-all duration-500">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="bg-slate-900">
                                        <th class="p-6 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] italic">No. Surat & Waktu</th>
                                        <th class="p-6 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] italic">Dari Divisi</th>
                                        <th class="p-6 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] italic text-center">Status</th>
                                        <th class="p-6 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] italic text-center">Dokumen</th>
                                        <th class="p-6 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] italic text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @php $hasBalasanData = false; @endphp

                                    @foreach($balasan_disposisi->groupBy('surat_id') as $suratId => $groupBalasan)
                                    @php
                                    $hasBalasanData = true;
                                    $rowCount = $groupBalasan->count();
                                    @endphp

                                    @foreach($groupBalasan as $index => $balasan)
                                    @php
                                    $isLastRowInGroup = ($index === $rowCount - 1);
                                    @endphp
                                    <tr class="hover:bg-emerald-50/40 transition-all duration-300 group/row {{ $isLastRowInGroup ? 'border-b-4 border-slate-400/80' : 'border-b border-slate-100' }}">

                                        {{-- KOLOM 1: NO SURAT & WAKTU (ROWSPAN) --}}
                                        @if($index === 0)
                                        <td class="p-6 align-middle border-r-2 border-slate-200 bg-slate-50/50 shadow-[inner_2px_0_0_0_rgba(0,0,0,0.05)]" rowspan="{{ $rowCount }}">
                                            <div class="flex flex-col items-center text-center py-2">
                                                <div class="inline-block bg-white border border-slate-300 rounded-xl px-3 py-1.5 shadow-sm">
                                                    <span class="text-xs font-black text-slate-800 tracking-tight group-hover/row:text-emerald-600 transition-colors">
                                                        {{ $balasan->surat->no_surat ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-center gap-2 mt-2">
                                                    <div class="h-[2px] w-3 bg-emerald-500 rounded-full"></div>
                                                    <span class="text-[9px] text-slate-400 uppercase font-black tracking-tighter italic">
                                                        {{ $balasan->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        @endif

                                        {{-- KOLOM 2: DARI DIVISI (RESPONSIF & ANTILUBER) --}}
                                        <td class="p-6 align-middle">
                                            <div class="flex items-center gap-4 max-w-xs">
                                                <div class="w-10 h-10 shrink-0 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover/row:bg-emerald-500 group-hover/row:text-white transition-all duration-500 group-hover/row:-rotate-6">
                                                    <i class="fa-solid fa-reply-all text-xs"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-slate-900 tracking-tight truncate max-w-[180px] sm:max-w-[240px]" title="{{ $balasan->penerima->nama ?? 'Unknown' }}">
                                                        {{ $balasan->penerima->nama ?? 'Unknown' }}
                                                    </p>
                                                    <p class="text-[9px] text-slate-500 uppercase font-black tracking-tighter mt-0.5 truncate max-w-[180px]" title="{{ $balasan->penerima->role ?? 'Staff Divisi' }}">
                                                        {{ $balasan->penerima->role ?? 'Staff Divisi' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- KOLOM 3: STATUS BALASAN --}}
                                        <td class="p-6 text-center align-middle">
                                            <span class="px-3 py-1.5 text-[9px] font-black rounded-xl uppercase italic shadow-sm inline-block tracking-wider
        {{ in_array($balasan->status, ['selesai dilaksanakan', 'sudah dibaca']) ? 'bg-emerald-500 text-white shadow-emerald-500/10' : 'bg-blue-500 text-white shadow-blue-500/10' }}">
                                                {{ $balasan->status }}
                                            </span>
                                        </td>

                                        {{-- KOLOM 4: DOKUMEN (FILE TIDAK WAJIB ADA) --}}
                                        <td class="p-4 text-center align-middle whitespace-nowrap">
                                            @php
                                            // Kunci folder tujuan ke balasan_disposisi
                                            $folderPath = 'uploads/balasan_disposisi/';

                                            // Ambil nama file dari relasi balasan
                                            $fileBalasanNama = $balasan->balasan->file_balasan ?? null;
                                            $fileReady = !empty($fileBalasanNama);
                                            @endphp

                                            <div class="flex items-center justify-center">
                                                @if($fileReady)
                                                {{-- TOMBOL NAMA FILE (RAPI & AMAN DARI TEKS PANJANG) --}}
                                                <a href="{{ asset($folderPath . $fileBalasanNama) }}" target="_blank" title="{{ $fileBalasanNama }}"
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:border-emerald-500 hover:text-emerald-600 hover:bg-emerald-50/30 transition-all duration-300 text-[10px] font-bold shadow-sm max-w-[220px]">

                                                    {{-- Ikon File --}}
                                                    <i class="fa-solid fa-file-lines text-emerald-500 text-xs shrink-0"></i>

                                                    {{-- Nama File yang dipotong rapi lewat span --}}
                                                    <span class="truncate tracking-wide block text-left">
                                                        {{ $fileBalasanNama }}
                                                    </span>
                                                </a>
                                                @else
                                                {{-- TAMPILAN JIKA TIDAK ADA FILE --}}
                                                <span class="text-[10px] font-semibold text-slate-400 italic tracking-wider inline-flex items-center gap-1.5">
                                                    <i class="fa-solid fa-ban text-[9px] text-slate-300"></i>
                                                    Tidak Ada File
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        {{-- KOLOM 5: AKSI --}}
                                        <td class="p-6 text-center align-middle">
                                            @php
                                            $isSekretToSekret = ($balasan->penerima && str_contains(strtolower($balasan->penerima->role), 'sekretariat'));
                                            @endphp
                                            <button @click="$dispatch('open-detail', { 
                                id: {{ $balasan->id }},
                                is_balasan: true,
                                is_sekret: {{ $isSekretToSekret ? 'true' : 'false' }}
                            })"
                                                class="w-9 h-9 rounded-full bg-slate-50 text-slate-400 hover:bg-emerald-500 hover:text-white transition-all duration-500 hover:rotate-[360deg] flex items-center justify-center mx-auto shadow-inner active:scale-75">
                                                <i class="fa-solid fa-expand text-[10px]"></i>
                                            </button>
                                        </td>

                                    </tr>
                                    @endforeach
                                    @endforeach

                                    {{-- BLOK EMPTY --}}
                                    @if(!$hasBalasanData)
                                    <tr>
                                        <td colspan="5" class="p-32 text-center">
                                            <div class="flex flex-col items-center gap-6 group">
                                                <div class="relative">
                                                    <i class="fa-solid fa-inbox text-8xl text-slate-100 group-hover:scale-110 transition-transform duration-700"></i>
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <i class="fa-solid fa-envelope-open text-3xl text-slate-200 animate-bounce"></i>
                                                    </div>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-[11px] font-black uppercase tracking-[0.5em] text-slate-300">Data Tidak Ditemukan</p>
                                                    <p class="text-xs text-slate-400 italic font-medium">Belum ada balasan disposisi untuk ditampilkan saat ini.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                @keyframes spin-slow {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }

                .fa-spin-slow {
                    animation: spin-slow 3s linear infinite;
                }

                /* Smooth Scrollbar for Table */
                .overflow-x-auto::-webkit-scrollbar {
                    height: 6px;
                }

                .overflow-x-auto::-webkit-scrollbar-track {
                    background: #f1f5f9;
                    border-radius: 10px;
                }

                .overflow-x-auto::-webkit-scrollbar-thumb {
                    background: #cbd5e1;
                    border-radius: 10px;
                }

                .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                    background: #94a3b8;
                }
            </style>


            <footer class="p-8 text-center text-slate-700 border-t border-white/5 mt-10">
                <p class="text-[10px] font-bold uppercase tracking-[0.8em] opacity-40">© 2026 TVRI Sumatera Utara</p>
            </footer>

            <div x-data="{ 
        showDetail: false, 
        isLoading: false,
        detailData: {}, 
        isBalasanMode: false,
        isSekretToSekret: false,
        
        async fetchDetail(id, is_balasan = false, is_sekret = false) {
            this.showDetail = true;
            this.isLoading = true;
            this.isBalasanMode = is_balasan;
            this.isSekretToSekret = is_sekret;
            this.detailData = {}; 
            
            try {
                const response = await fetch('/disposisi-sekretariat/' + id);
                if (!response.ok) throw new Error('Server Error');
                const data = await response.json();
                
                this.detailData = data;
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.isLoading = false;
            }
        }
    }"
                @open-detail.window="fetchDetail($event.detail.id, $event.detail.is_balasan || false, $event.detail.is_sekret || false)"
                class="relative">

                <template x-teleport="body">
                    <div x-show="showDetail"
                        x-cloak
                        class="fixed inset-0 top-0 left-0 w-screen h-screen z-[9999] flex items-center justify-center p-4 sm:p-6 overflow-hidden">

                        <div x-show="showDetail"
                            x-transition.opacity.duration.400ms
                            @click="showDetail = false"
                            class="fixed inset-0 w-full h-full bg-slate-950/95 backdrop-blur-xl"></div>

                        <div x-show="showDetail"
                            x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="bg-slate-900 border border-white/10 w-full max-w-2xl rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10 text-white flex flex-col max-h-[85vh] mx-auto">

                            {{-- MODAL HEADER --}}
                            <div class="px-8 py-6 border-b border-white/5 bg-blue-500/5 flex justify-between items-center flex-shrink-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-400">
                                        <i class="fa-solid fa-circle-info text-xl" :class="isLoading ? 'animate-pulse' : ''"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-black uppercase text-xs tracking-widest Boyd-none text-blue-400"
                                            x-text="isBalasanMode ? 'Data Balasan Detail' : 'Data Disposisi Detail'"></h3>
                                        <p class="text-[10px] text-slate-500 font-bold mt-1" x-text="'Hash ID: #' + (detailData.id || '-')"></p>
                                    </div>
                                </div>
                                <button @click="showDetail = false" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/5 text-slate-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>

                            {{-- MODAL BODY --}}
                            <div class="p-8 overflow-y-auto custom-scrollbar flex-1 space-y-8 bg-slate-900/50">

                                <div x-show="isLoading" class="flex flex-col items-center justify-center py-20 gap-4">
                                    <div class="w-10 h-10 border-2 border-blue-500/20 border-t-blue-500 rounded-full animate-spin"></div>
                                    <span class="text-[10px] text-slate-500 font-black uppercase tracking-widest animate-pulse">Decrypting Data...</span>
                                </div>

                                <div x-show="!isLoading" class="space-y-8" x-transition.opacity>

                                    <div class="grid grid-cols-2 gap-8">
                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-blue-400/80 uppercase tracking-widest block">No. Registrasi Surat</label>
                                            <p class="font-black text-sm text-white" x-text="detailData.surat?.no_surat || 'N/A'"></p>
                                        </div>
                                        <div class="space-y-1 text-right">
                                            <label class="text-[9px] font-black text-emerald-400/80 uppercase tracking-widest block">Alur Disposisi</label>
                                            <span class="inline-block px-3 py-1 border text-[9px] font-black rounded-full uppercase italic transition-colors duration-300"
                                                :class="{
                        'bg-emerald-500/10 border-emerald-500/20 text-emerald-400': detailData.status === 'selesai dilaksanakan' || detailData.status === 'sudah dibaca',
                        'bg-slate-500/10 border-slate-500/20 text-slate-400': !['selesai dilaksanakan', 'sudah dibaca'].includes(detailData.status)
                    }"
                                                x-text="detailData.status || 'Pending'">
                                            </span>
                                        </div>
                                    </div>

                                    {{-- ORIGIN & DESTINATION --}}
                                    <div class="bg-white/[0.02] border border-white/5 rounded-[2rem] p-6 relative overflow-hidden group">
                                        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
                                        <div class="flex items-start justify-between gap-6">
                                            <div class="flex-1 space-y-1">
                                                <p class="text-[8px] text-slate-500 font-bold uppercase tracking-wider">Origin (Pengirim)</p>
                                                <p class="text-xs text-white font-black" x-text="detailData.dari_admin?.nama || 'Administrator'"></p>
                                                <span class="inline-block px-2 py-0.5 text-[8px] font-black uppercase rounded bg-slate-800 text-slate-400 border border-white/5">Sistem Utama</span>
                                            </div>
                                            <div class="flex flex-col items-center pt-3">
                                                <i class="fa-solid fa-arrow-right-long text-blue-500/40"></i>
                                            </div>
                                            <div class="flex-1 text-right space-y-1.5 flex flex-col items-end">
                                                <div>
                                                    <p class="text-[8px] text-blue-400/80 font-bold uppercase tracking-wider mb-1">Destination (Penerima)</p>
                                                    <p class="text-xs font-black text-white" x-text="detailData.penerima?.nama || 'N/A'"></p>
                                                </div>
                                                <div class="flex flex-wrap justify-end gap-1.5 pt-0.5">
                                                    <span class="px-2 py-0.5 text-[8px] font-black uppercase rounded-lg tracking-wider border shadow-sm"
                                                        :class="detailData.peran === 'pelaksana' ? 'bg-rose-500/10 text-rose-400 border-rose-500/20' : 'bg-blue-500/10 text-blue-400 border-blue-500/20'">
                                                        <span x-text="detailData.peran || 'N/A'"></span>
                                                    </span>
                                                    <template x-if="detailData.ketua_tim && detailData.ketua_tim !== 'NULL' && detailData.ketua_tim !== ''">
                                                        <span class="px-2 py-0.5 text-[8px] font-black uppercase rounded-lg tracking-wider bg-white text-slate-900 border border-white shadow-sm flex items-center gap-1">
                                                            <i class="fa-solid fa-crown text-[7px] text-amber-500"></i>
                                                            Tim: <span x-text="detailData.ketua_tim"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SECTION: INSTRUKSI / CATATAN BALASAN --}}
                                    <div class="space-y-4">
                                        <label class="text-[9px] font-black text-amber-500 uppercase tracking-widest block ml-1"
                                            x-text="isBalasanMode ? 'Catatan Balasan Dari Divisi' : 'Instruksi & Catatan Disposisi'"></label>

                                        <div class="space-y-3">
                                            <template x-if="isBalasanMode">
                                                <div class="bg-slate-950/50 border-l-2 border-emerald-500 p-4 rounded-r-xl shadow-inner">
                                                    <span class="text-[8px] font-bold text-emerald-400 uppercase block mb-1">Pesan Progres / Balasan:</span>
                                                    <p class="text-[11px] text-slate-300 leading-relaxed font-medium"
                                                        x-text="detailData.balasan?.pesan_balasan || 'Sudah diselesaikan dilaksanakan (Tanpa deskripsi tambahan).'"></p>
                                                </div>
                                            </template>

                                            <template x-if="!isBalasanMode && detailData.catatan">
                                                <div class="space-y-3">
                                                    <div class="flex flex-wrap gap-2">
                                                        <template x-for="item in (detailData.catatan.includes('|') ? detailData.catatan.split('|')[0].split(',') : detailData.catatan.split(','))" :key="item">
                                                            <template x-if="item.trim() !== ''">
                                                                <span class="px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 rounded-lg text-[10px] font-bold text-amber-200 inline-flex items-center">
                                                                    <i class="fa-solid fa-check-double mr-2 text-amber-500"></i>
                                                                    <span x-text="item.trim()"></span>
                                                                </span>
                                                            </template>
                                                        </template>
                                                    </div>
                                                    <template x-if="detailData.catatan.includes('|')">
                                                        <div class="bg-slate-950/50 border-l-2 border-amber-500 p-4 rounded-r-xl shadow-inner">
                                                            <span class="text-[8px] font-bold text-slate-500 uppercase block mb-1">Catatan Tambahan:</span>
                                                            <p class="text-[11px] text-slate-300 leading-relaxed font-medium" x-text="detailData.catatan.split('|')[1].replace('Catatan:', '').trim()"></p>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>

                                            <template x-if="!isBalasanMode && !detailData.catatan">
                                                <div class="flex items-center gap-2 py-2">
                                                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                                    <p class="text-[10px] text-slate-500 italic font-medium">Tidak ada instruksi atau catatan khusus.</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- SECTION: DOKUMEN LAMPIRAN --}}
                                    <div class="space-y-3">
                                        <label class="text-[9px] font-black text-blue-400 uppercase tracking-widest block ml-1">Dokumen Lampiran Berkas</label>

                                        <template x-if="isBalasanMode && detailData.balasan?.file_balasan && detailData.balasan.file_balasan !== 'NULL' && detailData.balasan.file_balasan !== ''">
                                            <div class="bg-slate-950/60 border border-white/5 rounded-2xl p-4 flex items-center justify-between group hover:border-emerald-500/30 transition-all shadow-inner">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                                        <i class="fa-solid fa-file-pdf text-lg"></i>
                                                    </div>
                                                    <div class="overflow-hidden">
                                                        <p class="text-[10px] font-black text-white truncate max-w-[180px] sm:max-w-[250px]" x-text="detailData.balasan.file_balasan"></p>
                                                        <p class="text-[8px] text-slate-500 font-bold uppercase">Feedback Copy (Divisi / Balasan)</p>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a :href="'/uploads/balasan_disposisi/' + detailData.balasan.file_balasan" target="_blank" class="h-9 w-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all shadow-lg">
                                                        <i class="fa-solid fa-eye text-xs"></i>
                                                    </a>
                                                    <a :href="'/uploads/balasan_disposisi/' + detailData.balasan.file_balasan" :download="detailData.balasan.file_balasan" class="h-9 px-4 rounded-lg bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest flex items-center gap-2 hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">
                                                        <i class="fa-solid fa-download"></i>
                                                        <span class="hidden sm:inline">Download</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="!isBalasanMode && detailData.file_disposisi && detailData.file_disposisi !== 'NULL' && detailData.file_disposisi !== ''">
                                            <div class="bg-slate-950/60 border border-white/5 rounded-2xl p-4 flex items-center justify-between group hover:border-blue-500/30 transition-all shadow-inner">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500">
                                                        <i class="fa-solid fa-file-pdf text-lg"></i>
                                                    </div>
                                                    <div class="overflow-hidden">
                                                        <p class="text-[10px] font-black text-white truncate max-w-[180px] sm:max-w-[250px]" x-text="detailData.file_disposisi"></p>
                                                        <p class="text-[8px] text-slate-500 font-bold uppercase">Digital Copy (Sekretariat / Surat Disposisi)</p>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a :href="'/uploads/surat_disposisi/' + detailData.file_disposisi" target="_blank" class="h-9 w-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all shadow-lg">
                                                        <i class="fa-solid fa-eye text-xs"></i>
                                                    </a>
                                                    <a :href="'/uploads/surat_disposisi/' + detailData.file_disposisi" :download="detailData.file_disposisi" class="h-9 px-4 rounded-lg bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest flex items-center gap-2 hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">
                                                        <i class="fa-solid fa-download"></i>
                                                        <span class="hidden sm:inline">Download</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="(isBalasanMode && (!detailData.balasan?.file_balasan || detailData.balasan.file_balasan === 'NULL' || detailData.balasan.file_balasan === '')) || (!isBalasanMode && (!detailData.file_disposisi || detailData.file_disposisi === 'NULL' || detailData.file_disposisi === ''))">
                                            <div class="bg-slate-950/30 border border-dashed border-white/5 rounded-2xl p-5 flex items-center justify-center gap-3 text-slate-500">
                                                <i class="fa-solid fa-ban text-xs text-slate-600"></i>
                                                <span class="text-[10px] font-black uppercase tracking-wider italic text-slate-400"
                                                    x-text="isBalasanMode ? 'Tidak Ada File Berkas Balasan Yang Dilampirkan' : 'Tidak Ada File Berkas Disposisi Yang Dilampirkan'"></span>
                                            </div>
                                        </template>
                                    </div>

                                </div>
                            </div>

                            <div class="px-8 py-4 bg-slate-950/20 border-t border-white/5 flex justify-center flex-shrink-0">
                                <div class="w-12 h-1 bg-white/10 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>


            @php
            // Definisi variabel agar tidak undefined
            $list_instruksi = [
            'Diteliti / Diselesaikan', 'Dipertimbangkan', 'Untuk Diketahui',
            'Mewakili / Menghadiri', 'Dikoordinasikan', 'Ditampung Masalahnya',
            'Peringatkan / Pendekatan', 'Pendapat / Analisa', 'Konsep Jawaban',
            'Konsep Laporan', 'Data Diolah', 'Ditindaklanjuti',
            'Diagendakan', 'Harap Dibantu'
            ];
            @endphp

            <div x-data="{ 
        showEdit: false, 
        editData: { 
            id: '', 
            surat_id: '', 
            penerima_ids: [], 
            instruksi: [], 
            catatan: '',
            peran: 'pelaksana',
            ketua_tim: '',
            file_url: '' 
        },
        openSurat: false,
        searchTermSurat: '',
        isUploading: false,
        fileName: '',
        
        // Data pendukung dari backend
        suratTersedia: {{ $surat_tersedia->map(fn($s) => ['id' => $s->id, 'no' => $s->no_surat, 'status' => $s->status])->toJson() }},
        admins: {{ $admin_divisi->map(fn($u) => ['id' => $u->id, 'nama' => $u->nama, 'role' => $u->role])->toJson() }},

        get filteredSurat() {
            if (!this.searchTermSurat) return this.suratTersedia;
            return this.suratTersedia.filter(s => s.no.toLowerCase().includes(this.searchTermSurat.toLowerCase()));
        },

        get selectedSuratLabel() {
            let found = this.suratTersedia.find(s => s.id == this.editData.surat_id);
            return found ? found.no : 'Pilih Surat...';
        }
    }"
                @open-edit.window="
        showEdit = true; 
        
        // --- LOGIC PARSING DATA DARI DATABASE KE ALPINE ---
        let rawCatatan = $event.detail.catatan || '';
        let bagianInstruksi = '';
        let bagianTeksCatatan = '';

        // Jika catatan mengandung pemisah ' | Catatan: '
        if (rawCatatan.includes(' | Catatan: ')) {
            let splitCatatan = rawCatatan.split(' | Catatan: ');
            bagianInstruksi = splitCatatan[0];
            bagianTeksCatatan = splitCatatan[1];
        } else {
            // Asumsi jika tidak ada pemisah, seluruh isi adalah teks instruksi atau teks catatan biasa
            if (rawCatatan.includes(',') || ['Peringatkan / Pendekatan', 'Konsep Jawaban', 'Data Diolah', 'Ditindaklanjuti'].some(v => rawCatatan.includes(v))) {
                bagianInstruksi = rawCatatan;
                bagianTeksCatatan = '';
            } else {
                bagianInstruksi = '';
                bagianTeksCatatan = rawCatatan;
            }
        }

        editData = {
            id: $event.detail.id,
            surat_id: $event.detail.surat_id,
            // Mengubah ke_admin dari DB (tunggal) menjadi array string agar checkbox sinkron
            penerima_ids: $event.detail.ke_admin ? [$event.detail.ke_admin.toString()] : [],
            // Memisahkan string instruksi berkoma menjadi array murni
            instruksi: bagianInstruksi ? bagianInstruksi.split(', ') : [],
            catatan: bagianTeksCatatan,
            peran: $event.detail.peran || 'pelaksana',
            ketua_tim: $event.detail.ketua_tim || '',
            file_url: $event.detail.file_url || ''
        };
        isUploading = false;
        fileName = '';
    "
                x-show="showEdit"
                x-cloak
                x-effect="document.body.style.overflow = showEdit ? 'hidden' : 'auto'"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6">

                <div x-show="showEdit"
                    x-transition.opacity.duration.500ms
                    @click="showEdit = false"
                    class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl"></div>

                <div class="bg-slate-900 border border-white/10 w-full max-w-2xl rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10 max-h-[90vh] flex flex-col"
                    x-show="showEdit"
                    x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-10"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    <div class="relative px-8 py-6 flex-shrink-0 border-b border-white/5">
                        <div class="flex justify-between items-center relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0">
                                    <div class="absolute inset-0 bg-amber-500 rounded-xl blur-md opacity-20"></div>
                                    <div class="relative w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center">
                                        <i class="fa-solid fa-feather-pointed text-black text-xl"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-white font-black italic uppercase text-lg tracking-tighter leading-none">Revisi Disposisi</h3>
                                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-[0.3em] mt-1">Update Log ID: <span x-text="editData.id"></span></p>
                                </div>
                            </div>
                            <button @click="showEdit = false" type="button" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/5 text-slate-500 hover:text-white transition-all">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <form :action="'/disposisi-sekretariat/' + editData.id"
                        method="POST"
                        @submit="if(!editData.id) { $event.preventDefault(); return false; }"
                        enctype="multipart/form-data"
                        class="flex-1 overflow-y-auto px-8 py-6 space-y-8 scrollbar-hide">

                        @csrf
                        <input type="hidden" name="_method" :value="editData.id ? 'PUT' : 'POST'">

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Arsip Surat</label>
                            <div class="relative">
                                <button type="button" @click="openSurat = !openSurat"
                                    class="w-full bg-slate-950/50 border border-white/5 rounded-2xl px-6 py-4 text-sm flex justify-between items-center hover:border-amber-500/30 transition-all">
                                    <span class="font-bold italic text-white" x-text="selectedSuratLabel"></span>
                                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="openSurat ? 'rotate-180' : ''"></i>
                                </button>
                                <input type="hidden" name="surat_id" x-model="editData.surat_id">

                                <div x-show="openSurat" @click.away="openSurat = false" class="absolute z-[160] w-full mt-2 bg-slate-800 border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
                                    <div class="p-2 border-b border-white/5">
                                        <input type="text" x-model="searchTermSurat" placeholder="Cari surat..." class="w-full bg-slate-900 border-none rounded-lg px-4 py-2 text-xs text-white outline-none">
                                    </div>
                                    <div class="max-h-40 overflow-y-auto">
                                        <template x-for="surat in filteredSurat" :key="surat.id">
                                            <button type="button" @click="editData.surat_id = surat.id; openSurat = false"
                                                class="w-full text-left px-5 py-3 text-xs text-slate-300 hover:bg-amber-500 hover:text-black transition-all border-b border-white/5 last:border-0">
                                                <span x-text="surat.no"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Delegasi Ke</label>
                            <div class="grid grid-cols-2 gap-3">
                                <template x-for="admin in admins" :key="admin.id">
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="ke_admin[]" :value="admin.id" x-model="editData.penerima_ids" class="hidden">
                                        <div class="p-3 rounded-2xl border-2 transition-all flex flex-col gap-1"
                                            :class="editData.penerima_ids.includes(admin.id.toString()) ? 'bg-amber-500/10 border-amber-500' : 'bg-slate-800/30 border-white/5'">
                                            <span class="text-[10px] font-black text-white uppercase truncate" x-text="admin.nama"></span>
                                            <span class="text-[8px] text-slate-500 uppercase" x-text="admin.role"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-2xl bg-white/5 border border-white/5">
                            <div class="space-y-3" x-data="{ openPeran: false }">
                                <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Peran Kelompok</label>
                                <div class="relative">
                                    <button type="button" @click="openPeran = !openPeran" @click.away="openPeran = false"
                                        class="w-full bg-slate-950/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white text-left flex justify-between items-center hover:border-amber-500/30 transition-all outline-none focus:border-amber-500/50">
                                        <span class="capitalize font-medium tracking-wide" x-text="editData.peran || 'Pilih Peran...'"></span>
                                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 transition-transform duration-300" :class="openPeran ? 'rotate-180 text-amber-500' : ''"></i>
                                    </button>

                                    <input type="hidden" name="peran" x-model="editData.peran">

                                    <div x-show="openPeran"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                        class="absolute z-[170] w-full mt-2 bg-slate-950 border border-white/10 rounded-xl shadow-2xl overflow-hidden backdrop-blur-xl">

                                        <div class="p-1.5 space-y-1">
                                            <button type="button" @click="editData.peran = 'pelaksana'; openPeran = false"
                                                class="w-full text-left px-3 py-2.5 text-xs rounded-lg transition-all flex items-center justify-between"
                                                :class="editData.peran === 'pelaksana' ? 'bg-amber-500 text-black font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white'">
                                                <span>Pelaksana</span>
                                                <i x-show="editData.peran === 'pelaksana'" class="fa-solid fa-check text-[10px]"></i>
                                            </button>

                                            <button type="button" @click="editData.peran = 'pemantau'; openPeran = false"
                                                class="w-full text-left px-3 py-2.5 text-xs rounded-lg transition-all flex items-center justify-between"
                                                :class="editData.peran === 'pemantau' ? 'bg-amber-500 text-black font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white'">
                                                <span>Pemantau</span>
                                                <i x-show="editData.peran === 'pemantau'" class="fa-solid fa-check text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Ketua Tim (Opsional)</label>
                                <input type="text" name="ketua_tim" x-model="editData.ketua_tim" placeholder="Nama Ketua Tim..."
                                    class="w-full bg-slate-950/50 border border-white/5 rounded-xl px-4 py-3 text-xs text-white outline-none transition-all placeholder:text-slate-600 focus:border-amber-500/50 focus:bg-slate-950">
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Instruksi</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($list_instruksi as $item)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="instruksi[]" value="{{ $item }}" x-model="editData.instruksi" class="hidden">
                                    <div class="px-4 py-2 rounded-xl border text-[9px] font-bold transition-all flex items-center gap-2"
                                        :class="editData.instruksi.includes('{{ $item }}') ? 'bg-amber-500 text-black border-transparent' : 'bg-slate-800/40 border-white/5 text-slate-400'">
                                        <i class="fa-solid" :class="editData.instruksi.includes('{{ $item }}') ? 'fa-circle-check' : 'fa-circle opacity-20'"></i>
                                        <span class="truncate">{{ $item }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Catatan Tambahan</label>
                                <textarea name="catatan" x-model="editData.catatan" rows="4" class="w-full bg-slate-950/50 border border-white/5 rounded-2xl px-5 py-4 text-xs text-white outline-none focus:border-amber-500/50 resize-none"></textarea>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-amber-500/80 uppercase tracking-[0.2em] px-1">Update Lampiran (Opsional)</label>
                                <div class="relative h-[105px] group">
                                    <input type="file" name="file_disposisi" accept=".pdf,.doc,.docx"
                                        @change="const file = $event.target.files[0]; if(file) { isUploading = true; fileName = file.name; }"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="h-full border-2 border-dashed rounded-2xl flex flex-col items-center justify-center transition-all bg-slate-950/20"
                                        :class="isUploading ? 'border-amber-500 bg-amber-500/5' : 'border-white/5 group-hover:border-amber-500/30'">
                                        <i class="fa-solid" :class="isUploading ? 'fa-file-circle-check text-amber-500' : 'fa-cloud-arrow-up text-slate-700'"></i>
                                        <p class="text-[8px] font-black uppercase mt-2 text-slate-500" x-text="isUploading ? fileName : 'Ganti File (Max 1MB)'"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4 pb-2">
                            <button type="button" @click="showEdit = false" class="flex-1 py-4 text-slate-500 font-black text-[10px] uppercase tracking-widest hover:text-white transition-all">
                                Batal
                            </button>
                            <button type="submit" class="flex-[2] relative group overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-600 rounded-2xl"></div>
                                <div class="relative py-4 flex items-center justify-center gap-2 text-black font-black text-[10px] uppercase tracking-widest">
                                    Simpan Perubahan <i class="fa-solid fa-check-double"></i>
                                </div>
                            </button>
                        </div>
                    </form>

                    <div class="bg-black/20 px-8 py-3 flex justify-between items-center border-t border-white/5 flex-shrink-0">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></div>
                            <span class="text-[8px] text-slate-500 font-bold uppercase tracking-widest">Mode Penyuntingan Aktif</span>
                        </div>
                        <template x-if="editData.file_url">
                            <a :href="editData.file_url" target="_blank" class="text-[8px] text-amber-500 font-black uppercase hover:underline">Lihat File Lama</a>
                        </template>
                    </div>
                </div>
            </div>

            <template x-teleport="body">
                <div x-show="showModal"
                    x-cloak
                    x-effect="document.body.style.overflow = showModal ? 'hidden' : 'auto'"
                    @click.self="if (!isSubmitting) showModal = false"
                    class="fixed top-0 left-0 z-[9999] flex items-center justify-center w-full h-[100dvh] p-4 sm:p-6 bg-slate-950/90 backdrop-blur-md isolate"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">

                    <form action="{{ route('admin.disposisi.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        @submit="isSubmitting = true"
                        x-data="{ 
                selectedSurat: '', 
                selectedSuratLabel: 'Cari & Pilih Surat...', 
                openSurat: false,
                selectedAdmins: [],
                roles: {},
                teams: {},
                instruksi: [],
                isUploading: false,
                fileName: '',
                isSubmitting: false
            }"
                        class="relative w-full max-w-2xl bg-slate-900 border border-white/10 rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_30px_100px_rgba(0,0,0,0.8)] backdrop-blur-2xl flex flex-col overflow-hidden transition-all duration-500 z-50"
                        style="max-height: 90vh;">

                        @csrf

                        <div class="px-6 py-5 sm:px-10 sm:py-7 border-b border-white/5 bg-white/[0.02] flex items-center justify-between flex-shrink-0">
                            <div class="flex items-center gap-4 sm:gap-5">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-blue-500/20 rotate-3">
                                    <i class="fa-solid fa-feather-pointed text-white text-lg sm:text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg sm:text-xl font-black text-white tracking-tight uppercase italic">Disposisi Akselerasi</h2>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <p class="text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold">System Online</p>
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click="showModal = false" :disabled="isSubmitting" class="text-slate-500 hover:text-white transition-colors w-8 h-8 rounded-full hover:bg-white/5 flex items-center justify-center disabled:opacity-30">
                                <i class="fa-solid fa-xmark text-base sm:text-lg"></i>
                            </button>
                        </div>

                        <div class="flex-1 px-6 py-6 sm:px-10 sm:py-8 overflow-y-auto space-y-8 sm:space-y-10 scroll-smooth custom-scrollbar">

                            <div class="space-y-3 sm:space-y-4">
                                <div class="flex items-center gap-3 ml-1">
                                    <span class="w-6 sm:w-8 h-[2px] bg-blue-500"></span>
                                    <label class="text-[9px] sm:text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] sm:tracking-[0.4em]">Arsip Surat</label>
                                </div>

                                <div class="relative">
                                    <input type="hidden" name="surat_id" x-model="selectedSurat">
                                    <button type="button" @click.stop="if(!isSubmitting) openSurat = !openSurat"
                                        class="w-full bg-slate-800/40 border border-white/5 rounded-xl sm:rounded-2xl px-5 py-4 sm:px-6 sm:py-5 text-xs sm:text-sm flex justify-between items-center transition-all duration-300 hover:bg-slate-800/80 hover:border-blue-500/30"
                                        :class="openSurat ? 'ring-2 ring-blue-500/40 border-transparent bg-slate-800' : ''">
                                        <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0 mr-3">
                                            <i class="fa-solid fa-magnifying-glass text-blue-500/50 flex-shrink-0"></i>
                                            <span x-text="selectedSuratLabel" class="truncate w-full text-left" :class="selectedSurat ? 'text-white font-bold italic' : 'text-slate-500'"></span>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 transition-transform duration-500 flex-shrink-0" :class="openSurat ? 'rotate-90 text-blue-400' : ''"></i>
                                    </button>

                                    <div x-show="openSurat" x-cloak @click.away="openSurat = false"
                                        class="absolute z-[110] left-0 right-0 mt-2 sm:mt-3 bg-slate-800 border border-white/10 rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden backdrop-blur-xl">
                                        <div class="max-h-48 sm:max-h-52 overflow-y-auto p-2 sm:p-3 space-y-1">
                                            @foreach($surat_tersedia as $surat)
                                            <button type="button" @click="selectedSurat = '{{ $surat->id }}'; selectedSuratLabel = '{{ $surat->no_surat }}'; openSurat = false"
                                                class="w-full text-left p-3 sm:p-4 rounded-xl sm:rounded-2xl hover:bg-gradient-to-r hover:from-blue-600 hover:to-blue-500 transition-all group">
                                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 sm:gap-0">
                                                    <span class="text-[11px] sm:text-xs font-bold text-slate-300 group-hover:text-white truncate sm:break-normal">{{ $surat->no_surat }}</span>
                                                    <span class="text-[8px] px-2 py-1 rounded-lg bg-black/20 text-blue-400 group-hover:text-white uppercase font-black w-fit flex-shrink-0">{{ $surat->status }}</span>
                                                </div>
                                            </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 sm:space-y-4">
                                <div class="flex items-center gap-3 ml-1">
                                    <span class="w-6 sm:w-8 h-[2px] bg-emerald-500"></span>
                                    <label class="text-[9px] sm:text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] sm:tracking-[0.4em]">Delegasi Ke</label>
                                </div>

                                <div class="flex flex-col gap-3">
                                    <div class="w-full">
                                        <label class="group relative cursor-pointer block">
                                            <input type="checkbox" name="ke_admin[]" value="{{ Auth::user()->id }}"
                                                x-model="selectedAdmins"
                                                @change="if(selectedAdmins.includes(String('{{ Auth::user()->id }}'))) { roles['{{ Auth::user()->id }}'] = 'pelaksana'; if(!teams['{{ Auth::user()->id }}']) teams['{{ Auth::user()->id }}'] = ['']; }"
                                                class="hidden">
                                            <div class="p-3 sm:p-4 rounded-[1.25rem] sm:rounded-[1.5rem] border-2 transition-all duration-500 flex flex-col gap-3"
                                                :class="selectedAdmins.includes(String('{{ Auth::user()->id }}')) ? 'bg-blue-600/10 border-blue-500 shadow-[0_0_20px_rgba(37,99,235,0.15)] scale-[1.01]' : 'bg-slate-800/30 border-white/5 hover:border-white/20'">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                                                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center transition-all flex-shrink-0"
                                                            :class="selectedAdmins.includes(String('{{ Auth::user()->id }}')) ? 'bg-blue-600 text-white shadow-lg' : 'bg-slate-700 text-slate-500'">
                                                            <i class="fa-solid fa-user-shield text-[10px] sm:text-xs"></i>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-[10px] sm:text-[11px] font-black truncate uppercase tracking-tighter" :class="selectedAdmins.includes(String('{{ Auth::user()->id }}')) ? 'text-white' : 'text-slate-400'">
                                                                {{ Auth::user()->nama }} (Diri Sendiri)
                                                            </p>
                                                            <p class="text-[7px] sm:text-[8px] uppercase tracking-[0.1em] text-blue-400 font-bold mt-0.5 truncate">{{ Auth::user()->role }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="w-2 h-2 rounded-full flex-shrink-0" :class="selectedAdmins.includes(String('{{ Auth::user()->id }}')) ? 'bg-blue-500 shadow-[0_0_10px_#2563eb]' : 'bg-slate-700'"></div>
                                                </div>
                                            </div>
                                        </label>

                                        <div x-show="selectedAdmins.includes(String('{{ Auth::user()->id }}'))"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            class="mt-2 ml-1 sm:ml-4 p-3 sm:p-4 bg-slate-950/40 border border-white/5 rounded-xl sm:rounded-2xl space-y-3">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                                <span class="text-[9px] sm:text-[10px] uppercase font-black tracking-wider text-slate-400 flex-shrink-0">Pilih Peran:</span>
                                                <div class="flex flex-wrap gap-2 flex-1">
                                                    <button type="button" @click="if(!isSubmitting) roles['{{ Auth::user()->id }}'] = 'pelaksana'"
                                                        class="px-3 py-1.5 rounded-lg text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wider transition-all border flex-1 sm:flex-none text-center truncate"
                                                        :class="roles['{{ Auth::user()->id }}'] == 'pelaksana' ? 'bg-red-500 text-white border-transparent' : 'bg-slate-800 text-slate-400 border-white/5'">
                                                        Pelaksana
                                                    </button>
                                                    <button type="button" @click="if(!isSubmitting) roles['{{ Auth::user()->id }}'] = 'pemantau'"
                                                        class="px-3 py-1.5 rounded-lg text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wider transition-all border flex-1 sm:flex-none text-center truncate"
                                                        :class="roles['{{ Auth::user()->id }}'] == 'pemantau' ? 'bg-blue-500 text-white border-transparent' : 'bg-slate-800 text-slate-400 border-white/5'">
                                                        Pemantau
                                                    </button>
                                                </div>
                                                <input type="hidden" :name="'peran['+{{ Auth::user()->id }}+']'" x-model="roles['{{ Auth::user()->id }}']">
                                            </div>

                                            <div class="space-y-2 pt-1 sm:pt-0">
                                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                                                    <label class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-wider">Nama Ketua Tim / Ket. Tugas (Opsional)</label>
                                                    <button type="button" @click="if(!isSubmitting && teams['{{ Auth::user()->id }}']) teams['{{ Auth::user()->id }}'].push('')"
                                                        class="px-2 py-1.5 sm:py-1 bg-blue-500/20 hover:bg-blue-500/40 text-blue-400 text-[8px] sm:text-[9px] font-black uppercase tracking-wider rounded-lg transition-colors flex items-center justify-center gap-1 w-full sm:w-auto">
                                                        <i class="fa-solid fa-plus text-[8px]"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <template x-for="(team, index) in teams['{{ Auth::user()->id }}']" :key="index">
                                                        <div class="flex items-center gap-2">
                                                            <input type="text" :name="'ketua_tim['+{{ Auth::user()->id }}+'][]'" x-model="teams['{{ Auth::user()->id }}'][index]" placeholder="Masukkan nama ketua tim..."
                                                                class="w-full bg-slate-900 border border-white/5 rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-2.5 text-[11px] sm:text-xs text-white focus:outline-none focus:border-blue-500 transition-colors">
                                                            <button type="button" x-show="teams['{{ Auth::user()->id }}'] && teams['{{ Auth::user()->id }}'].length > 1" @click="if(!isSubmitting) teams['{{ Auth::user()->id }}'].splice(index, 1)"
                                                                class="p-2 sm:p-2.5 bg-red-500/10 hover:bg-red-500/30 text-red-400 hover:text-red-300 rounded-lg sm:rounded-xl transition-colors flex-shrink-0">
                                                                <i class="fa-solid fa-trash-can text-[10px] sm:text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach($admin_divisi as $user)
                                    <div class="w-full">
                                        <label class="group relative cursor-pointer block">
                                            <input type="checkbox" name="ke_admin[]" value="{{ $user->id }}"
                                                x-model="selectedAdmins"
                                                @change="if(selectedAdmins.includes(String('{{ $user->id }}'))) { roles['{{ $user->id }}'] = 'pelaksana'; if(!teams['{{ $user->id }}']) teams['{{ $user->id }}'] = ['']; }"
                                                class="hidden">
                                            <div class="p-3 sm:p-4 rounded-[1.25rem] sm:rounded-[1.5rem] border-2 transition-all duration-500 flex flex-col gap-3"
                                                :class="selectedAdmins.includes(String('{{ $user->id }}')) ? 'bg-emerald-500/10 border-emerald-500 shadow-[0_0_20px_rgba(16,185,129,0.15)] scale-[1.01]' : 'bg-slate-800/30 border-white/5 hover:border-white/20'">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                                                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center transition-all flex-shrink-0"
                                                            :class="selectedAdmins.includes(String('{{ $user->id }}')) ? 'bg-emerald-500 text-white shadow-lg' : 'bg-slate-700 text-slate-500'">
                                                            <i class="fa-solid fa-user-check text-[10px] sm:text-xs"></i>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-[10px] sm:text-[11px] font-black truncate uppercase tracking-tighter" :class="selectedAdmins.includes(String('{{ $user->id }}')) ? 'text-white' : 'text-slate-400'">
                                                                {{ $user->nama }}
                                                            </p>
                                                            <p class="text-[7px] sm:text-[8px] uppercase tracking-[0.1em] text-slate-600 font-bold mt-0.5 truncate">{{ $user->role }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="w-2 h-2 rounded-full flex-shrink-0" :class="selectedAdmins.includes(String('{{ $user->id }}')) ? 'bg-emerald-500 shadow-[0_0_10px_#10b981]' : 'bg-slate-700'"></div>
                                                </div>
                                            </div>
                                        </label>

                                        <div x-show="selectedAdmins.includes(String('{{ $user->id }}'))"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            class="mt-2 ml-1 sm:ml-4 p-3 sm:p-4 bg-slate-950/40 border border-white/5 rounded-xl sm:rounded-2xl space-y-3">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                                <span class="text-[9px] sm:text-[10px] uppercase font-black tracking-wider text-slate-400 flex-shrink-0">Pilih Peran:</span>
                                                <div class="flex flex-wrap gap-2 flex-1">
                                                    <button type="button" @click="if(!isSubmitting) roles['{{ $user->id }}'] = 'pelaksana'"
                                                        class="px-3 py-1.5 rounded-lg text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wider transition-all border flex-1 sm:flex-none text-center truncate"
                                                        :class="roles['{{ $user->id }}'] == 'pelaksana' ? 'bg-red-500 text-white border-transparent' : 'bg-slate-800 text-slate-400 border-white/5'">
                                                        Pelaksana
                                                    </button>
                                                    <button type="button" @click="if(!isSubmitting) roles['{{ $user->id }}'] = 'pemantau'"
                                                        class="px-3 py-1.5 rounded-lg text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wider transition-all border flex-1 sm:flex-none text-center truncate"
                                                        :class="roles['{{ $user->id }}'] == 'pemantau' ? 'bg-blue-500 text-white border-transparent' : 'bg-slate-800 text-slate-400 border-white/5'">
                                                        Pemantau
                                                    </button>
                                                </div>
                                                <input type="hidden" :name="'peran['+'{{ $user->id }}'+']'" x-model="roles['{{ $user->id }}']">
                                            </div>

                                            <div class="space-y-2 pt-1 sm:pt-0">
                                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                                                    <label class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-wider">Nama Ketua Tim / Ket. Tugas (Opsional)</label>
                                                    <button type="button" @click="if(!isSubmitting && teams['{{ $user->id }}']) teams['{{ $user->id }}'].push('')"
                                                        class="px-2 py-1.5 sm:py-1 bg-emerald-500/20 hover:bg-emerald-500/40 text-emerald-400 text-[8px] sm:text-[9px] font-black uppercase tracking-wider rounded-lg transition-colors flex items-center justify-center gap-1 w-full sm:w-auto">
                                                        <i class="fa-solid fa-plus text-[8px]"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <template x-for="(team, index) in teams['{{ $user->id }}']" :key="index">
                                                        <div class="flex items-center gap-2">
                                                            <input type="text" :name="'ketua_tim['+'{{ $user->id }}'+'][]'" x-model="teams['{{ $user->id }}'][index]" placeholder="Ketik nama Ketua Tim..."
                                                                class="w-full bg-slate-900 border border-white/5 rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-2.5 text-[11px] sm:text-xs text-white focus:outline-none focus:border-emerald-500 transition-colors">
                                                            <button type="button" x-show="teams['{{ $user->id }}'] && teams['{{ $user->id }}'].length > 1" @click="if(!isSubmitting) teams['{{ $user->id }}'].splice(index, 1)"
                                                                class="p-2 sm:p-2.5 bg-red-500/10 hover:bg-red-500/30 text-red-400 hover:text-red-300 rounded-lg sm:rounded-xl transition-colors flex-shrink-0">
                                                                <i class="fa-solid fa-trash-can text-[10px] sm:text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-4 sm:space-y-5">
                                <div class="flex items-center gap-3 ml-1">
                                    <span class="w-6 sm:w-8 h-[2px] bg-amber-500"></span>
                                    <label class="text-[9px] sm:text-[10px] font-black text-amber-500 uppercase tracking-[0.3em] sm:tracking-[0.4em]">Instruksi Catatan</label>
                                    <span class="text-[8px] sm:text-[9px] font-mono text-amber-500/50 uppercase" x-text="instruksi.length + ' dipilih'"></span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @php
                                    $list_instruksi = [
                                    'Diteliti / Diselesaikan', 'Dipertimbangkan', 'Untuk Diketahui',
                                    'Mewakili / Menghadiri', 'Dikoordinasikan', 'Ditampung Masalahnya',
                                    'Peringatkan / Pendekatan', 'Pendapat / Analisa', 'Konsep Jawaban',
                                    'Konsep Laporan', 'Data Diolah', 'Ditindaklanjuti',
                                    'Diagendakan', 'Harap Dibantu'
                                    ];
                                    @endphp

                                    @foreach($list_instruksi as $item)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="instruksi[]" value="{{ $item }}" x-model="instruksi" class="hidden">
                                        <div class="h-full px-3 py-2.5 sm:px-4 sm:py-3 rounded-lg sm:rounded-xl border text-[9.5px] sm:text-[10px] font-bold transition-all duration-300 flex items-center gap-3"
                                            :class="instruksi.includes('{{ $item }}') 
                                ? 'bg-gradient-to-br from-amber-500 to-orange-600 border-transparent text-slate-950 shadow-lg shadow-amber-500/20' 
                                : 'bg-slate-800/40 border-white/5 text-slate-400 hover:border-white/20 hover:text-white'">
                                            <i class="fa-solid text-[10px] sm:text-[12px] flex-shrink-0" :class="instruksi.includes('{{ $item }}') ? 'fa-circle-check' : 'fa-circle opacity-20'"></i>
                                            <span class="truncate">{{ $item }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-3 sm:space-y-4">
                                <div class="flex items-center gap-3 ml-1">
                                    <span class="w-6 sm:w-8 h-[2px] bg-blue-400"></span>
                                    <label class="text-[9px] sm:text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] sm:tracking-[0.4em]">Lampiran Disposisi (Max 1MB)</label>
                                </div>
                                <div class="relative group h-28 sm:h-32">
                                    <input type="file" name="file_disposisi" required
                                        accept=".pdf,.doc,.docx"
                                        @change="
                                if ($event.target.files.length > 0) {
                                    isUploading = true;
                                    fileName = $event.target.files[0].name;
                                } else {
                                    isUploading = false;
                                    fileName = '';
                                }
                            "
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="h-full p-4 sm:p-6 rounded-2xl sm:rounded-[2rem] border-2 border-dashed transition-all flex flex-col items-center justify-center bg-slate-950/20 px-2 text-center"
                                        :class="isUploading ? 'border-emerald-500/50 bg-emerald-500/5' : 'border-white/5 group-hover:border-blue-500/30 group-hover:bg-blue-500/5'">

                                        <div x-show="!isUploading" class="flex flex-col items-center">
                                            <i class="fa-solid fa-cloud-arrow-up text-xl sm:text-2xl mb-1.5 sm:mb-2 text-slate-700 group-hover:text-blue-500 transition-colors"></i>
                                            <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-slate-500">PDF atau Word (Maks 1MB)</p>
                                        </div>

                                        <div x-show="isUploading" x-cloak class="flex flex-col items-center w-full px-4">
                                            <i class="fa-solid fa-file-circle-check text-xl sm:text-2xl mb-1.5 sm:mb-2 text-emerald-500"></i>
                                            <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-emerald-400 truncate w-full" x-text="fileName"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 bg-white/[0.02] border-t border-white/5 grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 flex-shrink-0">
                            <button type="button" @click="showModal = false" :disabled="isSubmitting"
                                class="order-2 sm:order-1 px-4 py-3 sm:px-6 sm:py-4 bg-slate-800/50 text-slate-500 rounded-xl sm:rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:text-white transition-all w-full disabled:opacity-30 disabled:cursor-not-allowed">
                                Batal
                            </button>

                            <button type="submit"
                                :disabled="!selectedSurat || selectedAdmins.length === 0 || instruksi.length === 0 || isSubmitting"
                                :class="(!selectedSurat || selectedAdmins.length === 0 || instruksi.length === 0 || isSubmitting) ? 'opacity-60 cursor-not-allowed from-slate-700 to-slate-800' : 'from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-blue-500/20'"
                                class="order-1 sm:order-2 sm:col-span-2 px-4 py-3 sm:px-6 sm:py-4 bg-gradient-to-r text-white rounded-xl sm:rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest transition-all shadow-lg flex items-center justify-center w-full">

                                <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                                    <i class="fa-solid fa-spinner animate-spin"></i> Memproses Disposisi...
                                </span>

                                <span x-show="!isSubmitting && (!selectedSurat || selectedAdmins.length === 0 || instruksi.length === 0)" class="flex items-center gap-2 text-amber-400">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Lengkapi Data
                                </span>

                                <span x-show="!isSubmitting && selectedSurat && selectedAdmins.length > 0 && instruksi.length > 0" class="flex items-center gap-2">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Disposisi Akselerasi
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </template>
    </main>

    <div id="swal-messages"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') ? session('error') : ($errors->any() ? $errors->first() : '') }}">
    </div>

    @if ($errors->any())
    <div class="fixed bottom-5 right-5 z-[9999] max-w-sm p-4 bg-red-950/80 border border-red-500/40 text-red-200 rounded-2xl shadow-2xl backdrop-blur-sm text-xs animate-bounce">
        <strong class="block mb-1 font-bold tracking-wide text-red-400">⚠️ VALIDASI SISTEM GAGAL:</strong>
        <ul class="list-disc pl-4 space-y-1 opacity-90">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <script>
        // Konfigurasi Tema Premium (Sesuai dengan modal Slate-900 & Amber-500 Anda)
        const toastTheme = {
            background: '#0f172a',
            color: '#ffffff',
            customClass: {
                // Memaksa container swal naik ke z-index 10000 agar tidak tertutup modal
                container: 'z-[10000]',
                popup: 'rounded-[2.5rem] border border-white/10 shadow-2xl shadow-amber-500/10 p-8',
                confirmButton: 'bg-amber-500 text-black px-8 py-3 rounded-full font-black text-[10px] tracking-widest uppercase transition-all hover:bg-amber-400 focus:outline-none',
                cancelButton: 'bg-slate-800 text-white px-8 py-3 rounded-full font-black text-[10px] tracking-widest uppercase ml-3 transition-all hover:bg-slate-700 focus:outline-none'
            },
            buttonsStyling: false
        };

        /**
         * Validasi File di Sisi Klien (Real-Time)
         */
        function validateDisposisiFile(event) {
            const file = event.target.files[0];
            const allowedExtensions = /(\.pdf|\.doc|\.docx)$/i;
            const maxSize = 1 * 1024 * 1024; // Batas ukuran 1 Megabyte

            if (!file) return false;

            // Saringan Ekstensi Dokumen
            if (!allowedExtensions.exec(file.name)) {
                Swal.fire({
                    ...toastTheme,
                    icon: 'error',
                    iconColor: '#ef4444',
                    title: 'FORMAT TIDAK VALID',
                    text: 'Dokumen pendukung yang diizinkan hanya berupa file berkstensi PDF, DOC, atau DOCX.',
                    showConfirmButton: true,
                    confirmButtonText: 'MENGERTI'
                });
                event.target.value = ''; // Mengosongkan kembali input form
                return false;
            }

            // Saringan Ukuran Dokumen (Maksimal 1MB)
            if (file.size > maxSize) {
                Swal.fire({
                    ...toastTheme,
                    icon: 'warning',
                    iconColor: '#f59e0b',
                    title: 'UKURAN FILE TERLALU BESAR',
                    text: 'Dokumen pendukung yang Anda pilih melebihi kapasitas sistem. Batas maksimum ukuran file adalah 1 MB.',
                    showConfirmButton: true,
                    confirmButtonText: 'SIAP, SAYA KURANGI'
                });
                event.target.value = ''; // Mengosongkan kembali input form
                return false;
            }

            return true; // Mengembalikan true jika file lolos semua validasi
        }

        /**
         * Listener Pengkap Notifikasi Flash Session Laravel
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Membaca elemen jembatan data dari server
            const msgEl = document.getElementById('swal-messages');
            if (!msgEl) return;

            const successMsg = msgEl.getAttribute('data-success');
            const errorMsg = msgEl.getAttribute('data-error');

            // Notifikasi Aksi Berhasil
            if (successMsg && successMsg.trim() !== '') {
                Swal.fire({
                    ...toastTheme,
                    icon: 'success',
                    iconColor: '#f59e0b', // Amber-500 sesuai tema premium Anda
                    title: 'BERHASIL',
                    text: successMsg,
                    timer: 2500,
                    showConfirmButton: false
                });
            }

            // Notifikasi Aksi Gagal / Kesalahan Sistem / Error Validasi Laravel
            if (errorMsg && errorMsg.trim() !== '') {
                Swal.fire({
                    ...toastTheme,
                    icon: 'error',
                    iconColor: '#ef4444',
                    title: 'GAGAL MEMPROSES',
                    text: errorMsg,
                    showConfirmButton: true,
                    confirmButtonText: 'PERBAIKI DATA'
                });
            }
        });

        /**
         * Konfirmasi Hapus Data Disposisi
         */
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Disposisi?',
                text: "Data akan dihapus permanen dan status surat kembali ke pending.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest',
                    cancelButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Memanggil ID form dengan benar
                    const formId = `delete-disposisi-${id}`;
                    const form = document.getElementById(formId);

                    if (form) {
                        form.submit();
                    } else {
                        console.error(`Form dengan ID ${formId} tidak ditemukan.`);
                        Swal.fire('Error', 'Sistem gagal menemukan form penghapusan.', 'error');
                    }
                }
            });
        }

        /**
         * Konfirmasi Keluar Sistem (Logout)
         */
        function confirmLogout() {
            Swal.fire({
                title: '<span style="font-weight:900; color:#fff; font-size:20px;">YAKIN INGIN LOGOUT?</span>',
                text: "Sesi Anda akan berakhir dan data akses akan dikunci.",
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: 'transparent',
                confirmButtonText: 'YA, KELUAR',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                customClass: {
                    popup: 'premium-swal-popup ' + toastTheme.customClass.popup,
                    confirmButton: toastTheme.customClass.confirmButton,
                    cancelButton: toastTheme.customClass.cancelButton
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const logoutForm = document.getElementById('logout-form');
                    if (logoutForm) {
                        logoutForm.submit();
                    } else {
                        console.error("Form dengan ID 'logout-form' tidak ditemukan.");
                    }
                }
            });
        }
    </script>

</body>

</html>