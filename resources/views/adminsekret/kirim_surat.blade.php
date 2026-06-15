<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebar: false, searchQuery: '', modalOpen: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Surat | E-Secretary TVRI Sumut</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0%' stop-color='%230A2A66'/><stop offset='100%' stop-color='%23071C45'/></linearGradient></defs><rect width='100' height='100' rx='18' fill='url(%23g)'/><text x='50' y='64' font-size='36' font-weight='700' text-anchor='middle' fill='white' font-family='Arial, Helvetica, sans-serif'>TVRI</text></svg>">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar-dark-premium {
            background-color: #020617;
            background-image: radial-gradient(circle at top right, rgba(30, 58, 138, 0.2), transparent),
                radial-gradient(circle at bottom left, rgba(15, 23, 42, 0.2), transparent);
        }

        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 100%);
            border-left: 4px solid #3b82f6;
            color: #3b82f6 !important;
        }

        .sidebar-item-active i {
            color: #3b82f6 !important;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
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

        .premium-swal-font {
            font-family: 'Inter', sans-serif !important;
        }

        .swal2-title {
            font-weight: 800 !important;
            letter-spacing: -0.02em;
        }
    </style>
</head>

<body class="text-slate-600 antialiased overflow-x-hidden">

    <div x-data="{ mobileSidebar: false, show: false, searchQuery: '' }"
        x-init="setTimeout(() => show = true, 100)"
        class="min-h-screen bg-white">

        <!-- Mobile Overlay -->
        <div x-show="mobileSidebar" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 bg-black/80 z-40 lg:hidden"
            @click="mobileSidebar = false"></div>

        <!-- Sidebar Dark Premium -->
        <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 sidebar-dark-premium border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

            <div class="p-6 shrink-0">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-8" alt="Logo">
                    <span class="text-sm font-black tracking-tighter text-white uppercase">E-Secretary</span>
                </div>
            </div>

            <nav class="flex-1 px-3 space-y-1 overflow-y-auto pb-4 text-slate-400">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Main Menu</p>

                <a href="{{ route('admin.sekret.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.sekret.dashboard') ? 'sidebar-item-active' : 'hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-house-chimney text-sm"></i>
                    <span class="text-sm font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('admin.suratsekret.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.suratsekret.*') ? 'sidebar-item-active' : 'hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                    <span class="text-sm font-semibold">Kirim Surat</span>
                </a>

                <a href="{{ route('admin.surat.masuk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 hover:text-white transition-all group">
                    <i class="fa-solid fa-envelope-open-text text-sm"></i>
                    <span class="text-sm font-semibold">Surat Masuk</span>
                </a>

                <a href="{{ route('admin.surat.keluar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 hover:text-white transition-all group">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                    <span class="text-sm font-semibold">Surat Keluar</span>
                </a>

                <a href="{{ route('admin.disposisi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 hover:text-white transition-all group">
                    <i class="fa-solid fa-share-nodes text-sm"></i>
                    <span class="text-sm font-semibold">Disposisi Surat</span>
                </a>

                <a href="{{ route('admin.arsip.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                    <i class="fa-solid fa-box-archive text-sm"></i>
                    <span class="text-sm font-semibold">Arsip Surat</span>
                </a>

                <a href="{{ route('admin.tracking.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 hover:text-white transition-all group">
                    <i class="fa-solid fa-map-location-dot text-sm"></i>
                    <span class="text-sm font-semibold">Tracking Surat</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('kelola-akun.*') || request()->routeIs('admin.log.*') ? 'true' : 'false' }} }" class="pt-4">
                    <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">System Control</p>
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/5 transition-all group">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-user-shield text-sm"></i>
                            <span class="text-sm font-semibold">Administrator</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="ml-9 mt-1 space-y-1">
                        <a href="{{ route('kelola-akun.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-medium text-slate-500 hover:text-blue-400 transition-colors group">
                            <i class="fa-solid fa-users-gear text-[10px] opacity-50 group-hover:opacity-100"></i>
                            <span>Kelola Akun</span>
                        </a>
                        <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-medium text-slate-500 hover:text-blue-400 transition-colors group">
                            <i class="fa-solid fa-clock-rotate-left text-[10px] opacity-50 group-hover:opacity-100"></i>
                            <span>Log Aktivitas</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-white/5 bg-slate-900/80 shrink-0">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-500/10">
                        <i class="fa-solid fa-power-off"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="lg:ml-72 min-h-screen transition-all duration-300 bg-white overflow-x-hidden">

            <header x-show="show"
                x-transition:enter="transition-all cubic-bezier(0.16, 1, 0.3, 1) duration-1000"
                x-transition:enter-start="opacity-0 -translate-y-12 backdrop-blur-0 shadow-none"
                x-transition:enter-end="opacity-100 translate-y-0 backdrop-blur-xl shadow-[0_15px_30px_-5px_rgba(15,23,42,0.15),0_4px_12px_rgba(29,78,216,0.15)]"
                class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebar = true" class="lg:hidden text-slate-400 hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight uppercase italic">Kirim Surat</h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">Manajemen Sekret</p>
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

            <div class="p-4 lg:p-8 space-y-8">

                <div x-show="show"
                    x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 translate-x-10"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="flex flex-col lg:flex-row justify-between items-end lg:items-center gap-8 p-2">
                    <!-- SECTION KIRI: Tetap Mewah -->
                    <div class="flex items-center gap-6 w-full lg:w-auto">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[35px] blur opacity-15 group-hover:opacity-30 transition duration-1000"></div>
                            <div class="relative bg-white px-8 py-6 rounded-[32px] shadow-sm border border-slate-100 flex items-center gap-6 overflow-hidden">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-500 shadow-inner">
                                    <i class="fa-solid fa-paper-plane text-blue-600 group-hover:text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.3em] mb-0.5">Total Surat</p>
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $suratSekrets->count() }}</h3>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-emerald-500 leading-none">ACTIVE</span>
                                            <span class="text-[9px] font-bold text-slate-400 leading-none">TOTAL SURAT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-0 right-0 w-24 h-full bg-slate-50/50 -skew-x-12 translate-x-12"></div>
                            </div>
                        </div>

                        <div class="hidden xl:block w-[1px] h-12 bg-slate-200"></div>

                        <div class="hidden md:block">
                            <h4 class="text-xs font-black text-slate-800 tracking-wide uppercase">{{ now()->format('l') }}</h4>
                            <p class="text-[11px] font-medium text-slate-400 leading-tight">{{ now()->format('d F Y') }}</p>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                <span class="text-[10px] font-bold text-blue-600/80 tracking-widest uppercase">Live System</span>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION KANAN: Search Bar yang Jauh Lebih Jelas -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        <!-- Search Glass Design - UPDATED -->
                        <div class="relative w-full sm:w-80 group">
                            <!-- Border Glow di belakang input saat fokus -->
                            <div class="absolute -inset-0.5 bg-blue-500 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition duration-300"></div>

                            <input type="text" x-model="searchQuery"
                                placeholder="Cari Surat..."
                                class="relative w-full bg-slate-50 border-2 border-slate-200 rounded-2xl py-4 pl-12 pr-6 text-xs font-bold text-slate-700 
                       focus:bg-white focus:border-blue-600 focus:ring-0 outline-none transition-all 
                       placeholder:text-slate-400 placeholder:font-semibold shadow-inner">

                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 z-10"></i>
                        </div>

                        <!-- Action Button -->
                        <button @click="modalOpen = true"
                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 shadow-xl shadow-blue-600/30 active:scale-95 transition-all">
                            <i class="fa-solid fa-plus-circle text-lg"></i>
                            Kirim Surat
                        </button>
                    </div>
                </div>

                <div x-show="show"
                    x-transition:enter="transition ease-out duration-1000 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white border-2 border-slate-200 rounded-[32px] overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-900 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                                    <th class="p-6">Informasi Surat</th>
                                    <th class="p-6">Tujuan Unit</th>
                                    <th class="p-6">Tanggal Kirim</th>
                                    <th class="p-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($suratSekrets as $surat)
                                <tr class="hover:bg-slate-50 transition-all group"
                                    x-show="searchQuery === '' || '{{ strtolower($surat->no_surat) }} {{ strtolower($surat->perihal) }}'.includes(searchQuery.toLowerCase())">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 italic font-black">
                                                <i class="fa-solid fa-file-contract"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900 tracking-tight">{{ $surat->no_surat }}</div>
                                                <div class="text-[10px] text-slate-400 font-bold italic uppercase">{{ $surat->perihal }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex flex-wrap gap-1">
                                            @php $tujuans = is_array($surat->tujuan_id) ? $surat->tujuan_id : json_decode($surat->tujuan_id, true); @endphp
                                            @foreach($adminDivisi as $divisi)
                                            @if(in_array($divisi->id, $tujuans ?? []))
                                            <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border border-slate-200">{{ $divisi->nama }}</span>
                                            @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-6 text-xs font-bold text-slate-600 italic">
                                        {{ $surat->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="p-6 text-right">
                                        <!-- Kontainer Aksi dengan Alpine.js -->
                                        <div class="flex justify-end gap-3" x-data="{ detailModal: false, editModal: false }">

                                            <!-- Tombol Detail (Mata) - Desain Glassmorphism Soft -->
                                            <button @click="detailModal = true"
                                                class="group w-10 h-10 rounded-2xl border border-blue-100 bg-blue-50/50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-200 transition-all duration-300 active:scale-90">
                                                <i class="fa-solid fa-eye text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>

                                            <!-- Tombol Edit (Pensil) - Desain Amber Soft -->
                                            <button @click="editModal = true"
                                                class="group w-10 h-10 rounded-2xl border border-amber-100 bg-amber-50/50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white hover:shadow-lg hover:shadow-amber-200 transition-all duration-300 active:scale-90">
                                                <i class="fa-solid fa-pen-to-square text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>

                                            <!-- Tombol Delete - Desain Rose Soft -->
                                            <form action="{{ route('admin.suratsekret.destroy', $surat->id) }}" method="POST" class="delete-form">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)"
                                                    class="group w-10 h-10 rounded-2xl border border-rose-100 bg-rose-50/50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white hover:shadow-lg hover:shadow-rose-200 transition-all duration-300 active:scale-90">
                                                    <i class="fa-solid fa-trash-can text-sm group-hover:scale-110 transition-transform"></i>
                                                </button>
                                            </form>

                                            <!-- ========================================== -->
                                            <!-- MODAL DETAIL - ULTRA MODERN DESIGN -->
                                            <!-- ========================================== -->
                                            <template x-teleport="body">
                                                <div x-show="detailModal"
                                                    class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xl"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    x-transition:leave-end="opacity-0"
                                                    style="display: none;">

                                                    <div @click.away="detailModal = false"
                                                        class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden relative border border-slate-200"
                                                        x-transition:enter="transition ease-out duration-300 transform"
                                                        x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                                                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>

                                                        <div class="p-10 pb-6 flex justify-between items-start">
                                                            <div class="flex gap-5">
                                                                <div class="w-16 h-16 rounded-3xl bg-blue-600 flex items-center justify-center text-white text-2xl shadow-lg shadow-blue-200">
                                                                    <i class="fa-solid fa-envelope-open-text"></i>
                                                                </div>
                                                                <div>
                                                                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Detail Arsip Digital</h3>
                                                                    <div class="flex items-center gap-2 mt-1">
                                                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Dokumen Internal</span>
                                                                        <span class="text-slate-300">•</span>
                                                                        <span class="text-xs text-slate-400 font-medium">{{ $surat->created_at->format('d M Y, H:i') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button @click="detailModal = false" class="w-10 h-10 rounded-2xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center">
                                                                <i class="fa-solid fa-xmark text-lg"></i>
                                                            </button>
                                                        </div>

                                                        <div class="px-10 py-2 grid grid-cols-2 gap-4">
                                                            <div class="col-span-2 sm:col-span-1 p-5 rounded-[2rem] bg-slate-50 border border-slate-100">
                                                                <label class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 block">Nomor Registrasi</label>
                                                                <span class="text-sm font-bold text-slate-700 block">{{ $surat->no_surat }}</span>
                                                            </div>
                                                            <div class="col-span-2 sm:col-span-1 p-5 rounded-[2rem] bg-slate-50 border border-slate-100">
                                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block text-blue-600">Status</label>
                                                                <div class="flex items-center gap-2">
                                                                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                                                    <span class="text-sm font-bold text-slate-700 block">Terkirim</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-span-2 p-6 rounded-[2.5rem] bg-slate-50 border border-slate-100 group">
                                                                <label class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-3 block">Perihal / Isi Ringkas</label>
                                                                <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $surat->perihal }}</p>
                                                            </div>

                                                            <div class="col-span-2 p-6 rounded-[2.5rem] border-2 border-dashed border-slate-100">
                                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">
                                                                    Unit Tujuan Distribusi
                                                                </label>
                                                                <div class="flex flex-wrap gap-2">
                                                                    @php
                                                                    // Pastikan data tujuan_id didecode dengan benar
                                                                    $tujuans = is_array($surat->tujuan_id) ? $surat->tujuan_id : json_decode($surat->tujuan_id, true);
                                                                    $found = false;
                                                                    @endphp

                                                                    @foreach($adminDivisi as $divisi)
                                                                    {{-- Gunakan in_array seperti di tabel yang sudah berhasil --}}
                                                                    @if(in_array($divisi->id, $tujuans ?? []))
                                                                    @php $found = true; @endphp
                                                                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-slate-200 shadow-sm">
                                                                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                                                        {{-- PERHATIKAN: Gunakan ->nama (sesuai kode tabel Anda) --}}
                                                                        <span class="text-[11px] font-bold text-slate-600 capitalize">{{ $divisi->nama }}</span>
                                                                    </div>
                                                                    @endif
                                                                    @endforeach

                                                                    @if(!$found)
                                                                    <span class="text-xs italic text-slate-400 font-medium">Data unit tidak ditemukan</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="p-10 pt-6 flex gap-4">
                                                            <!-- Perbaikan URL: Pastikan mengarah ke /uploads/ bukan /public/uploads/ -->
                                                            <a href="{{ url('uploads/surat_sekret/' . $surat->file_surat) }}"
                                                                target="_blank"
                                                                class="flex-1 h-16 bg-slate-900 hover:bg-blue-700 text-white rounded-3xl font-black text-[12px] uppercase tracking-[0.15em] transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3">
                                                                <i class="fa-solid fa-file-pdf text-lg text-rose-400"></i>
                                                                Buka Dokumen
                                                            </a>

                                                            <a href="{{ url('uploads/surat_sekret/' . $surat->file_surat) }}"
                                                                download
                                                                class="w-16 h-16 bg-blue-50 text-blue-600 rounded-3xl font-bold hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center">
                                                                <i class="fa-solid fa-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- ========================================== -->
                                            <!-- MODAL EDIT - Desain Modern & Interaktif -->
                                            <!-- ========================================== -->
                                            <!-- MODAL EDIT SURAT (STYLE DISESUAIKAN DENGAN MODAL KIRIM) -->
                                            <template x-teleport="body">
                                                <div x-show="editModal"
                                                    x-cloak
                                                    class="fixed inset-0 z-[1000] flex items-center justify-center overflow-hidden">

                                                    <!-- Backdrop -->
                                                    <div x-show="editModal"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease-in duration-200"
                                                        x-transition:leave-end="opacity-0"
                                                        class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"
                                                        @click="editModal = false"></div>

                                                    <!-- Modal Card Container -->
                                                    <div x-show="editModal"
                                                        x-transition:enter="transition ease-out duration-500"
                                                        x-transition:enter-start="opacity-0 scale-90 translate-y-12"
                                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                        x-transition:leave="transition ease-in duration-300"
                                                        x-transition:leave-end="opacity-0 scale-90 translate-y-12"
                                                        class="relative w-full max-w-2xl max-h-[90vh] mx-4 bg-white rounded-[40px] shadow-[0_35px_60px_-15px_rgba(0,0,0,0.5)] overflow-hidden border border-white/20 flex flex-col transition-all">

                                                        <!-- HEADER -->
                                                        <div class="bg-slate-900 p-6 flex justify-between items-center relative overflow-hidden shrink-0">
                                                            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                                                            <div class="relative z-10 italic">
                                                                <h3 class="text-white font-black uppercase tracking-tighter text-lg flex items-center gap-2">
                                                                    <span class="w-1.5 h-5 bg-amber-500 rounded-full inline-block"></span>
                                                                    Edit Arsip Surat
                                                                </h3>
                                                                <p class="text-slate-400 text-[9px] uppercase font-bold tracking-[0.2em] mt-0.5 ml-3.5">Pemutakhiran Data</p>
                                                            </div>
                                                            <button @click="editModal = false" class="relative z-10 w-9 h-9 flex items-center justify-center rounded-full bg-white/5 text-slate-400 hover:text-white hover:bg-white/10 transition-all active:scale-90">
                                                                <i class="fa-solid fa-xmark text-base"></i>
                                                            </button>
                                                        </div>

                                                        <!-- FORM CONTENT -->
                                                        <div class="overflow-y-auto custom-scrollbar flex-grow bg-white">
                                                            <form action="{{ route('admin.suratsekret.update', $surat->id) }}" method="POST" enctype="multipart/form-data" class="p-6 pb-6 space-y-6">
                                                                @csrf
                                                                @method('PUT')

                                                                <!-- Input Group: No Surat & Perihal -->
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                                    <div class="space-y-1.5 group">
                                                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1 group-focus-within:text-amber-600 transition-colors">Nomor Surat</label>
                                                                        <div class="relative">
                                                                            <i class="fa-solid fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-amber-500"></i>
                                                                            <input type="text" name="no_surat" value="{{ $surat->no_surat }}" required
                                                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl py-3.5 pl-11 pr-4 text-xs font-bold focus:border-amber-500 focus:bg-white outline-none transition-all shadow-sm text-slate-900">
                                                                        </div>
                                                                    </div>
                                                                    <div class="space-y-1.5 group">
                                                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1 group-focus-within:text-amber-600 transition-colors">Perihal</label>
                                                                        <div class="relative">
                                                                            <i class="fa-solid fa-heading absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-amber-500"></i>
                                                                            <input type="text" name="perihal" value="{{ $surat->perihal }}" required
                                                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl py-3.5 pl-11 pr-4 text-xs font-bold focus:border-amber-500 focus:bg-white outline-none transition-all shadow-sm text-slate-900">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Unit Tujuan Distribusi (Modern Checkbox Grid) -->
                                                                <div class="space-y-3">
                                                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Pilih Unit Tujuan</label>

                                                                    @php
                                                                    $rawTujuan = is_array($surat->tujuan_id) ? $surat->tujuan_id : json_decode($surat->tujuan_id, true);
                                                                    $selectedTujuan = array_map('intval', (array)($rawTujuan ?? []));
                                                                    @endphp

                                                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                                                        @foreach($adminDivisi as $divisi)
                                                                        <label class="relative cursor-pointer group">
                                                                            <!-- 1. Input Checkbox (Hidden) -->
                                                                            <input type="checkbox" name="tujuan_id[]" value="{{ $divisi->id }}"
                                                                                {{ in_array((int)$divisi->id, $selectedTujuan) ? 'checked' : '' }}
                                                                                class="peer sr-only">

                                                                            <!-- 2. UI Container (Sibling dari input agar CSS ~ bekerja) -->
                                                                            <div class="w-full bg-white border-2 border-slate-100 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 rounded-xl p-3 flex items-center gap-2.5 transition-all duration-300 shadow-sm group-hover:border-slate-200">

                                                                                <!-- Box Centang -->
                                                                                <div class="w-4 h-4 rounded border-2 border-slate-200 bg-white flex items-center justify-center transition-all duration-200 shrink-0 overflow-hidden">
                                                                                    <i class="fa-solid fa-check text-[8px] text-white opacity-0 transition-all duration-200"></i>
                                                                                </div>

                                                                                <!-- Label Text -->
                                                                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-tight truncate">
                                                                                    {{ $divisi->nama }}
                                                                                </span>
                                                                            </div>

                                                                            <!-- 3. Sibling Styles (Memaksa Centang Muncul) -->
                                                                            <style>
                                                                                input:checked~div i {
                                                                                    opacity: 1 !important;
                                                                                    transform: scale(1) !important;
                                                                                }

                                                                                input:checked~div {
                                                                                    border-color: #2563eb !important;
                                                                                    background-color: #eff6ff !important;
                                                                                }

                                                                                input:checked~div span {
                                                                                    color: #1d4ed8 !important;
                                                                                }

                                                                                input:checked~div .w-4 {
                                                                                    background-color: #2563eb !important;
                                                                                    border-color: #2563eb !important;
                                                                                }
                                                                            </style>
                                                                        </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <!-- Upload Zone -->
                                                                <div class="space-y-3">
                                                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1 text-center block">File Dokumen</label>
                                                                    <div class="relative group/file overflow-hidden rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-400 transition-all duration-500 p-8 text-center">
                                                                        <input type="file" name="file_surat" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                                                        <div class="flex flex-col items-center justify-center gap-3">
                                                                            <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover/file:bg-blue-600 group-hover/file:text-white transition-all duration-500">
                                                                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                                                            </div>
                                                                            <div>
                                                                                <p class="text-xs font-black text-slate-700">Klik untuk ganti berkas</p>
                                                                                <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase tracking-wider italic">Maks. 2MB (PDF/DOCX)</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    @if($surat->file_surat)
                                                                    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                                                        <i class="fa-solid fa-file-circle-check text-emerald-500"></i>
                                                                        <span class="text-[10px] font-bold text-emerald-700 truncate">{{ $surat->file_surat }}</span>
                                                                    </div>
                                                                    @endif
                                                                </div>

                                                                <!-- Action Buttons -->
                                                                <div class="flex gap-3 pt-2">
                                                                    <button type="button" @click="editModal = false"
                                                                        class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="flex-[2] py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-slate-200 hover:bg-blue-600 transition-all active:scale-95">
                                                                        Simpan Perubahan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center">
                                        <i class="fa-solid fa-folder-open text-6xl opacity-10 mb-4 block"></i>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Belum ada arsip pengiriman surat</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- MODAL KIRIM SURAT (OPTIMIZED SPACING) -->
        <div
            x-show="modalOpen"
            x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden">

            <!-- Backdrop -->
            <div
                x-show="modalOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"
                @click="modalOpen = false"></div>

            <!-- Modal Card Container -->
            <div
                x-show="modalOpen"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90 translate-y-12"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-12"
                class="relative w-full max-w-2xl max-h-[90vh] mx-4 bg-white rounded-[40px] shadow-[0_35px_60px_-15px_rgba(0,0,0,0.5)] overflow-hidden border border-white/20 flex flex-col transition-all">

                <!-- HEADER -->
                <div class="bg-slate-900 p-6 flex justify-between items-center relative overflow-hidden shrink-0">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="relative z-10 italic">
                        <h3 class="text-white font-black uppercase tracking-tighter text-lg flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-blue-600 rounded-full inline-block"></span>
                            Kirim Surat
                        </h3>
                        <p class="text-slate-400 text-[9px] uppercase font-bold tracking-[0.2em] mt-0.5 ml-3.5">Input Surat</p>
                    </div>
                    <button @click="modalOpen = false" class="relative z-10 w-9 h-9 flex items-center justify-center rounded-full bg-white/5 text-slate-400 hover:text-white hover:bg-white/10 transition-all active:scale-90">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <!-- FORM CONTENT -->
                <div class="overflow-y-auto custom-scrollbar flex-grow bg-white">
                    <form action="{{ route('admin.suratsekret.store') }}" method="POST" enctype="multipart/form-data" class="p-6 pb-6 space-y-6">
                        @csrf

                        <!-- Input Group: No Surat & Perihal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5 group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1 group-focus-within:text-blue-600 transition-colors">Nomor Surat</label>
                                <div class="relative">
                                    <i class="fa-solid fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-blue-500"></i>
                                    <input type="text" name="no_surat" required placeholder="Contoh: 001/TVRI/2026"
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl py-3.5 pl-11 pr-4 text-xs font-bold focus:border-blue-600 focus:bg-white outline-none transition-all shadow-sm text-slate-900">
                                </div>
                            </div>
                            <div class="space-y-1.5 group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1 group-focus-within:text-blue-600 transition-colors">Perihal</label>
                                <div class="relative">
                                    <i class="fa-solid fa-heading absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs group-focus-within:text-blue-500"></i>
                                    <input type="text" name="perihal" required placeholder="Perihal"
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl py-3.5 pl-11 pr-4 text-xs font-bold focus:border-blue-600 focus:bg-white outline-none transition-all shadow-sm text-slate-900">
                                </div>
                            </div>
                        </div>

                        <!-- Modern Checkbox Grid (FIXED & TESTED) -->
                        <!-- Modern Checkbox Grid (FIXED & TESTED) -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Pilih Unit Tujuan</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($adminDivisi as $divisi)
                                <label class="relative cursor-pointer group">
                                    <!-- 1. Input Checkbox -->
                                    <input type="checkbox" name="tujuan_id[]" value="{{ $divisi->id }}" class="peer sr-only">

                                    <!-- 2. UI Container (Sejajar dengan Input agar peer-checked bekerja) -->
                                    <div class="w-full bg-white border-2 border-slate-100 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 rounded-xl p-3 flex items-center gap-2.5 transition-all duration-300 shadow-sm group-hover:border-slate-200">

                                        <!-- Box Centang -->
                                        <div class="w-4 h-4 rounded border-2 border-slate-200 bg-white flex items-center justify-center transition-all duration-200 shrink-0 overflow-hidden peer-checked:bg-blue-600 peer-checked:border-blue-600">
                                            <!-- Gunakan inline style sementara untuk memastikan muncul jika tailwind delay -->
                                            <i class="fa-solid fa-check text-[8px] text-white opacity-0 transition-all duration-200 peer-checked:opacity-100"></i>
                                        </div>

                                        <!-- Label Text -->
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-tight truncate peer-checked:text-blue-700">
                                            {{ $divisi->nama }}
                                        </span>
                                    </div>

                                    <!-- 3. Overlay Helper (Opsional: Memaksa ikon muncul dengan CSS murni jika peer Tailwind gagal) -->
                                    <style>
                                        input:checked~div i {
                                            opacity: 1 !important;
                                            transform: scale(1) !important;
                                        }

                                        input:checked~div {
                                            border-color: #2563eb !important;
                                            background-color: #eff6ff !important;
                                        }

                                        input:checked~div span {
                                            color: #1d4ed8 !important;
                                        }

                                        input:checked~div .w-4 {
                                            background-color: #2563eb !important;
                                            border-color: #2563eb !important;
                                        }
                                    </style>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="space-y-3" x-data="{ fileName: '', fileType: '', isDragging: false }">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Dokumen Lampiran</label>
                            <div class="relative">
                                <input type="file" name="file_surat" required accept=".pdf,.doc,.docx"
                                    @change="const file = $event.target.files[0]; if(file) { fileName = file.name; fileType = file.name.split('.').pop().toLowerCase(); }"
                                    @dragover="isDragging = true" @dragleave="isDragging = false" @drop="isDragging = false"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

                                <div :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-slate-200 bg-slate-50'"
                                    class="border-2 border-dashed rounded-[2rem] py-8 px-6 text-center transition-all duration-300 group">
                                    <div class="relative z-10 flex flex-col items-center pointer-events-none">
                                        <div class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center mb-3 group-hover:scale-105 transition-transform border border-slate-50">
                                            <template x-if="!fileName">
                                                <i class="fa-solid fa-cloud-arrow-up text-blue-600 text-xl"></i>
                                            </template>
                                            <template x-if="fileName">
                                                <i :class="fileType === 'pdf' ? 'fa-solid fa-file-pdf text-red-500' : 'fa-solid fa-file-word text-blue-500'" class="text-xl"></i>
                                            </template>
                                        </div>
                                        <div x-show="!fileName">
                                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-900">Upload File</p>
                                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-1">PDF / Word (Max 1MB)</p>
                                        </div>
                                        <div x-show="fileName" x-cloak>
                                            <p class="text-[10px] font-black text-blue-600 italic px-4 truncate max-w-[250px]" x-text="fileName"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER BUTTONS -->
                        <div class="flex gap-3 pt-6 border-t border-slate-50 mt-6 shrink-0">
                            <button type="button" @click="modalOpen = false"
                                class="flex-1 px-4 py-4 rounded-xl border-2 border-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all italic shadow-sm active:scale-95">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-[2] relative overflow-hidden group bg-slate-900 text-white px-4 py-4 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative z-10 flex items-center justify-center gap-2 italic">
                                    <i class="fa-solid fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                                    Simpan & Kirim
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const successMessage = "{{ session('success') }}";
                const hasErrors = "{{ $errors->any() ? '1' : '' }}";

                // Konfigurasi Standar Desain
                const baseConfig = {
                    background: '#0f172a', // Slate 900
                    color: '#f8fafc', // Slate 50
                    buttonsStyling: false,
                    customClass: {
                        popup: 'premium-swal-font rounded-3xl border border-slate-700 shadow-2xl',
                        title: 'text-2xl pt-4',
                        confirmButton: 'px-6 py-2.5 rounded-xl font-bold bg-indigo-600 hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown animate__faster'
                    }
                };

                // 1. Alert Sukses (Ultra Modern)
                if (successMessage && successMessage !== "") {
                    Swal.fire({
                        ...baseConfig,
                        icon: 'success',
                        iconColor: '#10b981', // Emerald 500
                        title: 'SUKSES!',
                        text: successMessage,
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                    });
                }

                // 2. Alert Error (Clean & Structured)
                if (hasErrors === '1') {
                    Swal.fire({
                        ...baseConfig,
                        icon: 'error',
                        iconColor: '#f43f5e', // Rose 500
                        title: 'PERIKSA INPUT!',
                        html: `
                    <div class="bg-slate-800/50 rounded-2xl p-4 mt-2 border border-slate-700/50">
                        <ul style="text-align: left; font-size: 0.875rem; list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-2 mb-1 text-slate-300">
                                    <span class="text-rose-500">●</span> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                `,
                        confirmButtonText: 'Perbaiki Sekarang',
                    });
                }
            });
        </script>

        <script>
            function confirmLogout() {
                Swal.fire({
                    title: '<span style="font-weight:900; color:#fff; font-size:20px;">YAKIN INGIN LOGOUT?</span>',
                    text: "Anda harus login kembali untuk mengakses data sekretariat.",
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

            function confirmDelete(button) {
                Swal.fire({
                    title: 'HAPUS DATA?',
                    text: "Data yang dihapus tidak dapat dipulihkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'HAPUS SEKARANG',
                    cancelButtonText: 'BATAL',
                    customClass: {
                        popup: 'premium-swal-popup',
                        confirmButton: 'premium-swal-confirm',
                        cancelButton: 'premium-swal-cancel'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            }
        </script>
</body>

</html>