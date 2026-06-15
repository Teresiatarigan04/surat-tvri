<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebar: false, detailModal: false, selectedSurat: {} }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Surat Keluar | TVRI Sumut</title>

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
            background-image: radial-gradient(circle at top right, rgba(16, 185, 129, 0.12), transparent),
                radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.08), transparent);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0) 100%);
            border-left: 4px solid #10b981;
            color: #10b981;
        }

        /* PREMIUM SWEETALERT STYLES (MATCHING DASHBOARD) */
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

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden">

    <!-- Mobile Overlay -->
    <div x-show="mobileSidebar" x-transition.opacity class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <!-- Sidebar -->
    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900/50 backdrop-blur-2xl border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

        <div class="p-6 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-layer-group text-white text-xs"></i>
                </div>
                <span class="text-sm font-black tracking-tighter text-white uppercase">Divisi Panel</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto scrollbar-hide pb-4">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Workspace</p>

            <a href="{{ route('admin.divisi.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.divisi.dashboard') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-chart-pie text-sm"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('ajukan.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('ajukan.index') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-file-circle-plus text-sm"></i>
                <span class="text-sm font-semibold">Ajukan Surat</span>
            </a>

            <a href="{{ route('admindivisi.disposisi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('*/disposisi-masuk*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all group">
                <i class="fa-solid fa-file-import text-sm"></i>
                <span class="text-sm font-semibold">Disposisi Masuk</span>
            </a>

            <a href="{{ route('divisi.surat-masuk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('*/disposisi-masuk*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all group">
                <i class="fa-solid fa-inbox text-sm"></i>
                <span class="text-sm font-semibold">Surat Masuk</span>
            </a>


            <a href="{{ route('admindivisi.surat_keluar.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admindivisi.surat_keluar.*') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Surat Keluar</span>
            </a>

            <a href="{{ route('divisi.tracking.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-route text-sm"></i>
                <span class="text-sm font-semibold">Tracking Surat</span>
            </a>


            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-6 mb-2">Archive</p>

            <a href="{{ route('ajukan.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                <span class="text-sm font-semibold">Riwayat Pengajuan</span>
            </a>

        </nav>

        <div class="p-4 border-t border-white/5 bg-slate-900/40 backdrop-blur-md shrink-0">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-500/5">
                    <i class="fa-solid fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen pb-12 bg-slate-50"> <!-- Outer background lebih gelap sedikit untuk pembeda -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 px-4 lg:px-8 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-600 hover:text-emerald-600 transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight italic">Riwayat Surat Keluar</h1>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest italic flex items-center gap-2">
                        <span class="w-1 h-1 bg-emerald-500 rounded-full animate-ping"></span> Arsip Digital Divisi
                    </p>
                </div>
            </div>
            <div x-data="{ profileOpen: false }" class="relative">

                <!-- BUTTON TRIGGER (Sesuai Desain Anda) -->
                <button @click="profileOpen = true" class="flex items-center gap-3 focus:outline-none group transition-all">
                    <div class="hidden sm:flex flex-col items-end mr-2 text-right">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-tighter group-hover:text-emerald-600 transition-colors">
                            {{ Auth::user()->nama }}
                        </span>
                        <span class="text-[9px] text-emerald-600 flex items-center gap-1 font-black tracking-widest">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            ONLINE
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500 group-hover:rotate-6 transition-all duration-500">
                        <i class="fa-solid fa-user-gear text-emerald-600 group-hover:text-white transition-colors"></i>
                    </div>
                </button>

                <!-- SIDE MODAL CONTAINER -->
                <template x-teleport="body">
                    <div x-show="profileOpen"
                        class="fixed inset-0 z-[9999] overflow-hidden"
                        style="display: none;">

                        <!-- Backdrop Blur -->
                        <div x-show="profileOpen"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-400"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            @click="profileOpen = false"
                            class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm">
                        </div>

                        <!-- Panel Content (Slide dari Kanan) -->
                        <div class="absolute inset-y-0 right-0 flex max-w-full">
                            <div x-show="profileOpen"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full"
                                x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0"
                                x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-sm">

                                <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-[40px] border-l border-emerald-100 overflow-hidden">

                                    <!-- Header Profile: Modern Emerald Mesh -->
                                    <div class="relative h-64 bg-slate-950 flex flex-col items-center justify-center text-center p-6 rounded-bl-[60px]">
                                        <div class="absolute inset-0 overflow-hidden opacity-30">
                                            <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-600 rounded-full blur-[80px]"></div>
                                            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-500 rounded-full blur-[80px]"></div>
                                        </div>

                                        <div class="relative">
                                            <div class="w-24 h-24 rounded-3xl bg-emerald-500/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-4 shadow-2xl">
                                                <i class="fa-solid fa-user-gear text-4xl text-emerald-400"></i>
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 bg-emerald-500 border-4 border-slate-950 w-5 h-5 rounded-full shadow-lg"></div>
                                        </div>

                                        <h2 class="relative text-white font-black italic tracking-widest uppercase text-lg">
                                            {{ Auth::user()->nama }}
                                        </h2>
                                        <p class="relative text-emerald-400 text-[10px] font-bold tracking-[0.3em] uppercase mt-1">
                                            {{ Auth::user()->role }}
                                        </p>

                                        <!-- Close Button -->
                                        <button @click="profileOpen = false" class="absolute top-8 right-8 text-white/30 hover:text-white transition-all duration-300 hover:rotate-90">
                                            <i class="fa-solid fa-xmark text-2xl"></i>
                                        </button>
                                    </div>

                                    <!-- Info Section -->
                                    <div class="flex-1 px-8 py-10 overflow-y-auto">
                                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                                            <span class="w-8 h-[1px] bg-slate-200"></span>
                                            Detail Profil Pengguna
                                        </h3>

                                        <div class="space-y-4">
                                            <!-- ID Pengguna -->
                                            <div class="p-4 rounded-3xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-colors">
                                                <div class="flex flex-col">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Username</span>
                                                    <span class="text-sm font-bold text-slate-900 italic">@ {{ Auth::user()->username }}</span>
                                                </div>
                                                <i class="fa-solid fa-at text-emerald-500/30 group-hover:text-emerald-500 transition-colors"></i>
                                            </div>

                                            <!-- Role Akses -->
                                            <div class="p-4 rounded-3xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-colors">
                                                <div class="flex flex-col">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Role</span>
                                                    <span class="text-sm font-bold text-slate-900 italic tracking-tight">{{ Auth::user()->role }}</span>
                                                </div>
                                                <i class="fa-solid fa-shield-halved text-emerald-500/30 group-hover:text-emerald-500 transition-colors"></i>
                                            </div>

                                            <!-- Waktu Bergabung -->
                                            <div class="p-4 rounded-3xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-colors">
                                                <div class="flex flex-col">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Bergabung</span>
                                                    <span class="text-sm font-bold text-slate-900 italic">
                                                        {{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : 'N/A' }}
                                                    </span>
                                                </div>
                                                <i class="fa-solid fa-calendar-check text-emerald-500/30 group-hover:text-emerald-500 transition-colors"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="p-8 border-t border-slate-50 text-center bg-slate-50/30">
                                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic">
                                            TVRI System • Divisi Panel
                                        </p>
                                        <p class="text-[8px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">
                                            Versi 1.0.4 • 2026
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </header>

        <div class="p-4 lg:p-8 space-y-6 animate__animated animate__fadeIn">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">

                <!-- TOTAL PENGAJUAN -->
                <div class="bg-white p-4 md:p-6 rounded-[25px] md:rounded-[35px] relative overflow-hidden group border border-slate-200 hover:border-emerald-200 transition-all duration-500 shadow-sm hover:shadow-xl hover:-translate-y-1">
                    <div class="relative z-10">
                        <div class="w-9 h-9 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                            <i class="fa-solid fa-layer-group text-sm md:text-lg"></i>
                        </div>
                        <p class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Arsip</p>
                        <div class="flex items-baseline gap-1 md:gap-2">
                            <h3 class="text-2xl md:text-3xl font-black text-slate-900 mt-0.5 md:mt-1 tracking-tighter">{{ $surats->count() }}</h3>
                            <span class="text-[8px] md:text-[10px] font-bold text-emerald-500/50 uppercase italic">Docs</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-file-lines absolute -right-2 -bottom-2 md:-right-4 md:-bottom-4 text-5xl md:text-7xl text-slate-50 group-hover:text-emerald-50 transition-all duration-700"></i>
                </div>

                <!-- TERKIRIM -->
                <div class="bg-white p-4 md:p-6 rounded-[25px] md:rounded-[35px] relative overflow-hidden group border border-slate-200 hover:border-blue-200 transition-all duration-500 shadow-sm hover:shadow-xl hover:-translate-y-1">
                    <div class="relative z-10">
                        <div class="w-9 h-9 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                            <i class="fa-solid fa-paper-plane text-sm md:text-lg"></i>
                        </div>
                        <p class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Terkirim</p>
                        <div class="flex items-baseline gap-1 md:gap-2">
                            <h3 class="text-2xl md:text-3xl font-black text-slate-900 mt-0.5 md:mt-1 tracking-tighter">{{ $surats->where('status', 'terkirim')->count() }}</h3>
                            <span class="text-[8px] md:text-[10px] font-bold text-blue-500/50 uppercase italic">Sent</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-circle-check absolute -right-2 -bottom-2 md:-right-4 md:-bottom-4 text-5xl md:text-7xl text-slate-50 group-hover:text-blue-50 transition-all duration-700"></i>
                </div>

                <!-- PENDING / PROSES -->
                <div class="bg-white p-4 md:p-6 rounded-[25px] md:rounded-[35px] relative overflow-hidden group border border-slate-200 hover:border-amber-200 transition-all duration-500 shadow-sm hover:shadow-xl hover:-translate-y-1">
                    <div class="relative z-10">
                        <div class="w-9 h-9 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                            <i class="fa-solid fa-spinner animate-spin-slow text-sm md:text-lg"></i>
                        </div>
                        <p class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Proses</p>
                        <div class="flex items-baseline gap-1 md:gap-2">
                            <h3 class="text-2xl md:text-3xl font-black text-slate-900 mt-0.5 md:mt-1 tracking-tighter">{{ $surats->where('status', 'proses')->count() }}</h3>
                            <span class="text-[8px] md:text-[10px] font-bold text-amber-500/50 uppercase italic">Queue</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-hourglass-half absolute -right-2 -bottom-2 md:-right-4 md:-bottom-4 text-5xl md:text-7xl text-slate-50 group-hover:text-amber-50 transition-all duration-700"></i>
                </div>

                <!-- BULAN INI -->
                <div class="bg-white p-4 md:p-6 rounded-[25px] md:rounded-[35px] relative overflow-hidden group border border-slate-200 hover:border-purple-200 transition-all duration-500 shadow-sm hover:shadow-xl hover:-translate-y-1">
                    <div class="relative z-10">
                        <div class="w-9 h-9 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                            <i class="fa-solid fa-calendar-check text-sm md:text-lg"></i>
                        </div>
                        <p class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Bulan Ini</p>
                        <div class="flex items-baseline gap-1 md:gap-2">
                            <h3 class="text-2xl md:text-3xl font-black text-slate-900 mt-0.5 md:mt-1 tracking-tighter">
                                {{ $surats->where('tanggal_keluar', '>=', now()->startOfMonth()->toDateString())->count() }}
                            </h3>
                            <span class="text-[8px] md:text-[10px] font-bold text-purple-500/50 uppercase italic">New</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chart-pie absolute -right-2 -bottom-2 md:-right-4 md:-bottom-4 text-5xl md:text-7xl text-slate-50 group-hover:text-purple-50 transition-all duration-700"></i>
                </div>
            </div>

            <!-- Table Section -->
            <div class="space-y-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h3 class="text-sm font-black text-slate-800 uppercase italic tracking-[0.2em] flex items-center gap-3">
                        <i class="fa-solid fa-paper-plane text-emerald-500"></i> Riwayat Surat Keluar Saya
                    </h3>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                        <input type="text" placeholder="Cari nomor atau perihal..." class="bg-white border border-slate-200 rounded-2xl py-2 pl-10 pr-4 text-[10px] text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 w-full md:w-64 transition-all shadow-sm">
                    </div>
                </div>

                @if($surats->isEmpty())
                <div class="bg-white rounded-[30px] p-12 flex flex-col items-center justify-center text-center border-dashed border-2 border-slate-200 shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-ghost text-slate-300 text-2xl"></i>
                    </div>
                    <h4 class="text-slate-800 font-bold italic uppercase tracking-tighter">Tidak Ada Data</h4>
                    <p class="text-slate-500 text-[10px] uppercase font-bold mt-1">Surat keluar untuk pengajuan Anda belum tersedia.</p>
                </div>
                @else

                <!-- DESKTOP VIEW -->
                <div class="hidden md:block bg-white rounded-[30px] overflow-hidden border border-slate-200 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900 text-white">
                            <tr class="text-[9px] text-white uppercase tracking-widest border-b border-slate-100">
                                <th class="p-5">No. Surat / Tgl Keluar</th>
                                <th class="p-5">Tujuan (Divisi)</th>
                                <th class="p-5">Perihal</th>
                                <th class="p-5 text-center">Status</th>
                                <th class="p-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-[11px]">
                            @foreach($surats as $s)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="p-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 font-black italic tracking-tighter">{{ $s->no_surat_keluar }}</span>
                                        <span class="text-[8px] text-slate-400 font-bold uppercase mt-0.5">{{ $s->tanggal_keluar }}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <span class="text-slate-700 font-bold uppercase">{{ $s->tujuan }}</span>
                                </td>
                                <td class="p-5">
                                    <p class="text-slate-500 italic truncate max-w-[150px]">"{{ $s->perihal }}"</p>
                                </td>
                                <td class="p-5 text-center">
                                    <span class="px-3 py-1 rounded-full border {{ $s->status == 'terkirim' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-blue-50 text-blue-600 border-blue-100' }} text-[8px] font-black uppercase italic">
                                        {{ $s->status }}
                                    </span>
                                </td>
                                <td class="p-5 text-center">
                                    <button @click="current = {{ json_encode($s) }}; pdfUrl = '{{ asset('uploads/surat_keluar') }}/' + current.file_surat_final; showDetail = true;"
                                        class="h-8 px-4 rounded-lg bg-slate-900 text-white hover:bg-emerald-600 transition-all text-[9px] font-black uppercase shadow-sm">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE VIEW -->
                <div class="md:hidden space-y-3">
                    @foreach($surats as $s)
                    <div @click="current = {{ json_encode($s) }}; pdfUrl = '{{ asset('uploads/surat_keluar') }}/' + current.file_surat_final; showDetail = true;"
                        class="bg-white p-4 rounded-[25px] border border-slate-200 active:scale-95 transition-all shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex flex-col">
                                <span class="text-[7px] text-emerald-600 font-black uppercase tracking-widest">{{ $s->tanggal_keluar }}</span>
                                <h4 class="text-slate-900 font-black italic text-[11px] leading-tight">{{ $s->no_surat_keluar }}</h4>
                            </div>
                            <span class="px-2 py-0.5 rounded-md {{ $s->status == 'terkirim' ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }} text-[7px] font-black uppercase italic">{{ $s->status }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-50">
                            <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ Str::limit($s->tujuan, 20) }}</p>
                            <button class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100 font-black text-[8px] uppercase tracking-widest">
                                <i class="fa-solid fa-eye text-[9px]"></i> Detail
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>



        <body x-data="{ 
    mobileSidebar: false, 
    showDetail: false, 
    current: {}, 
    pdfUrl: '' 
}" class="text-slate-300 antialiased overflow-x-hidden">

            <!-- MODAL DETAIL SURAT KELUAR -->
            <template x-teleport="body">
                <div x-show="showDetail"
                    x-cloak
                    class="fixed inset-0 z-[100] flex items-center justify-center p-0 md:p-6 lg:p-10"
                    style="display: none;">

                    <!-- Overlay: Menggunakan backdrop blur yang lebih terang -->
                    <div x-show="showDetail"
                        x-transition:enter="transition opacity-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition opacity-in duration-200"
                        class="absolute inset-0 bg-slate-200/60 backdrop-blur-md"
                        @click="showDetail = false"></div>

                    <!-- Konten Modal: Putih Bersih -->
                    <div x-show="showDetail"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-data="{ activeTab: 'info' }"
                        class="relative bg-white border border-slate-200 w-full h-full md:h-[90vh] md:max-w-6xl md:rounded-[32px] shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden flex flex-col">

                        <!-- HEADER -->
                        <div class="shrink-0 px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-600 border border-emerald-500/20">
                                    <i class="fa-solid fa-file-signature text-xs"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Detail Arsip</h3>
                                    <p class="text-[10px] text-emerald-600 font-bold leading-none mt-1" x-text="current.no_surat_keluar"></p>
                                </div>
                            </div>
                            <button @click="showDetail = false" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>

                        <!-- TAB SWITCHER (Mobile Only) -->
                        <div class="flex md:hidden bg-slate-100/50 border-b border-slate-100 p-1.5">
                            <button @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'bg-white text-emerald-600 shadow-sm border-slate-200' : 'text-slate-500 border-transparent'"
                                class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-300 border">
                                <i class="fa-solid fa-circle-info mr-2"></i>Informasi
                            </button>
                            <button @click="activeTab = 'pdf'"
                                :class="activeTab === 'pdf' ? 'bg-white text-emerald-600 shadow-sm border-slate-200' : 'text-slate-500 border-transparent'"
                                class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-300 border">
                                <i class="fa-solid fa-file-pdf mr-2"></i>Preview PDF
                            </button>
                        </div>

                        <!-- MAIN CONTENT AREA -->
                        <div class="flex-1 flex flex-col md:flex-row overflow-hidden">

                            <!-- KIRI: INFO DETAIL -->
                            <div :class="activeTab === 'info' ? 'flex' : 'hidden md:flex'"
                                class="w-full md:w-[420px] flex-col p-6 md:p-8 overflow-y-auto border-r border-slate-100 bg-white">

                                <div class="space-y-6">
                                    <!-- ID Card Section -->
                                    <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-100/50">
                                        <span class="text-[8px] font-black text-emerald-600 uppercase tracking-[0.2em] block mb-2 italic">Identification Number</span>
                                        <p class="text-sm font-black text-slate-800 break-words tracking-tight" x-text="current.no_surat_keluar || '-'"></p>
                                    </div>

                                    <!-- Info List -->
                                    <div class="space-y-5">
                                        <div>
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Tujuan Instansi</label>
                                            <div class="flex items-start gap-3">
                                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                                <p class="text-xs font-bold text-slate-700 uppercase leading-relaxed" x-text="current.tujuan || '-'"></p>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Perihal Surat</label>
                                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 italic relative">
                                                <i class="fa-solid fa-quote-left absolute -top-2 -left-1 text-slate-200 text-xl"></i>
                                                <p class="text-xs font-medium text-slate-600 leading-relaxed" x-text="current.perihal || '-'"></p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                                <span class="text-[8px] text-slate-400 font-bold uppercase block mb-1">Status Dokumen</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full animate-pulse bg-emerald-500"></span>
                                                    <span class="text-[10px] font-black text-emerald-600 uppercase italic" x-text="current.status"></span>
                                                </div>
                                            </div>
                                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                                <span class="text-[8px] text-slate-400 font-bold uppercase block mb-1">Tanggal Keluar</span>
                                                <div class="flex items-center gap-2 text-slate-700">
                                                    <i class="fa-regular fa-calendar text-[10px]"></i>
                                                    <span class="text-[10px] font-black uppercase" x-text="current.tanggal_keluar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="pt-6 mt-auto">
                                        <a :href="pdfUrl" download
                                            class="flex items-center justify-center gap-3 bg-slate-900 hover:bg-emerald-600 text-white w-full py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-slate-200 active:scale-95">
                                            <i class="fa-solid fa-cloud-arrow-down text-sm"></i> Unduh Dokumen Arsip
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- KANAN: PREVIEW PDF -->
                            <div :class="activeTab === 'pdf' ? 'flex' : 'hidden md:flex'"
                                class="flex-1 bg-slate-100/50 relative flex flex-col">

                                <!-- Loading Indicator -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-10 h-10 border-[3px] border-emerald-500/20 border-t-emerald-500 rounded-full animate-spin"></div>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Menyiapkan Preview...</span>
                                    </div>
                                </div>

                                <!-- PDF Frame -->
                                <div class="relative z-10 w-full h-full p-3 md:p-6 lg:p-8">
                                    <template x-if="pdfUrl">
                                        <iframe :src="pdfUrl + '#toolbar=0&navpanes=0&view=FitH'"
                                            class="w-full h-full rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] border border-slate-200 bg-white">
                                        </iframe>
                                    </template>
                                </div>

                                <!-- Floating Indicator (Desktop Only) -->
                                <div class="hidden md:flex absolute bottom-10 left-1/2 -translate-x-1/2 bg-white/80 backdrop-blur px-4 py-2 rounded-full border border-slate-200 shadow-sm z-20 items-center gap-3">
                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Document Preview Mode</span>
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            </div>
    </main>

    <style>
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
        }

        /* Custom Scrollbar for Info Area */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
    </style>

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
    </script>
</body>

</html>