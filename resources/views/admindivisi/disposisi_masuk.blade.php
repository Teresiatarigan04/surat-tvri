<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebar: false, modalAjukan: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposisi Divisi | TVRI Sumut</title>

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

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
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


        .input-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            color: white;
            transition: all 0.3s;
        }

        .input-glass:focus {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
            outline: none;
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden">

    <div x-show="mobileSidebar" x-transition.opacity class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

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

            <a href="{{ route('divisi.surat-masuk') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('ajukan.index') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
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

    <main class="lg:ml-72 min-h-screen bg-[#f8fafc] pb-12" x-data="{ 
                    detailModal: false, 
                    balasanModal: false,
                    selectedDisposisi: { surat: {}, dari_admin: {}, balasan: {} } 
                }">

        <!-- HEADER -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-10 py-5 flex items-center justify-between animate__animated animate__fadeInDown transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                    <i class="fa-solid fa-bars-staggered text-lg"></i>
                </button>
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight italic uppercase">Divisi Console</h1>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        {{ Auth::user()->divisi_name ?? 'TVRI SUMATERA UTARA' }}
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

        <div class="p-4 lg:p-10 space-y-10 animate__animated animate__fadeIn">

            <!-- SECTION STATISTIK (DIBUAT LEBIH BANYAK & BERWARNA) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total -->
                <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all group border-b-4 border-b-slate-900">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-slate-200 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-layer-group text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Global</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Total Penugasan</p>
                    <p class="text-2xl font-black text-slate-900 italic">{{ $disposisis->count() }} <span class="text-xs font-normal text-slate-400 uppercase tracking-normal">Surat</span></p>
                </div>

                <!-- Approved -->
                <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all group border-b-4 border-b-emerald-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-100 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-emerald-300 uppercase tracking-widest">Ready</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Tugas Disetujui</p>
                    <p class="text-2xl font-black text-emerald-600 italic">{{ $disposisis->where('status', 'disetujui')->count() }} <span class="text-xs font-normal text-slate-400 uppercase tracking-normal">Aktif</span></p>
                </div>

                <!-- Pending -->
                <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-amber-100/50 transition-all group border-b-4 border-b-amber-400">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-amber-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-100 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-spinner animate-spin text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-amber-300 uppercase tracking-widest">Wait</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Menunggu Approval</p>
                    <p class="text-2xl font-black text-amber-500 italic">{{ $disposisis->where('status', 'pending')->count() }} <span class="text-xs font-normal text-slate-400 uppercase tracking-normal">Antre</span></p>
                </div>

                <!-- Completed -->
                <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-100/50 transition-all group border-b-4 border-b-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-100 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-square-poll-vertical text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-blue-300 uppercase tracking-widest">Done</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Sudah Dibalas</p>
                    <p class="text-2xl font-black text-blue-600 italic">{{ $disposisis->whereNotNull('balasan')->count() }} <span class="text-xs font-normal text-slate-400 uppercase tracking-normal">Selesai</span></p>
                </div>
            </div>

            <!-- TABLE SECTION -->
            <div x-data="{ hasViewedDetail: [] }" class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-4">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-[0.3em] italic flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-emerald-500"></span>
                        Log Instruksi Kerja Masuk
                    </h3>
                </div>

                @if($disposisis->isEmpty())
                <div class="bg-white rounded-[50px] p-24 text-center border-2 border-dashed border-slate-200 shadow-inner group">
                    <div class="inline-flex w-24 h-24 bg-slate-50 rounded-full items-center justify-center mb-6 group-hover:scale-110 transition-all">
                        <i class="fa-solid fa-inbox text-slate-200 text-5xl"></i>
                    </div>
                    <p class="text-slate-400 font-black italic uppercase tracking-[0.2em] text-sm">Kotak masuk masih kosong</p>
                </div>
                @else
                <div class="bg-white rounded-[45px] border border-slate-100 shadow-2xl overflow-hidden shadow-slate-200/50 transition-all overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1000px]">
                        <thead class="bg-slate-900">
                            <tr class="text-[10px] font-black text-white uppercase tracking-[0.2em]">
                                <th class="py-7 px-8">Informasi Surat &amp; Instruksi</th>
                                <th class="py-7 px-8 text-center">Status Alur</th>
                                <th class="py-7 px-8 text-center">Output Laporan</th>
                                <th class="py-7 px-8 text-center">Manajemen Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-[12px]">
                            @foreach ($disposisis as $d)
                            @php
                            $peranUser = trim(strtolower($d->peran));
                            $statusDoc = trim(strtolower($d->status));
                            $hasBalasan = $d->balasan ? true : false;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="p-8">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center gap-2">
                                            <span class="px-3 py-1 bg-emerald-500 text-white text-[9px] font-black rounded-lg uppercase tracking-widest shadow-sm shadow-emerald-200">
                                                {{ $d->surat->no_surat }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase italic font-black flex items-center gap-1">
                                                <i class="fa-solid fa-paper-plane text-[8px]"></i> Sekretariat
                                            </span>
                                        </div>
                                        <p class="text-base font-black text-slate-800 uppercase leading-tight tracking-tight group-hover:text-emerald-600 transition-colors">
                                            {{ $d->surat->perihal }}
                                        </p>

                                        @if(!empty($d->peran))
                                        <div class="flex flex-wrap items-center gap-2 mt-1">
                                            <span class="px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-wider border {{ $peranUser === 'pelaksana' ? 'text-rose-700 bg-rose-50 border-rose-200' : 'text-blue-700 bg-blue-50 border-blue-200' }}">
                                                Peran: {{ $d->peran }}
                                            </span>

                                            <span class="px-2.5 py-1 rounded-md text-[9px] font-bold text-slate-600 bg-slate-100 border border-slate-200 uppercase tracking-wide flex items-center gap-1">
                                                <i class="fa-solid fa-users text-[10px] text-slate-400"></i>
                                                @if(!empty($d->ketua_tim))
                                                Ketua Tim: {{ $d->ketua_tim }}
                                                @else
                                                {{ $peranUser === 'pelaksana' ? 'Pelaksana Langsung' : 'Pemantau Langsung' }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif

                                        <div class="p-5 bg-gradient-to-r from-amber-50 to-transparent rounded-3xl mt-2 border-l-4 border-amber-400 relative">
                                            <span class="text-[9px] text-amber-600 uppercase font-black tracking-widest mb-1 block">Catatan Pimpinan:</span>
                                            <p class="text-slate-600 font-bold italic text-[11px] leading-relaxed">"{{ $d->catatan }}"</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-8 text-center">
                                    @php
                                    $statusConfig = match($statusDoc) {
                                    'pending', 'diproses' => ['bg' => 'bg-amber-50 text-amber-600 border-amber-200', 'label' => 'Menunggu Tindak Lanjut'],
                                    'sedang dilaksanakan' => ['bg' => 'bg-indigo-50 text-indigo-600 border-indigo-200', 'label' => 'Sedang Dilaksanakan'],
                                    'selesai dilaksanakan', 'selesai' => ['bg' => 'bg-emerald-50 text-emerald-600 border-emerald-200', 'label' => 'Selesai Dilaksanakan'],
                                    'sudah dibaca' => ['bg' => 'bg-slate-100 text-slate-600 border-slate-300', 'label' => 'Sudah Dibaca (Selesai)'],
                                    default => ['bg' => 'bg-slate-50 text-slate-600 border-slate-200', 'label' => $d->status]
                                    };
                                    @endphp
                                    <span class="{{ $statusConfig['bg'] }} border px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-sm inline-block">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>

                                <td class="p-8 text-center">
                                    @if($peranUser === 'pemantau' && $statusDoc === 'sudah dibaca')
                                    <div class="flex flex-col items-center gap-1">
                                        <div class="bg-slate-50 text-slate-500 px-4 py-2 rounded-2xl border border-slate-200 flex items-center gap-2">
                                            <i class="fa-solid fa-eye text-slate-400"></i>
                                            <span class="text-[9px] font-black uppercase tracking-widest italic">Hanya Memantau</span>
                                        </div>
                                        <span class="text-[9px] text-slate-400 font-medium italic mt-1">Selesai Tanpa Lampiran</span>
                                    </div>
                                    @elseif($hasBalasan)
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-2xl border border-emerald-100 flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-xs"></i>
                                            <span class="text-[9px] font-black uppercase tracking-widest italic">Laporan Terkirim</span>
                                        </div>
                                        @if($d->balasan->file_balasan)
                                        <a href="{{ asset('uploads/balasan_disposisi/' . $d->balasan->file_balasan) }}" target="_blank" class="text-[10px] font-black uppercase text-slate-400 hover:text-blue-600 transition-all flex items-center gap-1 underline underline-offset-4">
                                            <i class="fa-solid fa-file-pdf text-rose-500"></i> Lihat File Balasan
                                        </a>
                                        @else
                                        <span class="text-[9px] text-slate-400 font-bold italic">Tanpa Lampiran Berkas</span>
                                        @endif
                                    </div>
                                    @else
                                    <div class="flex flex-col items-center opacity-50">
                                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center mb-2">
                                            <i class="fa-solid fa-hourglass-start text-slate-400 animate-spin" style="animation-duration: 3s;"></i>
                                        </div>
                                        <span class="text-slate-400 font-bold italic text-[9px] uppercase tracking-widest">Menunggu Respons</span>
                                    </div>
                                    @endif
                                </td>

                                <td class="p-6">
                                    <div class="flex flex-col gap-2.5 max-w-[180px] mx-auto">
                                        <button @click="selectedDisposisi = {{ json_encode($d->load(['surat', 'dariAdmin', 'balasan'])) }}; detailModal = true; if(!hasViewedDetail.includes({{ $d->id }})) { hasViewedDetail.push({{ $d->id }}) }"
                                            class="w-full h-10 px-4 rounded-xl bg-slate-100 text-slate-800 hover:bg-slate-900 hover:text-white transition-all duration-200 text-[10px] font-bold uppercase tracking-widest flex items-center justify-center gap-2 shadow-sm active:scale-95">
                                            <i class="fa-solid fa-circle-info text-slate-400"></i>
                                            <span>Info Detail</span>
                                        </button>

                                        {{-- ==================== LOGIKAL AKSI PEMANTAU ==================== --}}
                                        @if($peranUser === 'pemantau')
                                        @if($statusDoc !== 'sudah dibaca')
                                        <form id="form-baca-{{ $d->id }}" action="{{ route('admindivisi.disposisi.updateStatus') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $d->id }}">
                                            <input type="hidden" name="status" value="sudah dibaca">

                                            <button type="button"
                                                @click="verifyAndSubmitPemantau({{ $d->id }}, hasViewedDetail)"
                                                class="w-full h-10 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-wider active:scale-95 text-white shadow-md"
                                                :class="hasViewedDetail.includes({{ $d->id }}) ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200/50' : 'bg-amber-500 hover:bg-amber-600 shadow-amber-200/50'">
                                                <i class="fa-solid fa-eye-check"></i>
                                                <span>Konfirmasi Baca</span>
                                            </button>
                                        </form>
                                        @else
                                        <div class="text-center py-2 text-emerald-600 font-black tracking-wide uppercase text-[9px] bg-emerald-50 rounded-xl border border-emerald-100">
                                            <i class="fa-solid fa-check-double"></i> Terbaca &amp; Selesai
                                        </div>
                                        @endif

                                        {{-- ==================== LOGIKAL AKSI PELAKSANA (BERTAHAP) ==================== --}}
                                        @else
                                        {{-- TAHAP 1: Status Awal Baru Masuk (Pending/Diproses) -> Muncul Tombol Tindak Lanjut --}}
                                        @if($statusDoc === 'pending' || $statusDoc === 'diproses')
                                        <form action="{{ route('admindivisi.disposisi.updateStatus') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $d->id }}">
                                            <input type="hidden" name="status" value="sedang dilaksanakan">
                                            <button type="submit" class="w-full h-10 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-all duration-200 flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-wider active:scale-95 shadow-md shadow-indigo-200/50">
                                                <i class="fa-solid fa-play"></i>
                                                <span>Tindak Lanjut</span>
                                            </button>
                                        </form>

                                        {{-- TAHAP 2: Sedang Dilaksanakan -> Muncul Tombol Selesai --}}
                                        @elseif($statusDoc === 'sedang dilaksanakan')
                                        <form action="{{ route('admindivisi.disposisi.updateStatus') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $d->id }}">
                                            <input type="hidden" name="status" value="selesai dilaksanakan">
                                            <button type="submit" class="w-full h-10 rounded-xl bg-orange-500 hover:bg-orange-600 text-white transition-all duration-200 flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-wider active:scale-95 shadow-md shadow-orange-200/50">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <span>Selesai</span>
                                            </button>
                                        </form>

                                        {{-- TAHAP 3: Sudah Selesai Dilaksanakan Tetapi Belum Ada Balasan -> Muncul Tombol Kirim Balasan --}}
                                        @elseif(($statusDoc === 'selesai dilaksanakan' || $statusDoc === 'selesai') && !$hasBalasan)
                                        <button @click="selectedDisposisi = {{ json_encode($d) }}; balasanModal = true"
                                            class="w-full h-10 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition-all duration-200 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 active:scale-95 shadow-md shadow-emerald-200/50">
                                            <i class="fa-solid fa-paper-plane animate-pulse"></i>
                                            <span>Kirim Balasan</span>
                                        </button>

                                        {{-- TAHAP KUNCI: Sudah Mengirim Berkas Balasan Laporan --}}
                                        @elseif($hasBalasan)
                                        <div class="text-center py-2 text-slate-400 font-bold italic text-[10px] bg-slate-50 rounded-xl border border-slate-200">
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Tugas Selesai
                                        </div>
                                        @endif
                                        @endif

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <!-- MODAL 1: DETAIL LENGKAP (LEBIH JELAS & TERSTRUKTUR) -->
        <template x-teleport="body">
            <div x-show="detailModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 lg:p-10" x-cloak>
                <div x-show="detailModal" x-transition.opacity @click="detailModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>

                <div x-show="detailModal" x-transition.scale.origin.top class="relative w-full max-w-4xl bg-white rounded-[50px] overflow-hidden shadow-2xl max-h-[90vh] flex flex-col border border-white/20">
                    <div class="px-10 py-8 bg-slate-900 text-white flex justify-between items-center relative overflow-hidden">
                        <div class="absolute right-0 top-0 opacity-10 -mr-10 -mt-10">
                            <i class="fa-solid fa-envelope-open-text text-[150px]"></i>
                        </div>
                        <div class="relative z-10">
                            <h2 class="text-2xl font-black uppercase italic leading-none tracking-tight">Detail Penugasan</h2>
                            <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-[0.3em] mt-3">Monitoring Alur Kerja & Arsip Digital</p>
                        </div>
                        <button @click="detailModal = false" class="relative z-10 w-12 h-12 bg-white/10 hover:bg-rose-500 rounded-2xl flex items-center justify-center transition-all group">
                            <i class="fa-solid fa-times text-xl group-hover:rotate-90 transition-transform"></i>
                        </button>
                    </div>

                    <div class="p-10 overflow-y-auto space-y-10 custom-scrollbar">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-6 bg-slate-50 rounded-[35px] border border-slate-100">
                                <span class="text-slate-400 uppercase font-black text-[9px] tracking-[0.2em] mb-2 block italic">Nomor Surat Asli:</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-hashtag text-slate-400 text-xs"></i>
                                    </div>
                                    <p class="font-black text-slate-900 text-sm tracking-tighter uppercase" x-text="selectedDisposisi.surat?.no_surat || '-'"></p>
                                </div>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-[35px] border border-slate-100">
                                <span class="text-slate-400 uppercase font-black text-[9px] tracking-[0.2em] mb-2 block italic">Asal Sekretariat:</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-user-tie text-slate-400 text-xs"></i>
                                    </div>
                                    <p class="font-black text-slate-900 text-sm tracking-tighter uppercase" x-text="selectedDisposisi.dari_admin?.nama || 'Sekretariat'"></p>
                                </div>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-[35px] border border-slate-100">
                                <span class="text-slate-400 uppercase font-black text-[9px] tracking-[0.2em] mb-2 block italic">Tanggal Masuk:</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-calendar-check text-slate-400 text-xs"></i>
                                    </div>
                                    <p class="font-black text-slate-900 text-sm tracking-tighter uppercase" x-text="selectedDisposisi.created_at ? new Date(selectedDisposisi.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'"></p>
                                </div>
                            </div>
                        </div>

                        <div class="relative space-y-4">
                            <div class="relative">
                                <div class="absolute -left-4 top-0 w-1 h-full bg-emerald-500 rounded-full"></div>
                                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-4 italic">Perihal / Topik Utama:</h4>
                                <p class="text-2xl font-black text-slate-900 leading-snug ml-4 uppercase italic" x-text="selectedDisposisi.surat?.perihal"></p>
                            </div>

                            <template x-if="selectedDisposisi.peran">
                                <div class="flex flex-wrap items-center gap-3 ml-4 pt-1">
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all shadow-sm"
                                        :class="selectedDisposisi.peran.toLowerCase() === 'pelaksana' ? 'text-rose-700 bg-rose-50 border-rose-200 shadow-rose-100' : 'text-blue-700 bg-blue-50 border-blue-200 shadow-blue-100'">
                                        <i class="fa-solid mr-1" :class="selectedDisposisi.peran.toLowerCase() === 'pelaksana' ? 'fa-user-gear' : 'fa-eye'"></i>
                                        Peran: <span x-text="selectedDisposisi.peran"></span>
                                    </span>

                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black text-slate-700 bg-slate-50 border border-slate-200 uppercase tracking-wider shadow-sm flex items-center gap-1.5">
                                        <i class="fa-solid fa-sitemap text-slate-400"></i>
                                        <span x-text="selectedDisposisi.ketua_tim ? 'Ketua Tim: ' + selectedDisposisi.ketua_tim : (selectedDisposisi.peran.toLowerCase() === 'pelaksana' ? 'Pelaksana Langsung' : 'Pemantau Langsung')"></span>
                                    </span>
                                </div>
                            </template>
                        </div>

                        <div class="p-8 bg-amber-50 rounded-[40px] border-2 border-amber-100 relative overflow-hidden">
                            <i class="fa-solid fa-quote-right absolute right-8 top-8 text-amber-200 text-6xl opacity-50"></i>
                            <h4 class="text-[11px] font-black text-amber-700 uppercase italic tracking-widest mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-comment-dots"></i> Arahan Pimpinan Sekretariat:
                            </h4>
                            <p class="text-slate-700 font-bold italic leading-relaxed text-lg relative z-10" x-text="selectedDisposisi.catatan || 'Tidak ada catatan pimpinan'"></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic ml-4">Dokumen Sumber:</h4>
                                <a :href="'/uploads/surat_masuk/' + selectedDisposisi.surat?.file_surat" target="_blank"
                                    class="flex items-center justify-between p-6 bg-white border-2 border-slate-100 rounded-[35px] hover:border-emerald-500 transition-all group shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                                            <i class="fa-solid fa-file-pdf text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-900 text-xs uppercase tracking-tighter">File Surat Masuk</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase italic">Original PDF Dokumen</p>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-slate-300 group-hover:text-emerald-500 transition-colors"></i>
                                </a>
                            </div>

                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-widest italic ml-4">Dokumen Hasil (Output):</h4>

                                <template x-if="selectedDisposisi.peran?.toLowerCase() === 'pemantau'">
                                    <div class="flex items-center gap-4 p-6 bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-[35px] shadow-xl shadow-slate-200 border border-white/10 relative overflow-hidden group">
                                        <div class="absolute right-0 bottom-0 opacity-10 translate-x-4 translate-y-4 pointer-events-none">
                                            <i class="fa-solid fa-eye text-[80px]"></i>
                                        </div>
                                        <div class="w-12 h-12 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center shadow-inner border border-emerald-500/20">
                                            <i class="fa-solid fa-eye-check text-xl"></i>
                                        </div>
                                        <div class="relative z-10">
                                            <p class="font-black text-xs uppercase tracking-tight text-emerald-400">Status: Sudah Dibaca</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase italic mt-0.5">Disposisi dipantau & diarsipkan oleh divisi terkait</p>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="selectedDisposisi.peran?.toLowerCase() !== 'pemantau'">
                                    <div class="space-y-4 w-full">
                                        <template x-if="selectedDisposisi.balasan && selectedDisposisi.balasan.file_balasan">
                                            <a :href="'/uploads/balasan_disposisi/' + selectedDisposisi.balasan.file_balasan" target="_blank"
                                                class="flex items-center justify-between p-6 bg-blue-600 rounded-[35px] hover:bg-slate-900 transition-all group shadow-xl shadow-blue-100">
                                                <div class="flex items-center gap-4 text-white">
                                                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center transition-all">
                                                        <i class="fa-solid fa-check-double text-xl"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-black text-xs uppercase tracking-tighter">Laporan Balasan</p>
                                                        <p class="text-[9px] text-blue-200 font-bold uppercase italic">Selesai Dikerjakan</p>
                                                    </div>
                                                </div>
                                                <i class="fa-solid fa-download text-white/50 group-hover:text-white transition-colors"></i>
                                            </a>
                                        </template>

                                        <template x-if="selectedDisposisi.balasan && !selectedDisposisi.balasan.file_balasan">
                                            <div class="flex items-center gap-4 p-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[35px]">
                                                <div class="w-12 h-12 bg-slate-200 text-slate-500 rounded-2xl flex items-center justify-center shadow-inner">
                                                    <i class="fa-solid fa-file-circle-xmark text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="font-black text-slate-700 text-xs uppercase tracking-tighter">Tanpa Berkas Balasan</p>
                                                    <p class="text-[9px] text-slate-400 font-bold uppercase italic">Laporan diselesaikan dalam bentuk narasi</p>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="!selectedDisposisi.balasan">
                                            <div class="flex items-center gap-4 p-6 bg-rose-50 border-2 border-dashed border-rose-100 rounded-[35px]">
                                                <div class="w-12 h-12 bg-rose-100 text-rose-500 rounded-2xl flex items-center justify-center">
                                                    <i class="fa-solid fa-clock text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="font-black text-rose-700 text-xs uppercase tracking-tighter">Belum Ada Balasan</p>
                                                    <p class="text-[9px] text-rose-400 font-bold uppercase italic">Menunggu tindak lanjut divisi</p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <template x-if="selectedDisposisi.peran?.toLowerCase() !== 'pemantau' && selectedDisposisi.balasan">
                            <div class="p-8 bg-blue-50 rounded-[40px] border border-blue-100">
                                <h4 class="text-[11px] font-black text-blue-600 uppercase italic tracking-widest mb-4">Narasi Laporan Penyelesaian:</h4>
                                <p class="text-slate-700 font-bold italic leading-relaxed" x-text="selectedDisposisi.balasan.pesan_balasan || 'Tidak ada pesan tertulis'"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <!-- MODAL 2: FORM BALASAN (LAPORAN HASIL KERJA) -->
        <template x-teleport="body">
            <div x-show="balasanModal" class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-cloak>
                <div x-show="balasanModal" x-transition.opacity @click="balasanModal = false" class="absolute inset-0 bg-emerald-950/80 backdrop-blur-xl"></div>

                <div x-show="balasanModal" x-transition.scale.origin.bottom class="relative w-full max-w-xl bg-white rounded-[50px] p-10 lg:p-14 shadow-2xl border border-white/20">
                    <div class="text-center mb-10">
                        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <i class="fa-solid fa-paper-plane text-3xl"></i>
                        </div>
                        <h2 class="text-3xl font-black text-slate-900 uppercase italic mb-2 tracking-tight">Kirim Laporan</h2>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.2em] italic">Finalisasi penugasan divisi ke sekretariat</p>
                    </div>

                    <form action="{{ route('admindivisi.disposisi.balas') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <input type="hidden" name="disposisi_id" :value="selectedDisposisi.id">

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-6 italic tracking-widest">Narasi Ringkasan Pekerjaan</label>
                            <textarea name="pesan" required
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-[35px] p-8 text-sm font-bold text-black focus:outline-none focus:border-emerald-500 min-h-[150px] transition-all focus:bg-white placeholder:text-slate-400 shadow-inner"
                                placeholder="Contoh: Surat telah ditindaklanjuti dan berkas fisik telah diarsipkan..."></textarea>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-6 italic tracking-widest">
                                Dokumen Output (PDF, DOC, DOCX) <span class="text-amber-500 font-normal lowercase">(opsional)</span>
                            </label>

                            <div class="relative">
                                <input type="file" name="file_balasan" accept=".pdf,.doc,.docx"
                                    @change="cekUkuranFile($event)"
                                    class="w-full text-xs font-bold text-slate-500 file:mr-6 file:py-4 file:px-10 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white hover:file:bg-emerald-600 transition-all cursor-pointer bg-slate-50 rounded-full border-2 border-slate-100 pr-6">
                            </div>

                            <p class="text-[9px] text-slate-400 mt-2 ml-6 font-bold italic uppercase tracking-tighter">
                                *Ukuran maksimal dokumen 1MB (Format: PDF, DOC, DOCX) - Boleh dikosongkan
                            </p>
                        </div>

                        <div class="pt-4 flex gap-4">
                            <button type="button" @click="balasanModal = false" class="w-1/3 py-5 bg-slate-100 text-slate-500 rounded-full font-black text-[11px] uppercase tracking-[0.2em] hover:bg-rose-50 hover:text-rose-500 transition-all">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 py-5 bg-emerald-600 text-white rounded-full font-black text-[11px] uppercase tracking-[0.3em] shadow-xl shadow-emerald-200 hover:bg-slate-900 transition-all transform hover:-translate-y-1 active:scale-95">
                                Kirim Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </main>

    <style>
        /* Fluid Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        /* Input Focus Anim */
        input[type="file"]::file-selector-button {
            transition: all 0.3s ease;
        }

        /* Hover Row Table */
        table tbody tr:hover td {
            color: #10b981;
        }

        /* 1. Efek Blur Mewah pada Background Belakang */
        .swal2-backdrop-show {
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
        }

        /* 2. Desain Card Popup (Glassmorphism + Emerald Neon Glow) */
        .modern-swal-popup {
            border-radius: 32px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 50px rgba(16, 185, 129, 0.12) !important;
            /* Pendaran hijau tipis */
            padding: 2.5rem 2rem !important;
        }

        /* 3. Tipografi Modern & Clean */
        .modern-swal-title {
            font-weight: 900 !important;
            letter-spacing: 0.15em !important;
            font-size: 1.1rem !important;
            color: #ffffff !important;
            margin-top: 1.25rem !important;
        }

        .modern-swal-text {
            font-size: 0.9rem !important;
            color: #94a3b8 !important;
            /* Warna Slate-400 yang adem di mata */
            font-weight: 500 !important;
            line-height: 1.6 !important;
        }

        /* 4. Progress Bar Bergradasi Smooth */
        .modern-swal-progress {
            background: linear-gradient(90deg, #10b981, #34d399) !important;
            height: 3px !important;
        }

        /* =======================================================
   5. ANIMASI FLUID (Cubic-Bezier Spring Physics)
   ======================================================= */
        @keyframes fluidShow {
            0% {
                transform: scale(0.88) translateY(30px);
                opacity: 0;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        @keyframes fluidHide {
            0% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }

            100% {
                transform: scale(0.92) translateY(-15px);
                opacity: 0;
            }
        }

        /* Efek memantul lembut (overshoot) saat muncul */
        .swal2-fluid-show {
            animation: fluidShow 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) forwards !important;
        }

        /* Efek meluncur cepat saat menghilang */
        .swal2-fluid-hide {
            animation: fluidHide 0.25s cubic-bezier(0.36, 0.07, 0.19, 0.97) forwards !important;
        }
    </style>




    @if(session('login_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'SUCCESS', // Bersih dari inline-style
                text: "{{ session('login_success') }}",
                icon: 'success',
                iconColor: '#10b981', // Hijau emerald
                background: '#0f172a', // Slate 900
                color: '#ffffff',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                backdrop: `rgba(15, 23, 42, 0.65)`, // Sedikit diturunkan opasitasnya agar efek blur di belakangnya terlihat
                customClass: {
                    popup: 'modern-swal-popup',
                    title: 'modern-swal-title',
                    htmlContainer: 'modern-swal-text',
                    timerProgressBar: 'modern-swal-progress'
                },
                showClass: {
                    popup: 'swal2-fluid-show' // Animasi masuk kustom
                },
                hideClass: {
                    popup: 'swal2-fluid-hide' // Animasi keluar kustom
                }
            });
        });
    </script>
    @endif

    <script>
        function verifyAndSubmitPemantau(id, viewedArray) {
            // Memeriksa apakah ID disposisi ini sudah ada di dalam array hasViewedDetail
            if (!viewedArray.includes(id)) {
                Swal.fire({
                    title: 'Akses Ditolak!',
                    text: 'Anda wajib membuka menu "Info Detail" terlebih dahulu untuk membaca catatan/instruksi pimpinan secara seksama!',
                    icon: 'warning',
                    confirmButtonColor: '#f59e0b', // warna amber-500
                    confirmButtonText: 'Saya Mengerti',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest'
                    }
                });
            } else {
                // Jika sudah membaca, langsung submit form secara otomatis
                document.getElementById('form-baca-' + id).submit();
            }
        }

        function cekUkuranFile(event) {
            const file = event.target.files[0];
            if (file) {
                const maxSizeInBytes = 1024 * 1024; // 1MB

                if (file.size > maxSizeInBytes) {
                    Swal.fire({
                        title: 'File Terlalu Besar!',
                        html: `Ukuran maksimal dokumen adalah <b>1 MB</b>.<br>File yang Anda pilih berukuran: <span class="text-rose-500 font-bold">${(file.size / (1024 * 1024)).toFixed(2)} MB</span>.`,
                        icon: 'error',
                        confirmButtonColor: '#f59e0b', // Warna amber-500 biar serasi
                        confirmButtonText: 'Pilih File Lain',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest'
                        }
                    });

                    // Reset input file agar menjadi kosong kembali
                    event.target.value = '';
                }
            }
        }
    </script>

    @if ($errors->has('file_balasan'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Gagal Mengunggah Berkas!',
                text: '{{ $errors->first("file_balasan") }}',
                icon: 'error',
                confirmButtonColor: '#f59e0b',
                confirmButtonText: 'Perbaiki Dokumen',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-3 text-xs font-black uppercase tracking-widest'
                }
            });
        });
    </script>
    @endif

    {{-- Script untuk konfirmasi sebelum submit --}}
    <script>
        function confirmAction(form, actionType) {
            const color = actionType === 'disetujui' ? '#10b981' : '#ef4444';
            const text = actionType === 'disetujui' ? 'Setujui instruksi ini?' : 'Tolak instruksi ini?';

            Swal.fire({
                title: `<span style="font-weight:900; color:#fff; font-size:16px;">KONFIRMASI TINDAKAN</span>`,
                text: text,
                icon: 'question',
                iconColor: color,
                showCancelButton: true,
                confirmButtonColor: color,
                cancelButtonColor: 'transparent',
                confirmButtonText: 'YA, PROSES',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-confirm',
                    cancelButton: 'premium-swal-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
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
    </script>

</body>

</html>