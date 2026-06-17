<!DOCTYPE html>
<html lang="id" x-data="{ 
    sidebarOpen: true, 
    mobileSidebar: false, 
    modalOpen: false,
    detailData: { surat: {}, timeline: [] }
}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Surat | TVRI Sumut</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0%' stop-color='%230A2A66'/><stop offset='100%' stop-color='%23071C45'/></linearGradient></defs><rect width='100' height='100' rx='18' fill='url(%23g)'/><text x='50' y='64' font-size='36' font-weight='700' text-anchor='middle' fill='white' font-family='Arial, Helvetica, sans-serif'>TVRI</text></svg>">

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

        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 100%);
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
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
        }

        .premium-swal-cancel {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #94a3b8 !important;
            border-radius: 14px !important;
            padding: 12px 30px !important;
            font-weight: 700 !important;
        }

        [x-cloak] {
            display: none !important;
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

    <main class="lg:ml-72 min-h-screen transition-all duration-500 ease-in-out bg-slate-50"
        x-data="{ showModal: false, loaded: false }"
        x-init="setTimeout(() => loaded = true, 100)">

        <!-- HEADER: Putih Bersih dengan Border Bawah Jelas -->
        <header x-show="loaded"
            x-transition:enter="transition-all cubic-bezier(0.16, 1, 0.3, 1) duration-1000"
            x-transition:enter-start="opacity-0 -translate-y-12 backdrop-blur-0 shadow-none"
            x-transition:enter-end="opacity-100 translate-y-0 backdrop-blur-xl shadow-[0_15px_30px_-5px_rgba(15,23,42,0.15),0_4px_12px_rgba(29,78,216,0.15)]"
            class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4 group">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 hover:text-blue-600 transition-all duration-300">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div class="transition-transform duration-500 group-hover:translate-x-1">
                    <h1 class="text-lg font-black text-slate-900 tracking-tight italic uppercase">Kelola Tracking Surat</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Sekretariat • TVRI Sumatera Utara</p>
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

        <div class="p-4 md:p-8 space-y-8"
            x-show="loaded"
            x-transition:enter="transition ease-out duration-800 delay-200"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-data="trackingModule()">
            <!-- Stats Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Surat Card -->
                <div class="group relative overflow-hidden bg-white p-6 rounded-[30px] border-2 border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-500 hover:-translate-y-1"
                    x-show="loaded"
                    x-transition:enter="transition ease-out duration-500 delay-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Arsip</p>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tighter italic">{{ $surats->count() }}</h3>
                            <p class="text-[9px] text-blue-600 font-bold mt-2 flex items-center gap-1 uppercase">
                                <i class="fa-solid fa-database animate-pulse"></i> Database Pusat
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center border border-blue-100 text-blue-600 group-hover:rotate-12 transition-transform duration-500">
                            <i class="fa-solid fa-box-archive text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Process Card -->
                <div class="group relative overflow-hidden bg-white p-6 rounded-[30px] border-2 border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-500 hover:-translate-y-1"
                    x-show="loaded"
                    x-transition:enter="transition ease-out duration-500 delay-400">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Dalam Proses</p>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tighter italic">
                                {{ $surats->where('status', '!=', 'selesai')->filter(fn($s) => !$s->suratKeluar)->count() }}
                            </h3>
                            <p class="text-[9px] text-amber-600 font-bold mt-2 flex items-center gap-1 uppercase">
                                <i class="fa-solid fa-spinner fa-spin-slow"></i> Sedang Berjalan
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center border border-amber-100 text-amber-600 group-hover:-rotate-12 transition-transform duration-500">
                            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Completed Card -->
                <div class="group relative overflow-hidden bg-white p-6 rounded-[30px] border-2 border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-500 hover:-translate-y-1 sm:col-span-2 lg:col-span-1"
                    x-show="loaded"
                    x-transition:enter="transition ease-out duration-500 delay-500">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Selesai/Keluar</p>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tighter italic">
                                {{ $surats->filter(fn($s) => $s->suratKeluar || $s->status == 'selesai')->count() }}
                            </h3>
                            <p class="text-[9px] text-emerald-600 font-bold mt-2 flex items-center gap-1 uppercase">
                                <i class="fa-solid fa-circle-check"></i> Distribusi Berhasil
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center border border-emerald-100 text-emerald-600 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-paper-plane text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Container -->
            <div class="bg-white rounded-[24px] md:rounded-[35px] overflow-hidden border-2 border-slate-100 shadow-xl"
                x-show="loaded"
                x-transition:enter="transition ease-out duration-700 delay-600"
                x-transition:enter-start="opacity-0 translate-y-12"
                x-transition:enter-end="opacity-100 translate-y-0">

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900 uppercase text-[10px] font-black tracking-[0.2em] text-blue-400 italic">
                            <tr>
                                <th class="p-6">Surat & Perihal</th>
                                <th class="p-6">Posisi Terakhir</th>
                                <th class="p-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($surats as $surat)
                            <tr class="hover:bg-slate-50 transition-all duration-300 group">
                                <td class="p-6">
                                    <div class="font-black text-slate-900 text-sm mb-1 group-hover:text-blue-600 transition-colors uppercase tracking-tight">{{ $surat->no_surat }}</div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-tight line-clamp-1 italic font-bold">{{ $surat->perihal }}</div>
                                </td>
                                <td class="p-6">
                                    <div class="flex flex-wrap items-center gap-2 max-w-xl">
                                        @if($surat->suratKeluar || $surat->status == 'selesai')
                                        <span class="px-3 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-[9px] font-black uppercase flex items-center gap-1">
                                            <i class="fa-solid fa-check-double text-[8px]"></i> Selesai / Arsip Keluar
                                        </span>
                                        @else
                                        @php
                                        // Filter hanya disposisi yang memiliki peran pelaksana
                                        $pelaksanas = $surat->disposisis->filter(function($disp) {
                                        return strtolower($disp->peran ?? '') === 'pelaksana';
                                        });
                                        @endphp

                                        @if($pelaksanas->isNotEmpty())
                                        <span class="text-[10px] font-black text-rose-600 uppercase tracking-wider mr-1">Pelaksana :</span>

                                        @foreach($pelaksanas as $pelaksana)
                                        <div class="inline-flex items-center gap-1 bg-rose-50 border border-rose-200 rounded-lg pl-2 pr-2.5 py-1 text-rose-700 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                            <span class="text-[9px] font-black uppercase tracking-tight">
                                                {{ $pelaksana->penerima->nama ?? 'Unit Terkait' }}
                                            </span>
                                        </div>
                                        @endforeach
                                        @else
                                        <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-500 text-[9px] font-black uppercase shadow-sm">
                                            Sekretariat (Baru)
                                        </span>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="fetchDetail({{ $surat->id }})"
                                            class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all active:scale-90">
                                            <i class="fa-solid fa-route text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-20 text-center text-slate-300 uppercase text-xs font-black tracking-widest italic">
                                    Data tracking tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-slate-100">
                    @foreach($surats as $surat)
                    <div class="p-5 space-y-4 bg-white hover:bg-slate-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="text-[10px] text-blue-600 font-black uppercase tracking-widest italic mb-1">No. Surat</div>
                                <div class="text-slate-900 font-black text-sm tracking-tight">{{ $surat->no_surat }}</div>
                            </div>
                            @php $isSelesai = $surat->suratKeluar || $surat->status == 'selesai'; @endphp
                            <span class="{{ $isSelesai ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-blue-100 text-blue-700 border-blue-200' }} text-[8px] font-black px-2 py-1 rounded border uppercase">
                                {{ $isSelesai ? 'SELESAI' : 'PROSES' }}
                            </span>
                        </div>

                        <div class="bg-slate-50/50 p-3 rounded-xl border border-slate-100 space-y-2">
                            <div class="text-[9px] text-slate-400 font-black uppercase italic tracking-widest">Posisi Surat</div>

                            <div class="flex flex-wrap items-center gap-1.5">
                                @if($isSelesai)
                                <div class="text-[10px] text-emerald-700 font-black italic uppercase">
                                    <i class="fa-solid fa-check-double mr-1 text-[9px]"></i> Selesai
                                </div>
                                @else
                                @php
                                $mobilePelaksanas = $surat->disposisis->filter(function($disp) {
                                return strtolower($disp->peran ?? '') === 'pelaksana';
                                });
                                @endphp

                                @if($mobilePelaksanas->isNotEmpty())
                                <span class="text-[9px] font-black text-rose-600 uppercase tracking-wider mr-0.5">Pelaksana :</span>

                                @foreach($mobilePelaksanas as $pelaksana)
                                <span class="px-2 py-0.5 rounded bg-rose-500/10 border border-rose-500/20 text-rose-500 text-[8px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1 h-1 rounded-full bg-rose-500"></span>
                                    {{ $pelaksana->penerima->nama ?? 'Unit Terkait' }}
                                </span>
                                @endforeach
                                @else
                                <div class="text-[10px] text-slate-500 font-black italic uppercase">
                                    Sekretariat
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-2 justify-end pt-2">
                            <button @click="fetchDetail({{ $surat->id }})" class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-route text-sm"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal Timeline -->
            <div x-show="modalOpen" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
                <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

                <div class="flex min-h-full items-center justify-center p-4">
                    <div x-show="modalOpen" x-transition.scale.95 class="bg-white border-2 border-slate-200 w-full max-w-2xl rounded-[30px] md:rounded-[40px] relative z-[110] overflow-hidden shadow-2xl">

                        <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <div class="pr-4">
                                <h3 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em]" x-text="detailData.surat?.no_surat"></h3>
                                <p class="text-xs md:text-sm font-black text-slate-900 mt-1 line-clamp-1 uppercase italic" x-text="detailData.surat?.perihal"></p>
                            </div>
                            <button @click="modalOpen = false" class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center bg-slate-200 text-slate-600 hover:bg-slate-900 hover:text-white transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="p-6 md:p-8 space-y-0 overflow-y-auto max-h-[60vh] relative bg-white">
                            <div class="absolute left-[51px] top-12 bottom-12 w-0.5 bg-slate-100 hidden md:block"></div>

                            <template x-for="(step, index) in detailData.timeline" :key="index">
                                <div class="flex flex-col md:flex-row items-start gap-4 md:gap-6 mb-8 group relative">

                                    <div :class="{
                            'bg-blue-600 shadow-blue-100': step.type === 'start',
                            'bg-emerald-600 shadow-emerald-100': step.status === 'disetujui' || step.status === 'selesai' || step.type === 'end',
                            'bg-rose-600 shadow-rose-100': step.status === 'ditolak',
                            'bg-amber-500 shadow-amber-100': step.type === 'disposisi' && !['disetujui', 'selesai', 'ditolak'].includes(step.status)
                        }" class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 z-10 shadow-lg text-white transition-colors duration-300">
                                        <i :class="step.icon" class="fa-solid text-xs"></i>
                                    </div>

                                    <div class="flex-1 w-full bg-slate-50 border-2 border-slate-100 p-4 md:p-5 rounded-2xl hover:border-blue-200 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="text-xs font-black text-slate-900 uppercase italic" x-text="step.title"></h4>
                                                <span class="text-[9px] font-bold text-slate-400" x-text="formatDate(step.date)"></span>
                                            </div>

                                            <span :class="{
                                    'text-emerald-700 bg-emerald-50 border-emerald-200': step.status === 'disetujui' || step.status === 'selesai' || step.type === 'end',
                                    'text-rose-700 bg-rose-50 border-rose-200': step.status === 'ditolak',
                                    'text-blue-700 bg-blue-50 border-blue-200': step.type === 'start',
                                    'text-amber-700 bg-amber-50 border-amber-200': step.type === 'disposisi' && !['disetujui', 'selesai', 'ditolak'].includes(step.status)
                                }" class="px-2.5 py-1 rounded-md text-[8px] font-black uppercase border tracking-wider" x-text="step.status"></span>
                                        </div>

                                        <div x-show="step.type === 'disposisi' && step.peran" class="mb-3 flex flex-wrap items-center gap-2">
                                            <span :class="{
                                                'bg-rose-500/10 border-rose-500/20 text-rose-600': step.peran.toLowerCase() === 'pelaksana',
                                                'bg-sky-500/10 border-sky-500/20 text-sky-600': step.peran.toLowerCase() === 'pemantau'
                                            }" class="px-2 py-0.5 rounded border text-[9px] font-black uppercase tracking-wide">
                                                Peran: <span x-text="step.peran"></span>
                                            </span>

                                            <span class="text-[10px] font-bold text-slate-700 bg-slate-200/60 px-2 py-0.5 rounded border border-slate-300/40">
                                                <i class="fa-solid fa-users text-[9px] text-slate-500 mr-1"></i>
                                                <span x-show="step.ketua_tim" x-text="'Ketua Tim: ' + step.ketua_tim"></span>
                                                <span x-show="!step.ketua_tim && step.peran.toLowerCase() === 'pelaksana'">Pelaksana Langsung</span>
                                                <span x-show="!step.ketua_tim && step.peran.toLowerCase() === 'pemantau'">Pemantau Langsung</span>
                                            </span>
                                        </div>

                                        <p class="text-[11px] text-slate-600 font-medium leading-relaxed" x-text="step.desc"></p>

                                        <div x-show="step.sender" class="mt-3 pt-2 border-t border-slate-200 flex items-center gap-1">
                                            <i class="fa-solid fa-user-circle text-blue-500 text-[10px]"></i>
                                            <span class="text-[9px] text-slate-400 font-black uppercase" x-text="'Oleh: ' + step.sender"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-center">
                            <button @click="modalOpen = false" class="w-full md:w-auto px-10 py-3 bg-slate-900 rounded-2xl text-[10px] font-black text-white uppercase tracking-widest hover:bg-black transition-all">
                                Tutup Tinjauan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Delete Form -->
            <form id="delete-form" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </main>
    <script>
        // GANTIKAN BAGIAN <script> DI BAWAH FILE ANDA DENGAN INI
        function trackingModule() {
            return {
                modalOpen: false,
                detailData: {
                    surat: {},
                    timeline: []
                },
                async fetchDetail(id) {
                    try {
                        // Tambahkan loading state jika perlu, tapi langsung fetch saja untuk kecepatan
                        const response = await fetch(`/admin-sekret/tracking/${id}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Server Error:', errorText);
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        // Pastikan data yang masuk terstruktur
                        this.detailData = {
                            surat: data.surat || {},
                            timeline: data.timeline || []
                        };

                        this.modalOpen = true;
                    } catch (error) {
                        console.error('Error detail:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Gagal Dimuat',
                            text: 'Pastikan koneksi database benar atau cek log server.',
                            background: '#0f172a',
                            color: '#f8fafc',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                },
                formatDate(dateString) {
                    if (!dateString) return '-';
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    };
                    return new Date(dateString).toLocaleDateString('id-ID', options);
                },
                confirmDelete(id) {
                    Swal.fire({
                        title: 'Hapus Data?',
                        text: "Seluruh riwayat tracking dan data surat ini akan hilang!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#334155',
                        confirmButtonText: 'YA, HAPUS',
                        background: '#0f172a',
                        color: '#f8fafc'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('delete-form');
                            form.action = `/admin-sekret/tracking/${id}`;
                            form.submit();
                        }
                    })
                }
            }
        }


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
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-confirm',
                    cancelButton: 'premium-swal-cancel'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>