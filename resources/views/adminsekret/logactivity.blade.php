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
    <title>Log Aktivitas | TVRI Sumut</title>

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

        ::-webkit-scrollbar-track {
            background: #020617;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden">

    <!-- Overlay Mobile -->
    <div x-show="mobileSidebar" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <!-- SIDEBAR INLINE -->
    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900/50 backdrop-blur-xl border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

        <div class="p-6 shrink-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-8" alt="Logo">
                <span class="text-sm font-black tracking-tighter text-white uppercase">E-Secretary</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto pb-4">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2 ">Main Menu</p>

            <a href="{{ route('admin.sekret.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('*/dashboard') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all group">
                <i class="fa-solid fa-house-chimney text-sm"></i>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.suratsekret.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Kirim Surat</span>
            </a>

            <a href="{{ route('admin.surat.masuk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white group">
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

            <div x-data="{ open: {{ request()->is('*/log*') || request()->is('*/kelola-akun*') ? 'true' : 'false' }} }" class="pt-4">
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
                        <i class="fa-solid fa-users-gear text-[10px]"></i>
                        <span>Kelola Akun</span>
                    </a>
                    <a href="{{ route('admin.log.index') }}"
                        class="flex items-center gap-3 px-4 py-2 text-xs font-medium transition-colors group {{ request()->is('*/log*') ? 'text-blue-400' : 'text-slate-500 hover:text-blue-400' }}">
                        <i class="fa-solid fa-clock-rotate-left text-[10px]"></i>
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

    <!-- MAIN CONTENT -->
    <main class="lg:ml-72 min-h-screen bg-slate-50 pb-20 selection:bg-blue-100">

        <!-- HEADER: Putih Bersih dengan Border Bawah Tebal -->
        <header class="sticky top-0 z-40 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <!-- SISI KIRI: JUDUL & MENU MOBILE -->
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 hover:text-slate-900 transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase italic">Log Aktivitas Sistem</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center gap-2">
                        Audit Trail • TVRI Sumatera Utara
                    </p>
                </div>
            </div>

            <!-- SISI KANAN: STATS & USER PROFILE -->
            <div class="flex items-center gap-6">
                <!-- QUICK STATS (Desktop) -->
                <div class="hidden md:flex items-center gap-5 border-r border-slate-200 pr-6">
                    <div class="text-right">
                        <p class="text-[9px] text-slate-400 uppercase font-black tracking-tighter">Total Logs</p>
                        <p class="text-slate-900 font-black text-sm leading-none">{{ $logsSekret->total() + $logsDivisi->total() }}</p>
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
            </div>
        </header>

        <div class="p-4 lg:p-8 space-y-10 max-w-7xl mx-auto">

            <!-- TREND CARDS: Background Putih dengan Border Lembut -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 animate__animated animate__fadeInUp">
                <div class="bg-white p-6 rounded-[30px] border-2 border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-2xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform border border-blue-100">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-blue-600/40 uppercase italic">Sekretariat</span>
                    </div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Aktivitas Hari Ini</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1 italic tracking-tighter">{{ $logsSekret->count() }} <span class="text-xs text-slate-400 not-italic font-medium">Logs</span></h3>
                </div>

                <div class="bg-white p-6 rounded-[30px] border-2 border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform border border-emerald-100">
                            <i class="fa-solid fa-users-gear text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-emerald-600/40 uppercase italic">Divisi</span>
                    </div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Aktivitas Hari Ini</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1 italic tracking-tighter">{{ $logsDivisi->count() }} <span class="text-xs text-slate-400 not-italic font-medium">Logs</span></h3>
                </div>

                <div class="bg-white p-6 rounded-[30px] border-2 border-slate-100 shadow-sm hover:shadow-md hover:border-purple-200 transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-2xl bg-purple-50 text-purple-600 group-hover:scale-110 transition-transform border border-purple-100">
                            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-purple-600/40 uppercase italic">Uptime</span>
                    </div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Status Server</p>
                    <h3 class="text-3xl font-black text-emerald-600 mt-1 italic tracking-tighter">STABLE</h3>
                </div>
            </div>

            <!-- SECTION 1: SEKRETARIAT -->
            <section class="animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 px-2">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-200">
                            <i class="fa-solid fa-folder-tree text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-slate-900 font-black uppercase tracking-wider text-lg italic">Log Sekretariat</h2>
                            <p class="text-xs text-slate-400 font-bold">Aktivitas admin sekretariat pusat</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-4 py-2 rounded-xl bg-white border-2 border-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest shadow-sm">
                            Page {{ $logsSekret->currentPage() }} of {{ $logsSekret->lastPage() }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-[40px] overflow-hidden border-2 border-slate-100 shadow-xl shadow-slate-200/50 transition-all duration-500">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px] lg:min-w-full">
                            <thead class="bg-slate-900 border-b border-slate-800">
                                <tr class="text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase italic">
                                    <th class="p-6 text-blue-400">User Info</th>
                                    <th class="p-6">Action Detail</th>
                                    <th class="p-6 text-center">Timestamp</th>
                                    <th class="p-6 text-right">Network</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($logsSekret as $log)
                                <tr class="hover:bg-blue-50/50 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                                <i class="fa-solid fa-circle-user text-lg"></i>
                                            </div>
                                            <div>
                                                <div class="font-black text-slate-900 text-sm tracking-tight group-hover:text-blue-600 transition-colors">{{ $log->user->nama ?? $log->username }}</div>
                                                <div class="text-[10px] text-slate-400 font-black uppercase tracking-tighter">{{ $log->role }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 text-[10px] font-black uppercase italic mb-2">
                                            {{ $log->aktivitas }}
                                        </div>
                                        <p class="text-xs text-slate-500 max-w-xs leading-relaxed italic"><span class="text-slate-400 font-bold not-italic">Akses:</span> {{ $log->halaman }}</p>
                                    </td>
                                    <td class="p-6 text-center">
                                        <div class="text-xs text-slate-900 font-black">
                                            {{ $log->created_at->translatedFormat('H:i') }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold">
                                            {{ $log->created_at->translatedFormat('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <span class="text-[10px] font-mono bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 group-hover:text-blue-600 group-hover:border-blue-200 transition-colors font-bold">
                                            {{ $log->ip_address }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center text-slate-300 font-black uppercase tracking-widest italic">No Records Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-8">
                    {{ $logsSekret->appends(['divisi_page' => $logsDivisi->currentPage()])->links() }}
                </div>
            </section>

            <!-- SECTION 2: DIVISI -->
            <section class="animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 px-2">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200 text-white">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <h2 class="text-slate-900 font-black uppercase tracking-wider text-lg italic">Log Divisi</h2>
                            <p class="text-xs text-slate-400 font-bold">Aktivitas admin setiap divisi lapangan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-4 py-2 rounded-xl bg-white border-2 border-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest shadow-sm">
                            Page {{ $logsDivisi->currentPage() }} of {{ $logsDivisi->lastPage() }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-[40px] overflow-hidden border-2 border-slate-100 shadow-xl shadow-slate-200/50 transition-all duration-500">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px] lg:min-w-full">
                            <thead class="bg-slate-900 border-b border-slate-800">
                                <tr class="text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase italic">
                                    <th class="p-6 text-emerald-400">User Info</th>
                                    <th class="p-6">Action Detail</th>
                                    <th class="p-6 text-center">Timestamp</th>
                                    <th class="p-6 text-right">Network</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($logsDivisi as $log)
                                <tr class="hover:bg-emerald-50/50 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                                                <i class="fa-solid fa-user text-lg"></i>
                                            </div>
                                            <div>
                                                <div class="font-black text-slate-900 text-sm tracking-tight group-hover:text-emerald-600 transition-colors">{{ $log->user->nama ?? $log->username }}</div>
                                                <div class="text-[10px] text-slate-400 font-black uppercase tracking-tighter">{{ $log->role }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] font-black uppercase italic mb-2">
                                            {{ $log->aktivitas }}
                                        </div>
                                        <p class="text-xs text-slate-500 max-w-xs leading-relaxed italic"><span class="text-slate-400 font-bold not-italic">Akses:</span> {{ $log->halaman }}</p>
                                    </td>
                                    <td class="p-6 text-center">
                                        <div class="text-xs text-slate-900 font-black">{{ $log->created_at->format('H:i') }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold">{{ $log->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <span class="text-[10px] font-mono bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 group-hover:text-emerald-600 group-hover:border-emerald-200 transition-colors font-bold">
                                            {{ $log->ip_address }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center text-slate-300 font-black uppercase tracking-widest italic">No Records Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-8">
                    {{ $logsDivisi->appends(['sekret_page' => $logsSekret->currentPage()])->links() }}
                </div>
            </section>

        </div>
    </main>

    <style>
        /* Tambahkan sedikit animasi fluid untuk tabel */
        .glass-card table tr {
            transition: transform 0.2s ease;
        }

        /* Responsivitas khusus HP agar tulisan nyaman */
        @media (max-width: 640px) {
            .glass-card {
                border-radius: 25px;
            }

            /* Membuat header tabel tetap terlihat atau scroll hint */
            .overflow-x-auto::-webkit-scrollbar {
                height: 3px;
            }

            .p-6 {
                padding: 1.25rem 1rem;
            }

            h1 {
                font-size: 1.125rem;
            }
        }

        /* Custom Scrollbar untuk Table */
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.2);
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