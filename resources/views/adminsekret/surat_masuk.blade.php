<!DOCTYPE html>
<html lang="id" x-data="{ 
    sidebarOpen: true, 
    mobileSidebar: false, 
    detailModal: false, 
    editModal: false,
    addModal: false,
    selectedSurat: { id: '', file_surat: '', no_surat: '', pengirim: '', perihal: '', sifat: '', tanggal_surat: '', created_at: '' } 
}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Surat Masuk | TVRI Sumut</title>

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

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            /* Membuat ikon jadi putih */
            opacity: 0.6;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden">

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL',
            text: "{{ session('success') }}",
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#3b82f6'
        });
    </script>
    @endif

    <div x-show="mobileSidebar" x-transition.opacity class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900/50 backdrop-blur-xl border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

        <div class="p-6 shrink-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-8" alt="Logo">
                <span class="text-sm font-black tracking-tighter text-white uppercase">E-Secretary</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto pb-4">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Main Menu</p>

            <a href="{{ route('admin.sekret.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all group">
                <i class="fa-solid fa-house-chimney text-sm"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.suratsekret.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Kirim Surat</span>
            </a>

            <a href="{{ route('admin.surat.masuk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl sidebar-item-active transition-all group">
                <i class="fa-solid fa-envelope-open-text text-sm"></i>
                <span class="text-sm font-semibold">Surat Masuk</span>
            </a>
            <a href="{{ route('admin.surat.keluar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Surat Keluar</span>
            </a>

            <a href="{{ route('admin.disposisi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-share-nodes text-sm"></i>
                <span class="text-sm font-semibold">Disposisi Surat</span>
            </a>

            <a href="{{ route('admin.arsip.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-box-archive text-sm"></i>
                <span class="text-sm font-semibold">Arsip Surat</span>
            </a>
            <a href="{{ route('admin.tracking.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('*/tracking*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all group">
                <i class="fa-solid fa-map-location-dot text-sm"></i>
                <span class="text-sm font-semibold">Tracking Surat</span>
            </a>

            <div x-data="{ open: false }" class="pt-4">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">System Control</p>
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
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

        <div class="p-4 border-t border-white/5 bg-slate-900/80 backdrop-blur-md shrink-0">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-500/10">
                    <i class="fa-solid fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="lg:ml-72 min-h-screen transition-all duration-300 bg-slate-50">
        <!-- Header: White Glossy -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-600 hover:text-blue-600 transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight uppercase italic">Manajemen Surat</h1>
                    <p class="text-[10px] text-slate-500 font-medium uppercase tracking-widest">Arsip Surat Masuk Database</p>
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

        <div class="p-4 lg:p-8 space-y-6 max-w-[1600px] mx-auto">

            <!-- Title Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 animate__animated animate__fadeIn">
                <div class="relative group">
                    <div class="relative">
                        <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tighter uppercase italic flex items-center gap-2">
                            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                            Arsip Surat Masuk
                        </h2>
                        <p class="text-[9px] text-blue-600 font-black ml-4 uppercase tracking-[0.3em]">TVRI Sumut • Central Cloud System</p>
                    </div>
                </div>

            </div>

            <!-- Outer Container Table -->
            <div class="bg-white rounded-[24px] md:rounded-[30px] overflow-hidden border border-slate-200 shadow-xl shadow-slate-200/50 animate__animated animate__fadeInUp">

                <!-- DESKTOP VIEW -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <!-- Heading Berwarna Blue-Slate -->
                            <tr class="bg-slate-900">
                                <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest border-b border-white/10">Informasi Dokumen</th>
                                <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest border-b border-white/10">Asal & Perihal</th>
                                <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center border-b border-white/10">Status & Sifat</th>
                                <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center border-b border-white/10">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($surat as $s)
                            <tr class="hover:bg-blue-50/50 transition-all group duration-300 relative {{ !$s->is_read ? 'bg-amber-50/40' : '' }}">
                                <td class="p-5">
                                    <div class="flex flex-col relative">
                                        <div class="flex items-center gap-2">
                                            <!-- INDIKATOR JIKA BELUM DILIHAT -->
                                            @if(!$s->is_read)
                                            <span class="inline-block w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                            <span class="px-2 py-0.5 rounded text-[8px] font-black tracking-wide bg-red-100 text-red-600 uppercase">NEW</span>
                                            @endif
                                            <span class="text-xs font-black text-slate-800 tracking-tight group-hover:text-blue-600 transition-colors italic">{{ $s->no_surat }}</span>
                                        </div>
                                        <span class="text-[9px] text-slate-500 mt-1 uppercase font-bold tracking-tighter">
                                            <i class="fa-solid fa-calendar-day mr-1"></i> {{ \Carbon\Carbon::parse($s->tanggal_surat)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="max-w-[250px]">
                                        <p class="text-[10px] font-black uppercase text-emerald-600 mb-0.5 tracking-tight">{{ $s->pengirim }}</p>
                                        <p class="text-xs text-slate-600 font-medium truncate italic">"{{ $s->perihal }}"</p>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="flex flex-col items-center gap-2">
                                        @php
                                        $statusColor = match($s->status) {
                                        'disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };
                                        $sifatColor = match($s->sifat) {
                                        'Rahasia' => 'text-red-600',
                                        'Penting' => 'text-amber-600',
                                        default => 'text-blue-600',
                                        };
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg border {{ $statusColor }} text-[8px] font-black uppercase italic tracking-widest">
                                            {{ $s->status ?? 'pending' }}
                                        </span>
                                        <span class="text-[8px] font-black uppercase {{ $sifatColor }} tracking-[0.2em]">
                                            Sifat: {{ $s->sifat }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-3">

                                        <!-- Tombol View - Mengirim data aman menggunakan representasi HTML Attribute -->
                                        <button type="button"
                                            data-surat="{{ json_encode($s) }}"
                                            data-route="{{ route('adminsekret.surat-masuk.read', $s->id) }}"
                                            data-read="{{ $s->is_read ?? 0 }}"
                                            onclick="bukaDanBacaSurat(this)"
                                            class="relative w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 bg-white border border-slate-200 shadow-sm hover:border-blue-500 hover:text-blue-600 text-slate-600">

                                            <i class="fa-solid fa-eye text-[11px]"></i>

                                            <!-- Dot Notifikasi nempel di pojok tombol jika belum dibaca -->
                                            @if(!$s->is_read)
                                            <span class="dot-notif-button absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                                            @endif
                                        </button>
                                        <!-- Edit Button -->
                                        <button @click='selectedSurat = {!! json_encode($s) !!}; editModal = true'
                                            class="relative w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 bg-white border border-slate-200 shadow-sm hover:border-amber-500 hover:text-amber-600 text-slate-600">
                                            <i class="fa-solid fa-pen-nib text-[11px]"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.surat.masuk.destroy', $s->id) }}" method="POST" onsubmit="return confirmDeleteGlobal(event, this, '{{ $s->no_surat }}')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="relative w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 bg-white border border-slate-200 shadow-sm hover:border-red-500 hover:text-red-600 text-slate-600">
                                                <i class="fa-solid fa-trash text-[11px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center text-slate-400 text-[10px] font-black uppercase tracking-[0.5em]">No Digital Records Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE VIEW -->
                <div class="md:hidden divide-y divide-slate-100">
                    @forelse($surat as $s)
                    <div class="p-6 space-y-4 hover:bg-slate-50 transition-all duration-300 pembungkus-surat">
                        <div class="flex justify-between items-start">
                            <!-- Beri class 'indikator-wrapper' pada elemen ini -->
                            <div class="flex items-center gap-2Pin indikator-wrapper">
                                <!-- INDIKATOR JIKA BELUM DILIHAT -->
                                @if(!$s->is_read)
                                <span class="inline-block w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                <span class="px-2 py-0.5 rounded text-[8px] font-black tracking-wide bg-red-100 text-red-600 uppercase badge-new"></span>
                                @endif
                                <span class="text-xs font-black text-slate-800 tracking-tight group-hover:text-blue-600 transition-colors italic">{{ $s->no_surat }}</span>
                            </div>

                            <div class="flex flex-col items-end gap-1">
                                <span class="px-2 py-0.5 rounded-md border {{ $statusColor }} text-[7px] font-black uppercase tracking-widest italic">
                                    {{ $s->status ?? 'pending' }}
                                </span>
                                <span class="text-[7px] font-black uppercase {{ $sifatColor }} tracking-wider">
                                    {{ $s->sifat }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Pengirim</span>
                                <span class="text-[11px] font-black text-emerald-600 uppercase">{{ $s->pengirim }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Perihal</span>
                                <span class="text-xs text-slate-700 italic">"{{ $s->perihal }}"</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <div class="text-[9px] text-slate-500 font-bold uppercase italic tracking-widest">
                                <i class="fa-solid fa-calendar-day mr-1"></i> {{ \Carbon\Carbon::parse($s->tanggal_surat)->translatedFormat('d M Y') }}
                            </div>
                            <div class="flex gap-2">
                                <!-- Tombol View Mobile -->
                                <button type="button"
                                    data-surat="{{ json_encode($s) }}"
                                    data-route="{{ route('adminsekret.surat-masuk.read', $s->id) }}"
                                    data-read="{{ $s->is_read ?? 0 }}"
                                    onclick="bukaDanBacaSurat(this)"
                                    class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-blue-600 flex items-center justify-center shadow-sm hover:border-blue-500 transition-all">

                                    <i class="fa-solid fa-eye text-[10px]"></i>
                                </button>

                                <!-- Tombol Edit -->
                                <button @click='selectedSurat = {!! json_encode($s) !!}; editModal = true' class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-pen-nib text-[10px]"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.surat.masuk.destroy', $s->id) }}" method="POST" onsubmit="return confirmDeleteGlobal(event, this, '{{ $s->no_surat }}')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-red-600 flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center text-slate-400 text-[10px] font-black uppercase tracking-[0.3em]">
                        No Digital Records Found
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <div x-show="addModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak x-transition>
        <div class="absolute inset-0 bg-slate-950/95 backdrop-blur-md" @click="addModal = false"></div>
        <div class="glass-card w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-[35px] p-6 md:p-8 z-10 border border-white/10 animate__animated animate__fadeInDown custom-scrollbar">
            <h3 class="text-xl font-black text-white italic uppercase mb-6 flex items-center gap-3">
                <i class="fa-solid fa-plus-circle text-blue-500"></i> Registrasi <span class="text-blue-500">Surat</span>
            </h3>
            <form action="{{ route('admin.surat.masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">No Surat</label>
                        <input type="text" name="no_surat" required placeholder="001/TVRI/2026" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal</label>
                        <input type="date" name="tanggal_surat" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Asal Instansi</label>
                    <input type="text" name="pengirim" required placeholder="Nama Pengirim" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:border-blue-500 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[9px] font-black text-blue-400 uppercase tracking-widest ml-1">Sifat Dokumen</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['penting' => 'PENTING', 'segera' => 'SEGERA', 'rahasia' => 'RAHASIA'] as $val => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="sifat" value="{{ $val }}" class="peer hidden" {{ $val == 'penting' ? 'checked' : '' }}>
                            <div class="py-3 rounded-xl bg-white/[0.03] border border-white/10 text-center peer-checked:border-blue-500/50 peer-checked:bg-blue-500/10 transition-all">
                                <span class="text-[9px] font-black text-slate-500 peer-checked:text-blue-400 uppercase">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Perihal / Ringkasan</label>
                    <textarea name="perihal" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:border-blue-500 outline-none resize-none transition-all" rows="3"></textarea>
                </div>
                <div class="space-y-1" x-data="{ fileName: '' }">
                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Dokumen Lampiran</label>

                    <div class="relative group">
                        <div class="w-full bg-white/5 border-2 border-dashed border-white/10 rounded-2xl px-4 py-6 flex flex-col items-center justify-center gap-2 group-hover:border-blue-500/50 group-hover:bg-blue-500/5 transition-all cursor-pointer">

                            <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center mb-1 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-cloud-arrow-up text-blue-500 text-sm"></i>
                            </div>

                            <p class="text-[10px] text-slate-400 font-medium tracking-wide text-center" x-show="!fileName">
                                Drag & drop file atau <span class="text-blue-500 font-bold">Pilih File</span>
                            </p>

                            <div x-show="fileName" class="flex items-center gap-2 bg-blue-500/20 px-3 py-1.5 rounded-lg border border-blue-500/30">
                                <i class="fa-solid fa-file-pdf text-blue-400 text-[10px]"></i>
                                <span x-text="fileName" class="text-[10px] text-blue-200 font-bold italic truncate max-w-[150px]"></span>
                                <button type="button" @click="fileName = ''; $refs.fileInput.value = ''" class="text-blue-400 hover:text-red-500 ml-1">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                            </div>

                            <p class="text-[8px] text-slate-500 uppercase tracking-tighter">Maksimal: PDF, DOCX (10MB)</p>
                        </div>

                        <input type="file"
                            name="file_surat"
                            x-ref="fileInput"
                            @change="fileName = $refs.fileInput.files[0].name"
                            required
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                    </div>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" @click="addModal = false" class="flex-1 py-4 bg-white/5 text-slate-400 rounded-2xl text-[9px] font-black uppercase tracking-widest border border-white/5">Batal</button>
                    <button type="submit" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-xl shadow-blue-600/20">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="editModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak x-transition>
        <div class="absolute inset-0 bg-slate-950/95 backdrop-blur-md" @click="editModal = false"></div>
        <div class="glass-card w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-[35px] p-6 md:p-8 z-10 border border-white/10 animate__animated animate__zoomIn shadow-2xl custom-scrollbar">

            <h3 class="text-xl font-black text-white italic uppercase mb-6 flex items-center gap-3">
                <i class="fa-solid fa-arrows-rotate text-emerald-500"></i> Update <span class="text-emerald-500">Status Progres</span>
            </h3>

            <form :action="'{{ url('adminsekret/surat-masuk/update') }}/' + selectedSurat.id" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">No Surat</label>
                        <!-- Read Only -->
                        <input type="text" name="no_surat" x-model="selectedSurat.no_surat" readonly tabindex="-1"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-slate-400 cursor-default outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal</label>
                        <!-- Read Only -->
                        <input type="date" name="tanggal_surat" x-model="selectedSurat.tanggal_surat" readonly tabindex="-1"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-slate-400 cursor-default outline-none transition-all">
                    </div>
                </div>

                <!-- HANYA BAGIAN INI YANG BISA DIEDIT -->
                <div class="space-y-2">
                    <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest ml-1">Status Progres (Edit)</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <template x-for="st in [ {v:'pending', l:'PENDING'}, {v:'diproses', l:'DIPROSES'}, {v:'ditolak', l:'DITOLAK'}, {v:'disetujui', l:'SETUJU'} ]">
                            <label class="cursor-pointer">
                                <input type="radio" name="status" :value="st.v" x-model="selectedSurat.status" class="peer hidden">
                                <div class="py-2 rounded-xl bg-white/[0.03] border border-white/10 text-center peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 transition-all hover:bg-white/5">
                                    <span class="text-[8px] font-black text-slate-500 peer-checked:text-emerald-400 uppercase" x-text="st.l"></span>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Sifat Surat</label>
                    <div class="grid grid-cols-3 gap-2 pointer-events-none opacity-70">
                        <template x-for="sf in [ {v:'penting', l:'PENTING'}, {v:'segera', l:'SEGERA'}, {v:'rahasia', l:'RAHASIA'} ]">
                            <label>
                                <input type="radio" name="sifat" :value="sf.v" x-model="selectedSurat.sifat" class="peer hidden">
                                <div class="py-2 rounded-xl bg-white/[0.03] border border-white/10 text-center peer-checked:border-amber-500/50 peer-checked:bg-amber-500/10 transition-all">
                                    <span class="text-[8px] font-black text-slate-500 peer-checked:text-amber-400 uppercase" x-text="sf.l"></span>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Pengirim</label>
                    <!-- Read Only -->
                    <input type="text" name="pengirim" x-model="selectedSurat.pengirim" readonly tabindex="-1"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-slate-400 cursor-default outline-none">
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Perihal</label>
                    <!-- Read Only -->
                    <textarea name="perihal" x-model="selectedSurat.perihal" readonly tabindex="-1"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-slate-400 cursor-default outline-none resize-none" rows="3"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="editModal = false"
                        class="flex-1 py-4 bg-white/5 text-slate-400 rounded-2xl text-[9px] font-black uppercase tracking-widest border border-white/5 hover:bg-white/10 transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-xl shadow-emerald-600/20 active:scale-95 transition-all">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Surat Masuk -->
    <template x-teleport="body">
        <div x-show="detailModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-6"
            x-cloak
            x-data="{ activeTab: 'data' }"> <!-- State untuk Tab Mobile -->

            <!-- Backdrop -->
            <div x-show="detailModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="absolute inset-0 bg-slate-950/95 backdrop-blur-2xl"
                @click="detailModal = false"></div>

            <!-- Modal Content -->
            <div x-show="detailModal"
                x-transition:enter="transition ease-out duration-500 transform"
                x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="relative w-full max-w-6xl h-[90vh] md:h-[85vh] bg-slate-900/40 rounded-[30px] md:rounded-[45px] border border-white/10 shadow-[0_0_80px_-15px_rgba(0,0,0,0.6)] overflow-hidden flex flex-col z-10 backdrop-blur-md">

                <!-- Header -->
                <div class="px-6 md:px-10 py-4 md:py-6 border-b border-white/5 bg-white/[0.03] flex justify-between items-center flex-shrink-0">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div class="hidden md:flex w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 items-center justify-center text-white shadow-lg shadow-blue-500/20">
                            <i class="fa-solid fa-file-import text-lg"></i>
                        </div>
                        <div class="max-w-[200px] md:max-w-none">
                            <h2 class="text-white font-black italic uppercase tracking-tighter text-sm md:text-lg leading-none truncate" x-text="selectedSurat.no_surat"></h2>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="flex h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                <p class="text-[8px] md:text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em]">Incoming Mail Detail</p>
                            </div>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button @click="detailModal = false" class="group w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-red-500 transition-all border border-white/10">
                        <i class="fa-solid fa-xmark text-slate-400 group-hover:text-white text-xs"></i>
                    </button>
                </div>

                <!-- TAB SWITCHER (Hanya muncul di Mobile < lg) -->
                <div class="flex lg:hidden bg-slate-900/50 p-1 border-b border-white/5">
                    <button @click="activeTab = 'data'"
                        :class="activeTab === 'data' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400'"
                        class="flex-1 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                        Informasi
                    </button>
                    <button @click="activeTab = 'preview'"
                        :class="activeTab === 'preview' ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400'"
                        class="flex-1 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                        Preview PDF
                    </button>
                </div>

                <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">

                    <!-- KIRI: Sidebar Informasi (Muncul jika activeTab 'data' atau di layar Desktop) -->
                    <div :class="activeTab === 'data' ? 'flex' : 'hidden lg:flex'"
                        class="w-full lg:w-[350px] xl:w-[400px] p-6 md:p-10 overflow-y-auto border-r border-white/5 bg-slate-900/20 flex-col custom-scrollbar italic">

                        <div class="flex flex-wrap gap-2 mb-8">
                            <span class="px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-black uppercase tracking-widest" x-text="selectedSurat.sifat"></span>
                            <span class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-black uppercase tracking-widest" x-text="selectedSurat.status"></span>
                        </div>

                        <div class="space-y-8 flex-1">
                            <div class="group">
                                <label class="text-[9px] font-black text-blue-500 uppercase tracking-[0.3em] mb-2 block">Origin / Pengirim</label>
                                <div class="text-xs md:text-sm text-white font-bold leading-tight uppercase tracking-tight" x-text="selectedSurat.pengirim"></div>
                            </div>

                            <div class="group">
                                <label class="text-[9px] font-black text-blue-500 uppercase tracking-[0.3em] mb-2 block">Subject / Perihal</label>
                                <div class="text-xs md:text-sm text-slate-300 leading-relaxed font-medium" x-text="selectedSurat.perihal"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 py-6 border-y border-white/5">
                                <div>
                                    <label class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1 block">Tgl. Surat</label>
                                    <div class="text-[10px] text-white font-black" x-text="selectedSurat.tanggal_surat"></div>
                                </div>
                                <div>
                                    <label class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1 block">Tgl. Arsip</label>
                                    <div class="text-[10px] text-white font-black" x-text="selectedSurat.created_at ? new Date(selectedSurat.created_at).toLocaleDateString('id-ID') : '-'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Sidebar (Download & Close) -->
                        <div class="mt-8 space-y-3">
                            <a :href="'{{ url('adminsekret/surat-masuk/download') }}/' + selectedSurat.file_surat"
                                class="group w-full flex items-center justify-between px-6 py-4 bg-white text-slate-950 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-blue-600 hover:text-white active:scale-95 shadow-xl shadow-white/5">
                                <span>Unduh Dokumen</span>
                                <i class="fa-solid fa-cloud-arrow-down text-base"></i>
                            </a>
                            <button @click="detailModal = false" class="lg:hidden w-full py-4 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                                Kembali ke List
                            </button>
                        </div>
                    </div>

                    <!-- KANAN: Preview Area (Muncul jika activeTab 'preview' atau di layar Desktop) -->
                    <div :class="activeTab === 'preview' ? 'flex' : 'hidden lg:flex'"
                        class="flex-1 bg-black/40 p-4 md:p-8 relative flex flex-col overflow-hidden h-full">

                        <div class="hidden md:flex mb-4 items-center gap-3 px-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em]">Integrated PDF Viewer</span>
                        </div>

                        <div class="flex-1 rounded-[25px] md:rounded-[40px] overflow-hidden border border-white/5 bg-[#0a0c10] shadow-2xl relative">
                            <template x-if="selectedSurat.file_surat">
                                <object :data="'{{ asset('uploads/surat_masuk') }}/' + encodeURIComponent(selectedSurat.file_surat)"
                                    type="application/pdf"
                                    class="w-full h-full opacity-90">

                                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center bg-slate-950">
                                        <div class="w-20 h-20 bg-blue-500/10 rounded-3xl flex items-center justify-center mb-6 border border-blue-500/20">
                                            <i class="fa-solid fa-file-pdf text-3xl text-blue-500"></i>
                                        </div>
                                        <h4 class="text-white text-xs font-black uppercase mb-3 tracking-widest">Dokumen Siap</h4>
                                        <p class="text-slate-500 text-[10px] mb-8 max-w-[240px] leading-relaxed italic uppercase font-bold">Preview tidak tersedia secara langsung di device ini.</p>

                                        <a :href="'{{ asset('uploads/surat_masuk') }}/' + encodeURIComponent(selectedSurat.file_surat)" target="_blank"
                                            class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase rounded-2xl shadow-lg shadow-blue-900/40 transition-all active:scale-95">
                                            Buka PDF di Tab Baru
                                        </a>
                                    </div>
                                </object>
                            </template>

                            <div x-show="!selectedSurat.file_surat" class="absolute inset-0 flex items-center justify-center bg-slate-950">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span class="mt-4 text-[10px] text-slate-600 font-black uppercase tracking-[0.3em]">Syncing Document...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </template>

    <style>
        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(14px);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            color: white;
            transition: all 0.3s;
        }

        .input-glass:focus {
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.07);
            outline: none;
        }
    </style>

    <form id="global-delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function bukaDanBacaSurat(buttonElement) {
            try {
                // 1. Ambil data dari atribut tombol
                const rawData = buttonElement.getAttribute('data-surat');
                const routeUrl = buttonElement.getAttribute('data-route');
                const isRead = parseInt(buttonElement.getAttribute('data-read'));

                // 2. Parse data JSON secara aman
                const suratObj = JSON.parse(rawData);

                // 3. Masukkan data ke Alpine dan Buka modal secara INSTAN di layar
                if (window.Alpine) {
                    const alpineComponent = buttonElement.closest('[x-data]');
                    if (alpineComponent) {
                        const alpineState = Alpine.$data(alpineComponent);

                        alpineState.selectedSurat = suratObj;
                        alpineState.detailModal = true;
                    }
                } else {
                    window.selectedSurat = suratObj;
                    window.detailModal = true;
                }

                // 4. Update status DB di latar belakang
                if (isRead === 0) {
                    fetch(routeUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                // Kunci tombol agar tidak mengirim request berulang jika diklik lagi
                                buttonElement.setAttribute('data-read', '1');

                                // --- PROSES SELEKSI & PEMBERSIHAN NOTIFIKASI SECARA INSTAN ---

                                // A. Bersihkan dot kecil yang menempel tepat di pojok tombol (Desktop / Mobile)
                                const internalDot = buttonElement.querySelector('.dot-notif-button');
                                if (internalDot) {
                                    internalDot.remove();
                                }

                                // B. Cari pembungkus data luar terdekat (untuk mencari badge NEW / efek ping)
                                const rowContainer = buttonElement.closest('.pembungkus-surat') || buttonElement.closest('tr');

                                if (rowContainer) {
                                    // Bersihkan bulatan ping merah di teks nomor surat (animate-ping)
                                    const pingDot = rowContainer.querySelector('.animate-ping');
                                    if (pingDot) pingDot.remove();

                                    // Bersihkan badge teks "NEW" (bg-red-100)
                                    const newBadge = rowContainer.querySelector('.bg-red-100');
                                    if (newBadge) newBadge.remove();

                                    // Cadangan cadangan: jika ada dot merah lain di dalam baris yang belum terhapus
                                    const genericRedDot = rowContainer.querySelector('.bg-red-500');
                                    if (genericRedDot && !genericRedDot.closest('button')) {
                                        genericRedDot.remove();
                                    }
                                }

                                // Tetap nyalakan trigger reload saat modal ditutup agar total counter sistem utama ikut sinkron
                                window.perluReloadSetelahTutup = true;
                            }
                        })
                        .catch(error => {
                            console.error('Error saat menandai surat:', error);
                        });
                }
            } catch (error) {
                console.error('Gagal memproses detail surat:', error);
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Ambil data session Laravel
            const msgSuccess = "{{ session('success') }}";
            const msgError = "{{ session('error') }}";
            const loginSuccess = "{{ session('login_success') }}";

            // 2. Notifikasi Berhasil (Store/Update/Delete)
            if (msgSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-white font-black italic uppercase tracking-widest text-sm">BERHASIL!</span>',
                    text: msgSuccess,
                    background: '#0f172a',
                    color: '#94a3b8',
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'rounded-[30px] border border-white/10 backdrop-blur-xl'
                    }
                });
            }

            // 3. Notifikasi Login
            if (loginSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-white font-black italic uppercase tracking-widest text-sm">ACCESS GRANTED</span>',
                    text: 'Otorisasi Berhasil. Selamat Datang!',
                    background: '#0f172a',
                    color: '#ffffff',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-[30px] border border-white/10'
                    }
                });
            }

            // 4. Notifikasi Error
            if (msgError) {
                Swal.fire({
                    icon: 'error',
                    title: '<span class="text-white font-black italic uppercase tracking-widest text-sm">GAGAL</span>',
                    text: msgError,
                    background: '#0f172a',
                    color: '#ffffff',
                    customClass: {
                        popup: 'rounded-[30px] border border-white/10'
                    }
                });
            }
        });


        function confirmDeleteGlobal(event, form, nomor) {
            // Stop form biar gak langsung hapus
            event.preventDefault();

            Swal.fire({
                title: '<span class="font-black italic text-white uppercase tracking-tighter">HAPUS ARSIP?</span>',
                html: `<p class="text-[10px] tracking-widest text-slate-400">Arsip No: <b class="text-white">${nomor}</b> akan dihapus permanen.</p>`,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                background: '#0f172a',
                confirmButtonText: 'YA, HAPUS',
                cancelButtonText: 'BATAL',
                buttonsStyling: false,
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[35px] border border-white/10 p-8 backdrop-blur-xl shadow-2xl',
                    confirmButton: 'px-8 py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest mx-2 shadow-lg shadow-red-600/20 active:scale-95 transition-all',
                    cancelButton: 'px-8 py-3 bg-white/5 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest mx-2 border border-white/5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form-nya kalau user klik OK
                    form.submit();
                }
            });

            return false;
        }

        function confirmDelete(url, nomor) {
            Swal.fire({
                title: '<span class="font-black italic text-white uppercase tracking-tighter">HAPUS ARSIP?</span>',
                html: `<p class="text-[10px] tracking-widest text-slate-400">Arsip No: <b class="text-white">${nomor}</b> akan dihapus permanen dari sistem.</p>`,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                background: '#0f172a',
                confirmButtonText: 'YA, HAPUS',
                cancelButtonText: 'BATAL',
                buttonsStyling: false,
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[35px] border border-white/10 p-8 backdrop-blur-xl shadow-2xl',
                    confirmButton: 'px-8 py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest mx-2 shadow-lg shadow-red-600/20 active:scale-95 transition-all',
                    cancelButton: 'px-8 py-3 bg-white/5 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest mx-2 border border-white/5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('global-delete-form');
                    form.action = url; // Mengisi URL action secara dinamis
                    form.submit(); // Kirim form
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