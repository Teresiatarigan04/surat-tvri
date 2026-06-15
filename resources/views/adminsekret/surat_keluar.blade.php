<!DOCTYPE html>
<html lang="id" x-data="{ 
    sidebarOpen: true, 
    mobileSidebar: false, 
    showAdd: false, 
    showEdit: false, 
    current: {},
    searchSurat: '',
    openDropdown: false,
    selectedSurat: { id: '', text: '-- Pilih Referensi Surat --' }
}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keluar | TVRI Sumut</title>

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

        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
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


        /* Tambahan agar scrolling smooth di mobile */
        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Animasi Hover Row Desktop */
        .group:hover td {
            transform: scale(0.995);
        }

        /* Custom Scrollbar untuk tabel jika dibutuhkan */
        .overflow-x-auto::-webkit-scrollbar {
            height: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.2);
            border-radius: 10px;
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

    <!-- MAIN -->
    <main class="lg:ml-72 min-h-screen bg-slate-50 transition-all duration-300">
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 flex flex-col transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <!-- BARIS ATAS: JUDUL & PROFIL -->
            <div class="px-4 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4 group">
                    <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 hover:text-blue-600 transition-all duration-300">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>
                    <div class="transition-transform duration-500 group-hover:translate-x-1">
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight italic uppercase">Arsip Surat Keluar</h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">Manajemen Dokumen Final</p>
                    </div>
                </div>

                <!-- USER PROFILE -->
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
            </div>

            <!-- BARIS BAWAH: AREA TOMBOL AKSI -->
            <div class="px-4 lg:px-8 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center">
                <button @click="showAdd = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all active:scale-95 shadow-lg shadow-blue-600/20 flex items-center gap-3 group">
                    <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform duration-500"></i>
                    Tambah Surat Keluar
                </button>

                <div class="ml-auto hidden md:block">
                    <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-4 py-2 rounded-full border border-blue-100">
                        Total Arsip: {{ $surat_keluar->count() }}
                    </span>
                </div>
            </div>
        </header>

        <div class="p-4 md:p-8">
            <!-- OUTER CONTAINER DENGAN BORDER BERWARNA JELAS -->
            <div class="bg-white rounded-[24px] md:rounded-[32px] overflow-hidden border-2 border-slate-200 shadow-xl shadow-slate-200/40 animate__animated animate__fadeIn">

                <!-- WRAPPER TABEL (Desktop) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <!-- HEADING BERWARNA (Dark Slate) -->
                        <thead class="bg-slate-900 uppercase text-[10px] font-black tracking-[0.2em] text-blue-400 italic">
                            <tr>
                                <th class="p-6 border-b border-white/5">No. Surat</th>
                                <th class="p-6 border-b border-white/5">Perihal / Tujuan</th>
                                <th class="p-6 border-b border-white/5">Tanggal</th>
                                <th class="p-6 border-b border-white/5">Status</th>
                                <th class="p-6 text-center border-b border-white/5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($surat_keluar as $sk)
                            <tr class="hover:bg-blue-50/50 transition-all duration-300 font-bold italic text-xs group">
                                <td class="p-6 text-slate-900 tracking-tighter group-hover:text-blue-600 transition-colors">
                                    {{ $sk->no_surat_keluar }}
                                </td>
                                <td class="p-6">
                                    <div class="text-slate-700 uppercase line-clamp-1 tracking-tight">{{ $sk->perihal }}</div>
                                    <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter flex items-center gap-1">
                                        <i class="fa-solid fa-paper-plane text-[8px] text-blue-500"></i> <span class="font-black text-slate-500">TO: {{ $sk->tujuan }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($sk->tanggal_keluar)->format('d/m/Y') }}
                                </td>
                                <td class="p-6">
                                    <span class="px-3 py-1 rounded-lg border {{ $sk->status == 'terkirim' ? 'border-emerald-200 text-emerald-600 bg-emerald-50' : 'border-slate-200 text-slate-500 bg-slate-50' }} text-[9px] uppercase font-black tracking-widest shadow-sm">
                                        {{ $sk->status }}
                                    </span>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="current = {{ json_encode($sk->load('suratMasuk')) }}; pdfUrl = '{{ asset('uploads/surat_keluar/'.$sk->file_surat_final) }}'; showDetail = true"
                                            class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all active:scale-90 shadow-sm">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </button>
                                        <button @click="current = {{ json_encode($sk) }}; showEdit = true"
                                            class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-amber-600 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all active:scale-90 shadow-sm">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </button>
                                        <form action="{{ route('suratkeluar.destroy', $sk->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)"
                                                class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all active:scale-90 shadow-sm">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-20 text-center text-slate-400 uppercase text-xs font-black tracking-widest italic">Belum ada data surat keluar</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE VIEW -->
                <div class="md:hidden divide-y divide-slate-100">
                    @forelse($surat_keluar as $sk)
                    <div class="p-5 space-y-4 hover:bg-slate-50 transition-all">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <div class="text-[10px] text-blue-600 font-black uppercase tracking-widest italic">No. Surat</div>
                                <div class="text-slate-900 font-black italic tracking-tighter text-sm">{{ $sk->no_surat_keluar }}</div>
                            </div>
                            <span class="px-2 py-1 rounded-md border {{ $sk->status == 'terkirim' ? 'border-emerald-200 text-emerald-600 bg-emerald-50' : 'border-slate-200 text-slate-500 bg-slate-50' }} text-[8px] uppercase font-black">
                                {{ $sk->status }}
                            </span>
                        </div>

                        <div class="space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div class="text-slate-800 uppercase font-black italic text-xs leading-tight line-clamp-2">{{ $sk->perihal }}</div>
                            <div class="text-[10px] text-slate-500 font-bold uppercase italic tracking-tighter flex items-center gap-1">
                                <i class="fa-solid fa-paper-plane text-[8px] text-blue-500"></i> {{ $sk->tujuan }}
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <div class="text-[10px] text-slate-400 font-bold italic">
                                <i class="fa-regular fa-calendar-days mr-1"></i> {{ \Carbon\Carbon::parse($sk->tanggal_keluar)->format('d/m/Y') }}
                            </div>
                            <div class="flex gap-2">
                                <button @click="current = {{ json_encode($sk->load('suratMasuk')) }}; pdfUrl = '{{ asset('uploads/surat_keluar/'.$sk->file_surat_final) }}'; showDetail = true"
                                    class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-blue-600 flex items-center justify-center">
                                    <i class="fa-solid fa-eye text-[10px]"></i>
                                </button>
                                <button @click="current = {{ json_encode($sk) }}; showEdit = true"
                                    class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-amber-600 flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                </button>
                                <form action="{{ route('suratkeluar.destroy', $sk->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)"
                                        class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-red-600 flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center text-slate-400 uppercase text-[10px] font-black italic tracking-[0.2em]">
                        Belum ada data surat keluar
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <body x-data="{ 
                showAdd: false, 
                showEdit: false, 
                showDetail: false, 
    current: {}, 
    pdfUrl: '',
    /* variabel lain */
                openDropdown: false,
                selectedSurat: { 
                    id: '', 
                    text: '-- Pilih Referensi --', 
                    pengirim: '{{ Auth::user()->name }}' 
                },
                current: {}
            }">

        <!-- MODAL DETAIL SURAT KELUAR -->
        <div x-show="showDetail"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10">

            <!-- Overlay dengan Blur Mewah -->
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-xl" @click="showDetail = false"></div>

            <!-- Konten Modal (Floating Card) -->
            <div x-data="{ tab: 'info' }"
                class="relative bg-slate-900 border border-white/10 w-full max-w-5xl h-[80vh] md:h-[85vh] rounded-[32px] shadow-2xl overflow-hidden flex flex-col">

                <!-- HEADER MODAL (Minimalis) -->
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fa-solid fa-file-lines text-xs"></i>
                        </div>
                        <h3 class="text-sm font-black text-white uppercase italic tracking-widest">Detail Arsip</h3>
                    </div>
                    <button @click="showDetail = false" class="text-slate-500 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- TAB SWITCHER (Hanya muncul di Mobile) -->
                <div class="flex md:hidden border-b border-white/5">
                    <button @click="tab = 'info'" :class="tab === 'info' ? 'text-blue-400 border-b-2 border-blue-400' : 'text-slate-500'" class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest transition-all">Informasi</button>
                    <button @click="tab = 'pdf'" :class="tab === 'pdf' ? 'text-blue-400 border-b-2 border-blue-400' : 'text-slate-500'" class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest transition-all">Preview PDF</button>
                </div>

                <!-- BODY MODAL -->
                <div class="flex-1 flex overflow-hidden">

                    <!-- SISI KIRI: INFO (Desktop: Tampil, Mobile: Conditional) -->
                    <div :class="tab === 'info' ? 'flex' : 'hidden md:flex'"
                        class="w-full md:w-[350px] flex-col p-8 overflow-y-auto custom-scrollbar bg-slate-900">

                        <div class="space-y-6">
                            <div class="bg-white/[0.03] border border-white/5 rounded-2xl p-4">
                                <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.2em] block mb-1">Nomor Surat</span>
                                <p class="text-sm font-bold text-white tracking-tighter italic" x-text="current.no_surat_keluar"></p>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-[9px] font-black text-blue-500 uppercase tracking-widest mb-1.5 block">Tujuan</label>
                                    <p class="text-xs font-medium text-slate-300 leading-relaxed uppercase" x-text="current.tujuan"></p>
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-blue-500 uppercase tracking-widest mb-1.5 block">Perihal</label>
                                    <p class="text-xs font-medium text-slate-400 leading-relaxed italic" x-text="current.perihal"></p>
                                </div>
                            </div>

                            <!-- Metadata Grid -->
                            <div class="grid grid-cols-2 gap-3 pt-4">
                                <div class="bg-white/[0.02] p-3 rounded-xl border border-white/5 text-center">
                                    <span class="text-[7px] text-slate-500 uppercase block mb-1">Status</span>
                                    <span class="text-[9px] font-black text-emerald-500 uppercase" x-text="current.status"></span>
                                </div>
                                <div class="bg-white/[0.02] p-3 rounded-xl border border-white/5 text-center">
                                    <span class="text-[7px] text-slate-500 uppercase block mb-1">Tanggal</span>
                                    <span class="text-[9px] font-black text-white uppercase" x-text="current.tanggal_keluar"></span>
                                </div>
                            </div>

                            <!-- Tombol Download Premium -->
                            <div class="pt-6">
                                <a :href="pdfUrl" download class="flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-500 text-white w-full py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-blue-600/10 group">
                                    <i class="fa-solid fa-cloud-arrow-down text-sm group-hover:animate-bounce"></i>
                                    Download File
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN: PDF (Desktop: Tampil, Mobile: Conditional) -->
                    <div :class="tab === 'pdf' ? 'flex' : 'hidden md:flex'"
                        class="flex-1 bg-slate-950 relative border-l border-white/5">

                        <div class="absolute top-4 left-4 z-20 flex gap-2">
                            <span class="px-3 py-1.5 bg-black/40 backdrop-blur-md rounded-lg text-[8px] font-black text-white uppercase border border-white/10 tracking-widest">
                                Document Preview
                            </span>
                            <a :href="pdfUrl" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center text-white transition-all">
                                <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>

                        <!-- PDF Fluid Container -->
                        <div class="w-full h-full flex flex-col items-center justify-center p-4 md:p-8">
                            <template x-if="pdfUrl">
                                <iframe :src="pdfUrl + '#toolbar=0'" class="w-full h-full rounded-2xl shadow-2xl border-0 bg-white shadow-blue-500/5"></iframe>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Hilangkan scrollbar default untuk tampilan lebih clean */
            .custom-scrollbar::-webkit-scrollbar {
                width: 3px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 10px;
            }
        </style>

        <!-- MODAL TAMBAH -->
        <div x-show="showAdd" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-md" @click="showAdd = false"></div>
            <div class="relative bg-slate-900 border border-white/10 w-full max-w-lg rounded-[32px] p-8 shadow-2xl animate__animated animate__zoomIn">

                <!-- Form Start -->
                <form action="{{ route('suratkeluar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h3 class="text-xl font-black text-white italic uppercase mb-6 tracking-tighter">Registrasi Surat Keluar</h3>

                    <div class="space-y-6">
                        <div class="relative" x-data="{ search: '' }">
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-2 block tracking-widest">Pilih Referensi Surat Masuk</label>

                            <input type="hidden" name="surat_masuk_id" :value="selectedSurat.id">

                            <div @click="openDropdown = !openDropdown"
                                class="w-full bg-slate-950 border border-white/10 rounded-2xl px-5 py-4 text-xs text-white cursor-pointer flex justify-between items-center group hover:border-blue-500/50 transition-all">
                                <span class="font-bold italic uppercase tracking-tighter"
                                    :class="selectedSurat.id ? 'text-white' : 'text-slate-500'"
                                    x-text="selectedSurat.text"></span>
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="openDropdown ? 'rotate-180' : ''"></i>
                            </div>

                            <div x-show="openDropdown"
                                @click.away="openDropdown = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                class="absolute z-30 w-full mt-2 bg-slate-900 border border-white/10 rounded-2xl shadow-2xl overflow-hidden backdrop-blur-xl">

                                <div class="p-3 border-b border-white/5 bg-white/5">
                                    <input type="text" x-model="search" placeholder="Cari No. Surat atau Pengirim..."
                                        class="w-full bg-slate-950 border-0 rounded-xl px-4 py-2 text-[10px] text-white outline-none uppercase font-bold">
                                </div>

                                <div class="max-h-48 overflow-y-auto custom-scrollbar italic">
                                    <div @click="selectedSurat = { id: '', text: '-- Tanpa Referensi --', pengirim: '' }; openDropdown = false"
                                        class="px-5 py-3 text-[10px] font-black text-slate-500 hover:bg-blue-600 hover:text-white cursor-pointer uppercase transition-all">
                                        -- Tanpa Referensi --
                                    </div>

                                    @forelse($surat_tersedia as $s)
                                    <div x-show="'{{ strtolower($s->no_surat . ' ' . $s->pengirim) }}'.includes(search.toLowerCase())"
                                        @click="selectedSurat = { id: '{{ $s->id }}', text: '{{ $s->no_surat }}', pengirim: '{{ $s->pengirim }}' }; openDropdown = false"
                                        class="px-5 py-3 text-[10px] font-bold text-slate-300 hover:bg-blue-600 hover:text-white cursor-pointer border-t border-white/5 uppercase transition-all">
                                        <div class="flex justify-between items-center">
                                            <div class="flex flex-col">
                                                <span>{{ $s->no_surat }}</span>
                                                <span class="text-[7px] opacity-50 lowercase italic">{{ Str::limit($s->perihal, 30) }}</span>
                                            </div>
                                            <span class="text-[8px] opacity-50">{{ $s->pengirim }}</span>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="px-5 py-6 text-center text-[10px] text-slate-500 uppercase font-bold">
                                        Tidak ada surat masuk yang perlu dibalas
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-1 block">No. Surat Keluar</label>
                                <input type="text" name="no_surat_keluar" required placeholder="Masukkan No. Surat..."
                                    class="w-full bg-slate-950 border border-white/5 rounded-2xl px-5 py-4 text-white font-bold text-xs italic outline-none focus:border-blue-500/50 transition-all uppercase">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-1 block">Tujuan</label>
                                <input type="text" name="tujuan"
                                    x-model="selectedSurat.pengirim"
                                    :readonly="selectedSurat.id !== ''"
                                    :class="selectedSurat.id !== '' ? 'bg-slate-950/50 text-white' : 'bg-slate-950 text-white border-blue-500/50'"
                                    class="w-full border border-white/5 rounded-2xl px-5 py-4 text-xs font-bold uppercase italic outline-none transition-all"
                                    placeholder="Input Tujuan...">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-1 block">Upload File PDF / WORD Final</label>
                            <input type="file" name="file_surat_final" id="file_surat_final" required
                                accept=".pdf,.doc,.docx"
                                class="w-full bg-slate-950 border border-white/5 rounded-2xl px-5 py-4 text-xs text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white"
                                x-on:change="validateFile($event)">
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" @click="showAdd = false" class="flex-1 py-4 bg-white/5 text-slate-500 rounded-2xl text-[10px] font-black uppercase italic">Batal</button>
                        <button type="submit" class="flex-[2] py-4 bg-blue-600 text-white rounded-2xl text-[10px] font-black uppercase italic shadow-lg shadow-blue-600/20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDIT (Sama seperti sebelumnya dengan sedikit pemolesan) -->
        <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-md" @click="showEdit = false"></div>
            <div class="relative bg-slate-900 border border-white/10 w-full max-w-lg rounded-[32px] p-8 shadow-2xl animate__animated animate__fadeInUp">
                <form :action="'{{ url('surat-keluar/update') }}/' + current.id" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <h3 class="text-xl font-black text-white italic uppercase mb-6 tracking-tighter">Perbarui Data Surat</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-1 block">Pengaju</label>
                            <input type="text" name="tujuan" x-model="current.tujuan" readonly class="w-full bg-slate-950/50 border border-white/5 rounded-2xl px-5 py-4 text-xs text-slate-500 uppercase font-bold italic cursor-not-allowed">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-1 block">Status</label>
                            <select name="status" x-model="current.status" class="w-full bg-slate-950 border border-white/10 rounded-2xl px-5 py-4 text-xs text-white uppercase font-bold italic focus:ring-1 focus:ring-amber-500 outline-none">
                                <option value="terkirim">TERKIRIM</option>
                                <option value="arsip">ARSIP</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 mb-1 block">Ganti File (PDF)</label>
                            <input type="file" name="file_surat_final" accept=".pdf" class="w-full bg-slate-950 border border-white/5 rounded-2xl px-5 py-4 text-xs text-slate-500 file:bg-amber-500 file:border-0 file:text-white file:rounded-lg file:text-[10px] file:font-black">
                        </div>
                    </div>
                    <div class="flex gap-4 mt-8">
                        <button type="button" @click="showEdit = false" class="flex-1 py-4 bg-white/5 text-slate-500 rounded-2xl text-[10px] font-black uppercase italic transition-all hover:bg-white/10">Batal</button>
                        <button type="submit" class="flex-[2] py-4 bg-amber-500 text-white rounded-2xl text-[10px] font-black uppercase italic shadow-lg shadow-amber-500/20 transition-all hover:bg-amber-400">Update Arsip</button>
                    </div>
                </form>
            </div>
        </div>
        </main>

        <style>
            .swal-title-custom {
                font-family: sans-serif;
                font-weight: 900;
                font-style: italic;
                color: #ffffff;
                font-size: 18px;
                letter-spacing: -0.025em;
            }

            .swal-text-custom {
                font-family: sans-serif;
                font-size: 11px;
                color: #94a3b8;
                text-transform: uppercase;
                font-weight: 700;
                letter-spacing: 0.05em;
                line-height: 1.5;
            }

            .premium-swal-popup {
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
        </style>

        <script>
            function confirmDelete(button) {
                Swal.fire({
                    title: 'HAPUS ARSIP?',
                    text: "Data tidak bisa dikembalikan setelah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'HAPUS SEKARANG',
                    cancelButtonText: 'BATAL',
                    customClass: {
                        popup: 'premium-swal-popup'
                    }
                }).then((result) => {
                    if (result.isConfirmed) button.closest('form').submit();
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Gunakan variabel JS untuk menampung data Blade agar VS Code tidak protes
                const hasSuccess = "{{ session('success') }}";
                const hasErrors = "{{ $errors->any() }}";

                if (hasSuccess) {
                    Swal.fire({
                        icon: 'success',
                        iconColor: '#3b82f6',
                        title: '<span class="swal-title-custom">BERHASIL!</span>',
                        html: `<p class="swal-text-custom">${hasSuccess}</p>`,
                        background: '#0f172a',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.style.borderRadius = '24px';
                            toast.style.border = '1px solid rgba(255,255,255,0.1)';
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                }

                if (hasErrors) {
                    showErrorSwal("VALIDASI GAGAL", "{{ $errors->first() }}");
                }
            });

            // --- 2. KONFIRMASI HAPUS ---
            function confirmDelete(button) {
                Swal.fire({
                    title: 'HAPUS ARSIP?',
                    text: "Data tidak bisa dikembalikan setelah dihapus!",
                    icon: 'warning',
                    iconColor: '#ef4444',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'HAPUS SEKARANG',
                    cancelButtonText: 'BATAL',
                    background: '#0f172a',
                    color: '#ffffff',
                    customClass: {
                        popup: 'premium-swal-popup'
                    },
                    didOpen: (toast) => {
                        toast.style.borderRadius = '32px';
                    }
                }).then((result) => {
                    if (result.isConfirmed) button.closest('form').submit();
                });
            }

            // --- 3. VALIDASI FILE UPLOAD ---
            function validateFile(event) {
                const file = event.target.files[0];
                if (!file) return;

                const allowedExtensions = /(\.pdf|\.doc|\.docx)$/i;
                const maxSize = 5 * 1024 * 1024; // 5MB

                if (!allowedExtensions.exec(file.name)) {
                    showErrorSwal("FORMAT TIDAK DIDUKUNG", "Gunakan file PDF atau Microsoft Word (.doc, .docx)");
                    event.target.value = '';
                    return false;
                }

                if (file.size > maxSize) {
                    showErrorSwal("FILE TERLALU BESAR", "Ukuran file maksimal adalah 5MB.");
                    event.target.value = '';
                    return false;
                }
            }

            // --- 4. REUSABLE ERROR SWAL ---
            function showErrorSwal(title, message) {
                Swal.fire({
                    icon: 'error',
                    iconColor: '#ef4444',
                    title: `<span style="font-family: sans-serif; font-weight:900; color:#ffffff; font-size:16px; letter-spacing: 0.05em;">${title}</span>`,
                    html: `<p style="font-family: sans-serif; font-size:12px; color:#94a3b8; text-transform:uppercase; font-weight:600; letter-spacing: 0.025em; line-height: 1.5;">${message}</p>`,
                    background: '#0f172a',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: '<span style="font-size:10px; font-weight:900;">OKE</span>',
                    didOpen: (toast) => {
                        toast.style.borderRadius = '24px';
                        toast.style.border = '1px solid rgba(255,255,255,0.1)';
                    }
                });
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