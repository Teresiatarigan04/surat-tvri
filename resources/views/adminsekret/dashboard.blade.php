<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebar: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sekretariat | TVRI Sumut</title>

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

        /* Custom SweetAlert Premium Styling */
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

<body x-data="{ mobileSidebar: false, show: false }"
    x-init="setTimeout(() => show = true, 100)"
    class="text-slate-300 antialiased overflow-x-hidden">

    <div x-show="mobileSidebar"
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
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Main Menu</p>

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

    <main class="lg:ml-72 min-h-screen transition-all duration-300 bg-white text-slate-600 font-sans">

        <!-- Header: Putih Bersih dengan Shadow Halus -->
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
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight uppercase italic">Dashboard</h1>
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
            <!-- Banner Notifikasi Ultra Modern Minimalist (Deep Navy Edition) -->
            @if($suratBelumDibaca > 0)
            <div x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mb-6 overflow-hidden">
                <div class="relative p-5 rounded-[28px] bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 border border-slate-800 shadow-2xl shadow-slate-950/40 text-white flex flex-col sm:flex-row items-center justify-between gap-5 group/banner transition-all duration-500 hover:border-blue-500/30">

                    <!-- Efek Simetris Glow Latar Belakang -->
                    <div class="absolute right-0 top-0 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl pointer-events-none transition-all duration-700 group-hover/banner:bg-blue-500/20"></div>
                    <div class="absolute left-1/4 bottom-0 w-36 h-36 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Sisi Kiri: Layout Kompak Icon & Detail -->
                    <div class="relative z-10 flex items-center gap-4 text-center sm:text-left flex-col sm:flex-row w-full sm:w-auto">
                        <!-- Badge Icon dengan Glassmorphism Efek Menyala -->
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500/20 to-transparent backdrop-blur-md flex items-center justify-center border border-blue-500/20 shadow-lg text-blue-400 flex-shrink-0 relative">
                            <i class="fa-solid fa-bell animate-pulse"></i>
                            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-blue-400 rounded-full animate-ping"></span>
                        </div>

                        <div class="space-y-0.5">
                            <h4 class="text-sm font-black tracking-tight text-slate-100 flex items-center justify-center sm:justify-start gap-2">
                                Dokumen Baru Masuk
                                <span class="text-[9px] font-black tracking-widest bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded-full uppercase">Review</span>
                            </h4>
                            <p class="text-xs text-slate-400 font-medium tracking-wide">
                                Ada <span class="font-extrabold text-white">{{ $suratBelumDibaca }} berkas surat</span> di dashboard sekretariat yang belum sempat Anda periksa.
                            </p>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Tombol Panah Lingkaran Minimalis Modern -->
                    <div class="relative z-10 w-full sm:w-auto flex justify-center sm:justify-end flex-shrink-0">
                        <a href="{{ route('admin.surat.masuk') }}"
                            class="w-12 h-12 rounded-full bg-white/[0.03] hover:bg-blue-600 border border-white/10 hover:border-blue-500 text-slate-300 hover:text-white flex items-center justify-center shadow-lg transition-all duration-500 hover:scale-105 group/btn overflow-hidden relative">

                            <!-- Efek Efek Sorot Mengkilap Saat Hover Tombol -->
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_1s_infinite]"></div>

                            <i class="fa-solid fa-arrow-right text-sm transition-transform duration-500 group-hover/btn:translate-x-1.5 group-hover/btn:scale-110"></i>
                        </a>
                    </div>

                </div>
            </div>
            @endif

            <!-- Stats Grid: Menggunakan Shadow agar "Outer" terlihat jelas di BG Putih -->
            <div x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Surat Masuk -->
                <div class="group relative p-6 rounded-[30px] bg-white border border-slate-100 shadow-xl shadow-slate-200/50 transition-all duration-500 hover:-translate-y-2 hover:border-blue-500/30 hover:shadow-blue-500/10">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-blue-600 transition-colors">Surat Masuk</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalSuratMasuk }}</h3>
                                <span class="text-[9px] bg-emerald-100 text-emerald-600 px-2 py-0.5 rounded-full font-bold mb-1">+{{ $suratMasukBaru }} Baru</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 animate-float">
                            <i class="fa-solid fa-envelope-open-text text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Surat Keluar -->
                <div class="group relative p-6 rounded-[30px] bg-white border border-slate-100 shadow-xl shadow-slate-200/50 transition-all duration-500 hover:-translate-y-2 hover:border-emerald-500/30 hover:shadow-emerald-500/10">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-emerald-600 transition-colors">Surat Keluar</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalSuratKeluar }}</h3>
                                <span class="text-[9px] text-slate-400 font-bold mb-1 italic">{{ $suratKeluarBulanIni }} Bulan Ini</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 animate-float-delay">
                            <i class="fa-solid fa-paper-plane text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Disposisi Pending -->
                <div class="group relative p-6 rounded-[30px] bg-white border border-slate-100 shadow-xl shadow-slate-200/50 transition-all duration-500 hover:-translate-y-2 hover:border-purple-500/30 hover:shadow-purple-500/10">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-purple-600 transition-colors">Disposisi</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalDisposisiPending }}</h3>
                                <span class="text-[9px] bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full font-bold mb-1">PENDING</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500 animate-spin-slow">
                            <i class="fa-solid fa-share-nodes text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- User Aktif -->
                <div class="group relative p-6 rounded-[30px] bg-white border border-slate-100 shadow-xl shadow-slate-200/50 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-500/30 hover:shadow-cyan-500/10">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-cyan-600 transition-colors">User Sistem</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $userAktif }}</h3>
                                <span class="text-[9px] text-slate-400 font-bold mb-1 italic">Total Akun</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-500 animate-bounce-soft">
                            <i class="fa-solid fa-users text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Table Section -->
            <div x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-500"
                x-transition:enter-start="opacity-0 translate-y-12"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase italic flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span> Surat Masuk Terbaru
                        </h2>
                    </div>

                </div>

                <div class="rounded-[35px] overflow-hidden border border-slate-100 bg-white shadow-2xl shadow-slate-200/60">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <!-- Header Tabel: Warna Biru Gelap agar Kontras -->
                                <tr class="bg-slate-900">
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest border-b border-white/5">No. Surat & Tgl</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest border-b border-white/5">Perihal</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest border-b border-white/5">Pengirim</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center border-b border-white/5">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($riwayats as $r)
                                <tr class="hover:bg-slate-50 transition-all group">
                                    <td class="p-5">
                                        <p class="text-sm font-bold text-slate-900 italic group-hover:text-blue-600 transition-colors">{{ $r->no_surat }}</p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">{{ \Carbon\Carbon::parse($r->tanggal_surat)->translatedFormat('d F Y') }}</p>
                                    </td>
                                    <td class="p-5">
                                        <p class="text-sm font-medium text-slate-600 max-w-xs truncate">{{ $r->perihal }}</p>
                                        <div class="flex gap-1 mt-1">
                                            <span class="text-[8px] font-black px-2 py-0.5 rounded bg-slate-100 text-slate-500 uppercase">{{ $r->sifat }}</span>
                                        </div>
                                    </td>
                                    <td class="p-5">
                                        <span class="text-[10px] font-black uppercase text-slate-700 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100 block w-fit">
                                            <i class="fa-solid fa-building text-[8px] mr-1 text-blue-500"></i> {{ $r->pengirim }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <a href="{{ route('admin.surat.masuk') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                            <i class="fa-solid fa-arrow-right text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-300">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <i class="fa-solid fa-box-open text-4xl opacity-20"></i>
                                            <p class="text-[10px] font-black uppercase tracking-widest">Belum ada data surat</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer x-show="show"
            x-transition:enter="transition ease-out duration-1000 delay-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="p-8 text-center text-slate-400 border-t border-slate-50 mt-10">
            <p class="text-[9px] font-black uppercase tracking-[0.8em]">© 2026 TVRI Sumatera Utara • E-Secretary System</p>
        </footer>

        <!-- Styles Tetap Dipertahankan -->
        <style>
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-6px);
                }
            }

            @keyframes bounce-soft {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.08);
                }
            }

            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .animate-float {
                animation: float 3.5s ease-in-out infinite;
            }

            .animate-float-delay {
                animation: float 3.5s ease-in-out infinite 1.2s;
            }

            .animate-spin-slow {
                animation: spin-slow 12s linear infinite;
            }

            .animate-bounce-soft {
                animation: bounce-soft 2.5s ease-in-out infinite;
            }

            ::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #e2e8f0;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #cbd5e1;
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