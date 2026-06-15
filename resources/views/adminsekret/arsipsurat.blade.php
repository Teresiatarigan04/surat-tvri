<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital TVRI - Official System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0%' stop-color='%230A2A66'/><stop offset='100%' stop-color='%23071C45'/></linearGradient></defs><rect width='100' height='100' rx='18' fill='url(%23g)'/><text x='50' y='64' font-size='36' font-weight='700' text-anchor='middle' fill='white' font-family='Arial, Helvetica, sans-serif'>TVRI</text></svg>">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617;
            background-image: radial-gradient(circle at top right, rgba(30, 58, 138, 0.2), transparent),
                radial-gradient(circle at bottom left, rgba(15, 23, 42, 0.2), transparent);
            color: #f8fafc;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 100%);
            border-left: 4px solid #3b82f6;
            color: #3b82f6 !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
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

        .table-card {
            background: rgba(15, 23, 42, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            backdrop-filter: blur(20px);
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden"
    x-data="{ ...arsipModule(), loaded: false }"
    x-init="setTimeout(() => loaded = true, 50)">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="mobileSidebar" x-cloak
        class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="lg:ml-72 min-h-screen flex flex-col bg-slate-50">
        <!-- Header: Putih Bersih dengan Border Bawah Jelas -->
        <header x-show="loaded"
            x-transition:enter="transition-all cubic-bezier(0.16, 1, 0.3, 1) duration-1000"
            x-transition:enter-start="opacity-0 -translate-y-12 backdrop-blur-0 shadow-none"
            x-transition:enter-end="opacity-100 translate-y-0 backdrop-blur-xl shadow-[0_15px_30px_-5px_rgba(15,23,42,0.15),0_4px_12px_rgba(29,78,216,0.15)]"
            class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 hover:text-slate-900 transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase italic">Arsip Surat</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manajemen Arsip Surat</p>
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

        <main class="p-6 lg:p-10 flex-1">
            <div x-show="loaded"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">

                    <div class="bg-white p-6 rounded-[28px] border-2 border-slate-100 border-l-blue-600 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-500 border border-blue-100">
                                <i class="fa-solid fa-database text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Arsip</p>
                                <h3 class="text-xl lg:text-2xl font-black text-slate-900 mt-0.5 italic tracking-tighter">
                                    {{ number_format($suratMasuk->count() + $suratKeluar->count() + $suratTerkirim->count()) }}
                                    <span class="text-[9px] text-slate-400 not-italic font-medium ml-1">Files</span>
                                </h3>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 w-full"></div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-[28px] border-2 border-slate-100 border-l-indigo-600 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform duration-500 border border-indigo-100">
                                <i class="fa-solid fa-inbox text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Surat Masuk</p>
                                <h3 class="text-xl lg:text-2xl font-black text-slate-900 mt-0.5 italic tracking-tighter">
                                    {{ number_format($suratMasuk->count()) }}
                                    <span class="text-[9px] text-slate-400 not-italic font-medium ml-1">Items</span>
                                </h3>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-[9px] font-black text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100 italic">DITERIMA</span>
                            <div class="flex-1 h-[1px] bg-slate-100"></div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-[28px] border-2 border-slate-100 border-l-emerald-600 shadow-sm hover:shadow-md transition-all duration-300 group sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-500 border border-emerald-100">
                                <i class="fa-solid fa-paper-plane text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Surat Keluar</p>
                                <h3 class="text-xl lg:text-2xl font-black text-slate-900 mt-0.5 italic tracking-tighter">
                                    {{ number_format($suratKeluar->count()) }}
                                    <span class="text-[9px] text-slate-400 not-italic font-medium ml-1">Sent</span>
                                </h3>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100 italic">TERKIRIM</span>
                            <div class="flex-1 h-[1px] bg-slate-100"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row justify-between items-center gap-6 p-1">
                    <div class="w-full lg:w-auto">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mb-3 ml-2 block italic">
                            Kategori Arsip
                        </label>
                        <div class="relative flex flex-wrap bg-white border-2 border-slate-200 p-1.5 rounded-[22px] shadow-sm w-full sm:w-fit gap-1 group">
                            <button @click="tab = 'masuk'"
                                :class="tab === 'masuk' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                                class="relative flex-1 sm:flex-none px-6 py-3 rounded-[16px] text-[10px] font-black uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-download"></i>
                                <span>Surat Masuk</span>
                            </button>

                            <button @click="tab = 'keluar'"
                                :class="tab === 'keluar' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                                class="relative flex-1 sm:flex-none px-6 py-3 rounded-[16px] text-[10px] font-black uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-upload"></i>
                                <span>Surat Keluar</span>
                            </button>

                            <button @click="tab = 'terkirim'"
                                :class="tab === 'terkirim' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                                class="relative flex-1 sm:flex-none px-6 py-3 rounded-[16px] text-[10px] font-black uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-share-from-square"></i>
                                <span>Surat Terkirim</span>
                            </button>
                        </div>
                    </div>

                    <div class="w-full lg:w-auto">
                        <div class="relative w-full sm:w-72 group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs group-focus-within:text-blue-600 transition-colors"></i>
                            </div>
                            <input type="text" x-model="searchQuery" placeholder="Cari nomor atau perihal..."
                                class="w-full bg-white border-2 border-slate-200 rounded-2xl py-3.5 pl-11 pr-4 text-[11px] font-bold text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-blue-600 transition-all shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="loaded"
                x-transition:enter="transition ease-out duration-1000 delay-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="bg-white border-2 border-slate-200 rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 mt-6">

                <div x-show="tab === 'masuk'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-900 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                                    <th class="p-6 text-blue-400">Informasi Surat</th>
                                    <th class="p-6">Asal Pengirim</th>
                                    <th class="p-6">Administrasi</th>
                                    <th class="p-6 text-right">Opsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($suratMasuk as $sm)
                                <tr x-show="filterRow('{{ $sm->no_surat }} {{ $sm->perihal }} {{ $sm->pengirim }}')"
                                    class="hover:bg-blue-50/50 transition-all duration-200 group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform shadow-sm">
                                                <i class="fa-solid fa-file-import text-xs"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors tracking-tight">{{ $sm->no_surat }}</div>
                                                <div class="text-[10px] text-slate-500 font-bold mt-0.5 italic uppercase tracking-tighter">{{ Str::limit($sm->perihal, 45) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-slate-700 tracking-tight">{{ $sm->pengirim }}</span>
                                            <span class="text-[9px] text-slate-400 uppercase font-black tracking-tighter mt-1">External Source</span>
                                        </div>
                                    </td>
                                    <td class="p-6 text-xs text-slate-600 font-bold">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-calendar-check text-blue-600"></i>
                                            <span>{{ \Carbon\Carbon::parse($sm->tanggal_terima)->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end gap-3">
                                            <button @click="openAction('detail', 'masuk', {{ $sm->id }})"
                                                class="w-9 h-9 rounded-xl bg-white border-2 border-slate-100 text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm active:scale-90 flex items-center justify-center">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center">
                                        <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-4 block"></i>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Data surat masuk tidak ada</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="tab === 'keluar'" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-900 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                                    <th class="p-6 text-emerald-400">Registrasi Arsip</th>
                                    <th class="p-6">Tujuan</th>
                                    <th class="p-6">Status Progres</th>
                                    <th class="p-6 text-right">Opsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($suratKeluar as $sk)
                                <tr x-show="filterRow('{{ $sk->no_surat_keluar }} {{ $sk->perihal }} {{ $sk->tujuan }}')"
                                    class="hover:bg-emerald-50/50 transition-all duration-200 group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform shadow-sm">
                                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900 group-hover:text-emerald-600 transition-colors tracking-tight">{{ $sk->no_surat_keluar }}</div>
                                                <div class="text-[10px] text-slate-500 font-bold mt-0.5 italic uppercase tracking-tighter">{{ Str::limit($sk->perihal, 45) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6 text-xs font-black text-slate-700 tracking-tight">{{ $sk->tujuan }}</td>
                                    <td class="p-6">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-100 text-[9px] font-black text-emerald-600 uppercase italic shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            {{ $sk->status }}
                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end gap-3">
                                            <button @click="openAction('detail', 'keluar', {{ $sk->id }})"
                                                class="w-9 h-9 rounded-xl bg-white border-2 border-slate-100 text-emerald-600 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all shadow-sm active:scale-90 flex items-center justify-center">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center">
                                        <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-4 block"></i>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Data surat keluar tidak ada</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB CONTENT: SURAT TERKIRIM (DARI SURAT SEKRET) -->
                <div x-show="tab === 'terkirim'" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-900 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                                    <th class="p-6 text-indigo-400">Informasi Surat</th>
                                    <th class="p-6">Pengirim</th>
                                    <th class="p-6">Administrasi</th>
                                    <th class="p-6 text-right">Opsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($suratTerkirim as $st)
                                <!-- PERBAIKAN DI SINI: Mengubah \'\' menjadi '' -->
                                <tr x-show="filterRow('{{ $st->no_surat }} {{ $st->perihal }} {{ $st->pengirim->name ?? '' }}')"
                                    class="hover:bg-indigo-50/50 transition-all duration-200 group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform shadow-sm">
                                                <i class="fa-solid fa-share-from-square text-xs"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition-colors tracking-tight">{{ $st->no_surat }}</div>
                                                <div class="text-[10px] text-slate-500 font-bold mt-0.5 italic uppercase tracking-tighter">{{ Str::limit($st->perihal, 45) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-slate-700 tracking-tight">{{ $st->pengirim->name ?? 'Admin Secretariat' }}</span>
                                            <span class="text-[9px] text-slate-400 uppercase font-black tracking-tighter mt-1">Internal Sender</span>
                                        </div>
                                    </td>
                                    <td class="p-6 text-xs text-slate-600 font-bold">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-clock text-indigo-600"></i>
                                            <span>{{ $st->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end gap-3">
                                            <button @click="openAction('detail', 'terkirim', {{ $st->id }})"
                                                class="w-9 h-9 rounded-xl bg-white border-2 border-slate-100 text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm active:scale-90 flex items-center justify-center">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center">
                                        <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-4 block"></i>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Data surat terkirim tidak ada</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Detail Arsip Modern -->
    <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 lg:p-6" x-cloak>
        <!-- Backdrop dengan Blur yang Lebih Halus -->
        <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false"
            class="absolute inset-0 bg-slate-950/40 backdrop-blur-xl"></div>

        <!-- Container Modal -->
        <div x-show="modalOpen"
            x-transition:enter="ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-95 translate-y-10"
            class="relative w-full max-w-7xl h-[92vh] bg-white border border-slate-200 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row transition-all duration-300">

            <!-- Sidebar Informasi (Kiri) -->
            <div class="w-full lg:w-[420px] flex flex-col bg-slate-50 border-r border-slate-100 overflow-y-auto custom-scrollbar">
                <div class="p-8 lg:p-10 flex flex-col h-full">
                    <!-- Header Sidebar -->
                    <div class="mb-8 flex justify-between items-start">
                        <div>
                            <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Document Detail</span>
                            <h3 class="text-2xl font-black text-slate-900 leading-tight">Arsip Digital</h3>
                        </div>
                        <button @click="modalOpen = false" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <!-- Info Cards -->
                    <div class="space-y-5 flex-1">
                        <!-- Nomor Surat High Contrast -->
                        <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden group">
                            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2 relative z-10">Nomor Registrasi</label>
                            <p class="text-base font-black text-slate-900 break-all relative z-10" x-text="data.no_surat || data.no_surat_keluar"></p>
                        </div>

                        <!-- Meta Data Grid -->
                        <div class="grid grid-cols-1 gap-4">
                            <div class="p-5 bg-white/50 rounded-2xl border border-slate-100">
                                <label class="text-[9px] font-black text-slate-400 uppercase block mb-1"
                                    x-text="activeType === 'masuk' ? 'Pengirim / Asal' : (activeType === 'keluar' ? 'Tujuan' : 'Detail Pengirim')"></label>
                                <p class="text-sm font-bold text-slate-700"
                                    x-text="data.pengirim?.name || data.pengirim || data.tujuan"></p>
                            </div>

                            <div class="p-5 bg-white/50 rounded-2xl border border-slate-100">
                                <label class="text-[9px] font-black text-slate-400 uppercase block mb-1 text-blue-600">Perihal Isi</label>
                                <p class="text-xs font-medium text-slate-600 leading-relaxed italic" x-text="data.perihal"></p>
                            </div>
                        </div>

                        <!-- Status & Date -->
                        <div class="flex items-center gap-4">
                            <div class="flex-1 p-5 bg-white/50 rounded-2xl border border-slate-100">
                                <label class="text-[9px] font-black text-slate-400 uppercase block mb-1">Tanggal</label>
                                <p class="text-xs font-bold text-slate-700" x-text="data.tanggal_surat || data.tanggal_keluar"></p>
                            </div>
                            <div class="flex-1 p-5 bg-white/50 rounded-2xl border border-slate-100">
                                <label class="text-[9px] font-black text-slate-400 uppercase block mb-1">Status Akhir</label>
                                <span class="text-[10px] font-black uppercase tracking-widest"
                                    :class="{
                                      'text-emerald-500': ['disetujui', 'selesai', 'diarsip'].includes(data.status?.toLowerCase()),
                                      'text-rose-500': data.status?.toLowerCase() === 'ditolak',
                                      'text-amber-500': !['disetujui', 'selesai', 'ditolak', 'diarsip'].includes(data.status?.toLowerCase())
                                  }"
                                    x-text="data.status || 'PROSES'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Sidebar / Actions -->
                    <div class="mt-10 pt-8 border-t border-slate-200 flex flex-col gap-3">
                        <a :href="getFilePath()" target="_blank"
                            class="w-full py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-blue-600 hover:shadow-xl hover:shadow-blue-200 transition-all flex items-center justify-center gap-3">
                            <i class="fa-solid fa-file-pdf"></i> Buka Fullscreen
                        </a>
                        <button @click="modalOpen = false" class="w-full py-3 text-slate-400 text-[10px] font-black uppercase tracking-widest hover:text-slate-900 transition-colors">
                            Tutup Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- PDF Viewer (Kanan) -->
            <div class="flex-1 bg-slate-100 relative flex flex-col">
                <!-- Toolbar PDF -->
                <div class="h-16 bg-white border-b border-slate-200 px-8 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-red-400 rounded-full shadow-sm"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Document Preview</span>
                    </div>
                    <button @click="modalOpen = false" class="hidden lg:flex w-8 h-8 items-center justify-center text-slate-400 hover:text-red-500 transition-all">
                        <i class="fa-solid fa-circle-xmark text-xl"></i>
                    </button>
                </div>


                <!-- Frame Container -->
                <div class="flex-1 p-4 lg:p-8">
                    <div class="w-full h-full bg-white rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 border border-slate-200 flex items-center justify-center relative">

                        <!-- Deteksi keberadaan file_surat ATAU file_surat_final -->
                        <template x-if="data && (data.file_surat || data.file_surat_final)">
                            <iframe :src="getFilePath()" class="w-full h-full border-none"></iframe>
                        </template>

                        <!-- Jika keduanya kosong / tidak ada dokumen -->
                        <template x-if="!data || (!data.file_surat && !data.file_surat_final)">
                            <div class="text-center p-10">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-inner">
                                    <i class="fa-solid fa-eye-slash text-2xl text-slate-200"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Dokumen Digital Tidak Tersedia</p>
                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function arsipModule() {
            return {
                // State
                tab: 'masuk',
                searchQuery: '', // State untuk filter pencarian real-time
                mobileSidebar: false,
                modalOpen: false,
                isEditMode: false,
                activeType: '',
                data: {},
                timeline: [], // Pastikan timeline dideklarasikan di awal state
                isLoading: false,

                // Helper untuk mendapatkan nama file berdasarkan tipe arsip
                getFileSurat() {
                    if (!this.data) return '';
                    return this.activeType === 'masuk' ? this.data.file_surat : this.data.file_surat_final;
                },

                // PERBAIKAN 1: Optimasi path URL dengan encodeURIComponent
                getFilePath() {
                    if (!this.data) return '#';

                    // Ambil nama file dari file_surat (masuk/terkirim) atau file_surat_final (keluar)
                    let filename = this.data.file_surat || this.data.file_surat_final;
                    if (!filename) return '#';

                    let folder = '';
                    if (this.activeType === 'masuk') {
                        folder = 'surat_masuk';
                    } else if (this.activeType === 'keluar') {
                        folder = 'surat_keluar';
                    } else if (this.activeType === 'terkirim') {
                        folder = 'surat_sekret';
                    }

                    // Memastikan nama file disanitasi agar spasi dan karakter unik terbaca sempurna
                    return `/uploads/${folder}/${encodeURIComponent(filename)}`;
                },

                // PERBAIKAN 2: Penyeragaman endpoint URL agar sesuai dengan routing Laravel (Gunakan URL yang konsisten)
                openModal(id) {
                    this.modalOpen = true;
                    this.isLoading = true;
                    this.data = {}; // Reset data lama
                    this.timeline = []; // Reset timeline lama

                    fetch(`/ADMINSEKRET/arsip/${id}`) // Disamakan menjadi uppercase sesuai dengan openAction
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                this.data = res.surat;
                                this.timeline = res.timeline || [];
                                this.activeType = res.type; // Set tipe dinamis ('masuk'/'keluar'/'terkirim')
                            }
                        })
                        .catch(err => console.error("Error fetching data:", err))
                        .finally(() => {
                            this.isLoading = false;
                        });
                },

                // Fungsi filter untuk menyaring baris tabel (Search logic)
                filterRow(content) {
                    if (!this.searchQuery || this.searchQuery.trim() === '') return true;
                    const query = this.searchQuery.toLowerCase();
                    return content.toLowerCase().includes(query);
                },

                // Mengambil data dari server untuk Detail atau Edit via Axios
                async openAction(mode, type, id) {
                    this.isEditMode = (mode === 'edit');
                    this.activeType = type;
                    this.data = {};
                    this.timeline = [];

                    // Loading state dengan SweetAlert modern
                    Swal.fire({
                        title: 'Sinkronisasi...',
                        html: '<div class="mt-2"><p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] animate-pulse">Menghubungi server arsip TVRI</p></div>',
                        background: '#020617',
                        color: '#f8fafc',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    try {
                        const res = await axios.get(`/ADMINSEKRET/arsip/${id}`);
                        if (res.data.success) {
                            this.data = res.data.surat;
                            this.timeline = res.data.timeline || [];

                            // Mengunci tipe akurat berdasarkan deteksi dari backend controller
                            if (res.data.type) {
                                this.activeType = res.data.type;
                            }

                            this.modalOpen = true;
                            Swal.close();
                        }
                    } catch (e) {
                        console.error(e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Kegagalan Sistem',
                            text: 'Gagal mengambil data dari database arsip.',
                            background: '#020617',
                            color: '#f8fafc',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                },
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