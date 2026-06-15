<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebar: false, modalAjukan: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Divisi | TVRI Sumut</title>

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

        /* Styling Khusus SweetAlert2 Modern */
        .cyber-popup {
            border-radius: 30px !important;
            border: 1px solid rgba(16, 185, 129, 0.2) !important;
            /* Emerald Border */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(10px);
            padding: 2rem !important;
        }

        .cyber-title {
            font-family: 'Inter', 'Orbitron', sans-serif !important;
            font-weight: 900 !important;
            letter-spacing: 0.2em !important;
            font-style: italic !important;
            background: linear-gradient(to right, #ffffff, #10b981);


            -webkit-background-clip: text;

            background-clip: text;


            -webkit-text-fill-color: transparent;
            margin-top: 15px !important;
        }

        .cyber-icon {
            border-color: #10b981 !important;
            color: #10b981 !important;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
            scale: 0.8;
            /* Mengecilkan sedikit agar lebih rapi */
        }

        /* Progress Bar Animatif */
        .cyber-progress-bar {
            background: linear-gradient(to right, #10b981, #3b82f6) !important;
            height: 4px !important;
            border-radius: 2px !important;
        }

        /* Memperhalus tampilan icon success */
        .swal2-success-circular-line-left,
        .swal2-success-circular-line-right,
        .swal2-success-fix {
            background-color: transparent !important;
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

    <!-- Tambahkan Library Animasi di Header Layout Anda jika belum ada -->
   

    <main class="lg:ml-72 min-h-screen bg-slate-50 text-slate-600 overflow-x-hidden">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between animate__animated animate__fadeInDown transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight italic">Divisi Dashboard</h1>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest italic flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-ping"></span>
                        Unit: {{ Auth::user()->divisi_name ?? 'TVRI SUMUT' }}
                    </p>
                </div>
            </div>

            <!-- Wrapper State Profile -->
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

        <div class="p-4 lg:p-8 space-y-8">

            <!-- Welcome Card dengan Animasi FadeInUp -->
            <div class="relative p-8 rounded-[40px] bg-white border border-slate-200 overflow-hidden shadow-sm animate__animated animate__fadeInUp">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-60"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="animate__animated animate__fadeInLeft animate__delay-1s">
                        <h2 class="text-2xl font-black text-slate-900 italic uppercase tracking-tighter">
                            Halo, {{ Auth::user()->nama }}!
                        </h2>
                        <p class="text-slate-500 text-sm mt-1 max-w-md font-medium">
                            Selamat bekerja kembali. Pantau pengajuan divisi Anda atau ajukan surat baru di sini.
                        </p>
                    </div>
                    <a href="{{ route('ajukan.index') }}"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-200 transition-all active:scale-95 flex items-center gap-3 inline-flex animate__animated animate__bounceIn animate__delay-1s">
                        <i class="fa-solid fa-plus"></i> Ajukan Surat Baru
                    </a>
                </div>
                <i class="fa-solid fa-paper-plane absolute -right-4 -bottom-4 text-9xl text-emerald-500/[0.05] -rotate-12"></i>
            </div>

          

            <!-- Masukkan kode ini di file admindivisi/dashboard.blade.php Anda -->
            @if($surat_baru_masuk && $jumlah_terbaru > 0)
            <div class="mb-6 select-none animate__animated animate__fadeInDown">
                <div class="w-full rounded-[24px] bg-slate-900 border border-slate-800 p-4 sm:p-5 shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

                    <!-- Sisi Kiri: Status Indikator & Waktu Masuk -->
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative flex h-3 w-3 items-center justify-center flex-shrink-0">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                            <span class="text-[10px] font-black uppercase tracking-wider text-rose-400">
                                {{ $jumlah_terbaru }} Surat Belum Dibaca
                            </span>
                            <span class="hidden sm:inline text-slate-800 text-xs">•</span>
                            <span class="text-xs text-indigo-400 font-semibold">
                                {{ \Carbon\Carbon::parse($surat_baru_masuk->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Detail Data Surat Terkini -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 w-full sm:w-auto sm:text-right text-left">
                        <span class="text-white font-medium text-sm sm:text-base line-clamp-1 tracking-tight">
                            {{ $surat_baru_masuk->perihal ?? 'Tidak ada perihal' }}
                        </span>
                        <div class="flex items-center gap-2 text-xs text-slate-500 sm:justify-end">
                            <span>Asal: <strong class="text-slate-400 font-medium">{{ $surat_baru_masuk->asal_surat ?? 'Internal Sekretariat' }}</strong></span>
                            <span>•</span>
                            <span>No: <code class="text-cyan-400 bg-slate-950 px-1.5 py-0.5 rounded font-mono text-[11px]">{{ $surat_baru_masuk->no_surat ?? '-' }}</code></span>
                        </div>
                    </div>

                </div>
            </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">



                <!-- Card 1: Surat Masuk (Baru) -->
                <div class="group relative p-7 rounded-[35px] bg-white border border-slate-200 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/10 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-cyan-600 transition-colors">Surat Masuk</p>
                            <h3 class="text-5xl font-black text-slate-900 mt-3 tracking-tighter group-hover:scale-105 transition-transform origin-left">
                                {{ str_pad($stats['surat_masuk'] ?? 0, 2, '0', STR_PAD_LEFT) }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-500">
                            <i class="fa-solid fa-inbox text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Pengajuan Bulan Ini -->
                <div class="group relative p-7 rounded-[35px] bg-white border border-slate-200 transition-all duration-500 hover:-translate-y-2 hover:border-blue-500/30 hover:shadow-xl hover:shadow-blue-500/10 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-blue-600 transition-colors">Pengajuan</p>
                            <h3 class="text-5xl font-black text-slate-900 mt-3 tracking-tighter group-hover:scale-105 transition-transform origin-left">
                                {{ str_pad($stats['total_bulan_ini'] ?? 0, 2, '0', STR_PAD_LEFT) }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-all duration-500">
                            <i class="fa-solid fa-envelope-open-text text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Sedang Diproses -->
                <div class="group relative p-7 rounded-[35px] bg-white border border-slate-200 transition-all duration-500 hover:-translate-y-2 hover:border-amber-500/30 hover:shadow-xl hover:shadow-amber-500/10 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-amber-600 transition-colors">Proses</p>
                            <h3 class="text-5xl font-black text-amber-600 mt-3 tracking-tighter group-hover:scale-105 transition-transform origin-left">
                                {{ str_pad($stats['sedang_diproses'] ?? 0, 2, '0', STR_PAD_LEFT) }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500">
                            <i class="fa-solid fa-arrows-rotate text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Selesai -->
                <div class="group relative p-7 rounded-[35px] bg-white border border-slate-200 transition-all duration-500 hover:-translate-y-2 hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/10 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-emerald-600 transition-colors">Selesai</p>
                            <h3 class="text-5xl font-black text-emerald-600 mt-3 tracking-tighter group-hover:scale-105 transition-transform origin-left">
                                {{ str_pad($stats['disetujui'] ?? 0, 2, '0', STR_PAD_LEFT) }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Disposisi Masuk -->
                <div class="group relative p-7 rounded-[35px] bg-white border border-slate-200 transition-all duration-500 hover:-translate-y-2 hover:border-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/10 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-indigo-600 transition-colors">Disposisi</p>
                            <h3 class="text-5xl font-black text-indigo-600 mt-3 tracking-tighter group-hover:scale-105 transition-transform origin-left">
                                {{ str_pad($stats['disposisi_masuk'] ?? 0, 2, '0', STR_PAD_LEFT) }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500">
                            <i class="fa-solid fa-user-tag text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Table Section -->
            <div class="space-y-6 animate__animated animate__fadeInUp animate__delay-2s">
                <h3 class="text-sm font-black text-slate-800 uppercase italic tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Riwayat & Status Pengajuan
                </h3>
                <div class="bg-white rounded-[35px] overflow-hidden border border-slate-200 shadow-sm transition-all hover:shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-900">
                                <tr class="text-[10px] font-black text-white uppercase tracking-[0.2em]">
                                    <th class="p-6">No. Surat</th>
                                    <th class="p-6">Perihal</th>
                                    <th class="p-6">Tracking</th>
                                    <th class="p-6 text-center">Status</th>
                                    <th class="p-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($riwayats ?? [] as $index => $r)
                                <tr x-data
                                    x-init="$el.style.animationDelay = (2 + ({{ $index }} * 0.1)) + 's'"
                                    class="hover:bg-slate-50/80 transition-colors group animate__animated animate__fadeIn">
                                    <td class="p-6">
                                        <p class="text-xs font-bold text-slate-900 italic">{{ $r->no_surat }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-semibold">{{ $r->created_at->format('d M Y') }}</p>
                                    </td>
                                    <td class="p-6">
                                        <p class="text-sm font-semibold text-slate-700">{{ Str::limit($r->perihal, 35) }}</p>
                                    </td>
                                    <td class="p-6">
                                        @php
                                        $currentProgress = match($r->status) {
                                        'pending' => '30%',
                                        'diproses' => '65%',
                                        'disetujui', 'ditolak' => '100%',
                                        default => '10%'
                                        };
                                        $barColor = $r->status == 'ditolak' ? 'bg-red-500' : 'bg-emerald-500';
                                        @endphp
                                        <div class="w-32 bg-slate-100 h-2 rounded-full overflow-hidden">
                                            <div class="{{ $barColor }} h-full transition-all duration-1000"
                                                style="width: 0;"
                                                x-init="setTimeout(() => $el.style.width = '{{ $currentProgress }}', 2500)">
                                            </div>
                                        </div>
                                        <p class="text-[9px] mt-2 font-bold text-slate-400 uppercase italic">{{ $r->status }}</p>
                                    </td>
                                    <td class="p-6 text-center">
                                        @php
                                        $statusStyles = [
                                        'pending' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        'diproses' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                        $activeStyle = $statusStyles[$r->status] ?? $statusStyles['pending'];
                                        @endphp
                                        <span class="px-3 py-1 text-[9px] font-black rounded-full border {{ $activeStyle }} uppercase">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <a href="{{ route('divisi.tracking.index') }}" class="inline-flex w-9 h-9 rounded-xl bg-slate-100 text-slate-500 items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <!-- Empty State -->
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="p-8 text-center text-slate-400 mt-10 border-t border-slate-200 animate__animated animate__fadeIn">
            <p class="text-[10px] font-bold uppercase tracking-[0.5em]">© 2026 TVRI Sumatera Utara • Divisi Panel</p>
        </footer>

        <style>
            /* Optimasi Durasi */
            :root {
                --animate-duration: 800ms;
                --animate-delay: 0.5s;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-5px);
                }
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }

            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .animate-spin-slow {
                animation: spin-slow 6s linear infinite;
            }

            @keyframes bounce-soft {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            .animate-bounce-soft {
                animation: bounce-soft 2s ease-in-out infinite;
            }

            /* Custom Progress Animation */
            .progress-grow {
                animation: grow 1.5s ease-out forwards;
            }

            @keyframes grow {
                from {
                    width: 0;
                }
            }
        </style>
    </main>


    @if(session('login_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'ACCESS GRANTED',
                html: '<span style="color: #94a3b8; font-weight: 500;">Otorisasi Berhasil. Selamat Datang Kembali!</span>',
                icon: 'success',
                background: '#020617', // Sesuai bg dashboard
                color: '#ffffff',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: true,

                // Menambahkan Class Kustom untuk CSS
                customClass: {
                    popup: 'cyber-popup',
                    title: 'cyber-title',
                    timerProgressBar: 'cyber-progress-bar',
                    icon: 'cyber-icon'
                },

                // Animasi Masuk dan Keluar yang lebih fluid
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutDown animate__faster'
                },

                didOpen: () => {
                    // Menutup popup saat area manapun di popup diklik
                    Swal.getPopup().addEventListener('click', () => {
                        Swal.close();
                    });
                }
            });
        });
    </script>
    @endif {{-- Ini adalah penutup yang tadi hilang/salah --}}

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