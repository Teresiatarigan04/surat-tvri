<!DOCTYPE html>
<html lang="id" x-data="trackingSystem()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tracking Surat | TVRI Sumut</title>

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

        :root {
            --primary: #10b981;
            --bg-dark: #020617;
        }

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
            color: #10b981 !important;
        }

        /* Timeline & Status Animations */
        @keyframes custom-ping {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(2.2);
                opacity: 0;
            }
        }

        .animate-status-ping {
            animation: custom-ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        .timeline-connector {
            position: absolute;
            left: 11px;
            top: 28px;
            bottom: -12px;
            width: 2px;
            background: linear-gradient(to bottom, rgba(16, 185, 129, 0.3), rgba(255, 255, 255, 0.05));
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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



        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden no-scrollbar">
    <!-- Pindahkan x-data ke pembungkus paling luar agar semua elemen bisa berbagi state -->
    <div x-data="trackingSystem()" class="min-h-screen bg-slate-950 selection:bg-emerald-500/20">

        <!-- 1. Mobile Sidebar Overlay -->
        <div x-show="mobileSidebar"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 lg:hidden"
            @click="mobileSidebar = false">
        </div>
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

            <nav class="flex-1 px-3 space-y-1 overflow-y-auto no-scrollbar pb-4">
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

                <a href="{{ route('admindivisi.disposisi.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->is('*/disposisi-masuk*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
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

                <a href="{{ route('divisi.tracking.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('divisi.tracking.index') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-route text-sm"></i>
                    <span class="text-sm font-semibold">Tracking Surat</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-6 mb-2">Archive</p>

                <a href="{{ route('ajukan.riwayat') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('ajukan.riwayat') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
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
        <main class="lg:ml-72 min-h-screen bg-slate-50 pb-20 selection:bg-emerald-500/20 transition-all duration-300">

            <!-- Header -->
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

            <!-- Page Content -->
            <div class="p-4 lg:p-8 max-w-[1400px] mx-auto space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                    <div class="lg:col-span-7 xl:col-span-8 space-y-6 md:space-y-8 w-full">

                        <div class="relative overflow-hidden rounded-3xl md:rounded-[3rem] bg-white border border-slate-200 p-5 md:p-8 shadow-xl shadow-slate-200/50 group animate__animated animate__zoomIn">
                            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 md:w-80 md:h-80 bg-emerald-500/5 blur-[100px] rounded-full group-hover:bg-emerald-500/10 transition-all duration-1000"></div>

                            <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                                <div class="flex items-center gap-4 md:gap-6 w-full sm:w-auto">
                                    <div class="relative shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-emerald-500 blur-2xl opacity-10 animate-pulse"></div>
                                        <div class="relative w-14 h-14 md:w-20 md:h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl md:rounded-[2rem] flex items-center justify-center shadow-lg shadow-emerald-500/30 rotate-3 group-hover:rotate-0 transition-all">
                                            <i class="fa-solid fa-map-location-dot text-white text-xl md:text-3xl"></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tighter italic uppercase truncate">Monitoring Surat</h3>
                                        <p class="text-slate-500 text-xs font-medium mt-1 flex items-center gap-2 italic leading-snug">
                                            <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                            <span class="truncate">Klik kartu untuk melihat riwayat mendalam</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 p-3 pr-6 sm:pr-8 rounded-2xl md:rounded-3xl shadow-inner w-full sm:w-auto shrink-0">
                                    <div class="w-12 h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm shrink-0">
                                        <i class="fa-solid fa-inbox text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Surat Saya</p>
                                        <p class="text-xl md:text-2xl font-black text-slate-800 leading-none">{{ count($surats) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:gap-5 w-full">
                            @forelse($surats as $s)
                            @php
                            // 1. Ambil data kelompok disposisi berdasarkan surat
                            $group = $disposisis->where('surat_id', $s->id);
                            $hasDisposisi = $group->count() > 0;

                            // 2. Cek status final dari tabel induk surat masuk
                            $statusSuratFinal = in_array(strtolower($s->status), ['selesai', 'diarsip', 'disetujui', 'sudah ttd']);

                            // 3. Kalkulasi Berdasarkan Aturan ENUM Baru
                            $totalDisposisi = $group->count() ?: 1;

                            // Hitung yang sudah berstatus 'selesai dilaksanakan'
                            $totalSelesai = $group->filter(function($item) {
                            return strtolower($item->status) === 'selesai dilaksanakan';
                            })->count();

                            // Hitung yang berstatus 'sudah dibaca'
                            $totalDibaca = $group->filter(function($item) {
                            return strtolower($item->status) === 'sudah dibaca';
                            })->count();

                            // 4. Hitung persentase progress bar
                            $widthSelesai = ($totalSelesai / $totalDisposisi) * 100;
                            $widthDibaca = ($totalDibaca / $totalDisposisi) * 100;

                            // 5. Logika Kesimpulan Akhir Status
                            $isFullyCompleted = $statusSuratFinal || ($hasDisposisi && $totalSelesai === $totalDisposisi);

                            // 6. Alokasikan String Lebar CSS
                            $cssWidthSelesai = ($hasDisposisi ? $widthSelesai : ($isFullyCompleted ? 100 : 0)) . '%';
                            $cssWidthDibaca = ($hasDisposisi ? $widthDibaca : ($hasDisposisi && $totalSelesai == 0 ? 100 : 0)) . '%';
                            @endphp

                            <div @click="fetchDetail({{ $s->id }})"
                                class="group relative bg-white hover:bg-slate-50 border border-slate-200 hover:border-emerald-500/40 rounded-3xl md:rounded-[2.5rem] p-4 sm:p-5 md:p-6 transition-all duration-500 cursor-pointer shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 overflow-hidden w-full"
                                :class="selectedId == {{ $s->id }} ? 'ring-2 ring-emerald-500 border-transparent shadow-emerald-100' : ''">

                                <div class="flex flex-col lg:flex-row lg:items-center gap-4 lg:gap-6">

                                    <div class="flex items-center gap-3 lg:gap-4 lg:w-[35%] xl:w-1/3 min-w-0">
                                        <div class="relative shrink-0">
                                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl flex items-center justify-center transition-all duration-500 
                                @if($isFullyCompleted) bg-emerald-500 text-white shadow-lg shadow-emerald-200 @else bg-slate-100 text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-500 @endif">
                                                <i class="fa-solid @if($isFullyCompleted) fa-check-double @else fa-file-lines @endif text-xl"></i>
                                            </div>
                                            @if($isFullyCompleted)
                                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow-sm">
                                                <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-[9px] font-black uppercase tracking-[0.2em] mb-0.5 italic text-slate-400">ID Registrasi</p>
                                            <h4 class="text-slate-800 font-bold text-sm sm:text-base md:text-lg truncate block w-full" title="{{ $s->no_surat }}">{{ $s->no_surat }}</h4>
                                        </div>
                                    </div>

                                    <div class="flex-1 lg:border-l lg:border-slate-100 lg:pl-6 min-w-0 w-full pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-50">
                                        <div class="flex items-center justify-between mb-2 gap-2 flex-wrap sm:flex-nowrap">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic truncate w-full sm:w-auto">
                                                {{ $hasDisposisi ? 'Progres Divisi' : 'Status Verifikasi' }}
                                            </p>
                                            <div class="flex flex-wrap gap-1.5 shrink-0">
                                                @if($hasDisposisi)
                                                @if($totalSelesai > 0)
                                                <span class="text-[10px] font-bold text-emerald-600 whitespace-nowrap">{{ $totalSelesai }} Selesai</span>
                                                @endif
                                                @if($totalDibaca > 0)
                                                <span class="text-[10px] font-bold text-amber-600 whitespace-nowrap">{{ $totalDibaca }} Dibaca</span>
                                                @endif
                                                @else
                                                <span class="text-[10px] font-bold whitespace-nowrap {{ $isFullyCompleted ? 'text-emerald-600' : 'text-blue-600' }}">
                                                    {{ $isFullyCompleted ? 'Disetujui & Diarsipkan' : 'Dalam Antrean Review' }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden flex">
                                            <div class="h-full bg-emerald-500 transition-all duration-1000 shadow-[0_0_10px_#10b981]" @style(["width: {$cssWidthSelesai}"])></div>
                                            <div class="h-full bg-amber-500 transition-all duration-1000 shadow-[0_0_10px_#f59e0b]" @style(["width: {$cssWidthDibaca}"])></div>
                                        </div>

                                        <div class="mt-3 flex flex-wrap gap-2 w-full">
                                            @if($hasDisposisi)
                                            @foreach($group as $disp)
                                            @php
                                            $peranClean = strtolower($disp->peran ?? '');
                                            $statusClean = strtolower($disp->status ?? '');
                                            $badgeStyle = 'bg-slate-50 border-slate-200 text-slate-500';

                                            if ($statusClean === 'selesai dilaksanakan') {
                                            $badgeStyle = 'bg-emerald-50 border-emerald-200 text-emerald-600';
                                            } elseif ($statusClean === 'sudah dibaca') {
                                            $badgeStyle = 'bg-amber-50 border-amber-200 text-amber-600';
                                            }

                                            if ($peranClean === 'pelaksana') {
                                            $peranText = !empty($disp->ketua_tim) ? "Pelaksana ({$disp->ketua_tim})" : 'Pelaksana Langsung';
                                            } elseif ($peranClean === 'pemantau') {
                                            $peranText = !empty($disp->ketua_tim) ? "Pemantau ({$disp->ketua_tim})" : 'Pemantau Langsung';
                                            } else {
                                            $peranText = $disp->peran ?? 'Unit Kerja';
                                            }
                                            @endphp

                                            <div class="text-[9px] px-2 py-1 rounded-md border font-bold uppercase flex items-center gap-1.5 max-w-full overflow-hidden {{ $badgeStyle }}">
                                                <span class="truncate max-w-[100px] sm:max-w-[150px] inline-block">{{ $disp->penerima->nama ?? 'Unit Kerja' }}</span>
                                                <span class="opacity-40 shrink-0">|</span>
                                                <span class="truncate inline-block">{{ $peranText }}</span>

                                                @if($statusClean === 'selesai dilaksanakan')
                                                <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                                @elseif($statusClean === 'sudah dibaca')
                                                <i class="fa-solid fa-book-open text-amber-500 shrink-0"></i>
                                                @endif
                                            </div>
                                            @endforeach
                                            @else
                                            <div class="text-[9px] px-2 py-1 rounded-md border font-bold uppercase flex items-center gap-1 max-w-full truncate {{ $isFullyCompleted ? 'bg-emerald-50 border-emerald-200 text-emerald-600' : 'bg-blue-50 border-blue-200 text-blue-600' }}">
                                                @if($isFullyCompleted)
                                                <i class="fa-solid fa-shield-check shrink-0"></i> <span class="truncate">Terverifikasi Tanpa Disposisi</span>
                                                @else
                                                <i class="fa-solid fa-clock shrink-0"></i> <span class="truncate">Menunggu Sekretariat</span>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between lg:justify-end gap-3 lg:border-l lg:border-slate-100 lg:pl-4 mt-3 lg:mt-0 pt-3 lg:pt-0 border-t lg:border-transparent w-full lg:w-auto shrink-0">
                                        <div class="text-left lg:text-right flex-1 lg:flex-none">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Status Sistem</p>
                                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter shadow-sm inline-flex items-center gap-1.5
                                @if($isFullyCompleted) bg-emerald-500 text-white
                                @elseif($totalDibaca > 0 || $totalSelesai > 0) bg-amber-100 text-amber-600
                                @else bg-blue-100 text-blue-600 @endif">

                                                @if($isFullyCompleted)
                                                <i class="fa-solid fa-check-double shrink-0"></i> <span>Selesai</span>
                                                @elseif($totalDibaca > 0 || $totalSelesai > 0)
                                                <i class="fa-solid fa-spinner animate-spin-slow shrink-0"></i> <span>Proses</span>
                                                @else
                                                <i class="fa-solid fa-clock shrink-0"></i> <span>Antre</span>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center group-hover:translate-x-1 transition-transform cursor-pointer shadow-md shrink-0">
                                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @empty
                            <div class="w-full flex flex-col items-center justify-center text-center py-16 md:py-20 px-4 bg-white border border-slate-200 rounded-3xl">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100 shadow-inner">
                                    <i class="fa-solid fa-folder-open text-2xl text-slate-200"></i>
                                </div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-relaxed">Belum ada data surat masuk</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="lg:col-span-5 xl:col-span-4 w-full">
                        <div id="detailSection" class="bg-white/90 backdrop-blur-md rounded-[2.5rem] p-5 sm:p-6 md:p-8 lg:sticky lg:top-28 shadow-2xl shadow-slate-200/40 border border-slate-100 min-h-[550px] flex flex-col transition-all duration-300 w-full overflow-hidden">

                            <div class="flex items-center justify-between mb-6 border-b border-slate-100/80 pb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-sm shadow-emerald-400"></div>
                                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em]">Jejak Digital</h3>
                                </div>
                                <div x-show="selectedId && !isLoading" class="flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-2 py-1 rounded-full border border-emerald-100 text-[8px] sm:text-[9px] font-bold tracking-wider uppercase animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Live Audit
                                </div>
                            </div>

                            <div x-show="isLoading"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="flex-1 flex flex-col items-center justify-center space-y-4 my-10">
                                <div class="relative w-12 h-12">
                                    <div class="absolute inset-0 border-4 border-slate-100 rounded-full"></div>
                                    <div class="absolute inset-0 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                                </div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] animate-pulse">Menarik Data Log...</p>
                            </div>

                            <div x-show="!selectedId && !isLoading"
                                x-transition:enter="transition ease-out duration-300"
                                class="flex-1 flex flex-col items-center justify-center text-center my-10 px-4">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-b from-slate-50 to-slate-100/50 rounded-3xl flex items-center justify-center mb-4 border border-slate-100 shadow-sm relative group">
                                    <div class="absolute inset-0 bg-emerald-500/5 rounded-3xl scale-75 opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500"></div>
                                    <i class="fa-solid fa-fingerprint text-2xl sm:text-3xl text-slate-300 transition-colors duration-300 group-hover:text-emerald-500"></i>
                                </div>
                                <h4 class="text-xs font-bold text-slate-700 mb-1">Log Tidak Aktif</h4>
                                <p class="text-[10px] sm:text-[11px] text-slate-400 font-medium max-w-[220px] leading-relaxed">Pilih salah satu surat untuk melihat riwayat audit secara real-time.</p>
                            </div>

                            <div x-show="selectedId && !isLoading"
                                x-transition:enter="transition ease-out duration-500 delay-100"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="space-y-6 flex-1 flex flex-col overflow-y-auto pr-1 sm:pr-2 custom-scrollbar">

                                <div class="p-4 sm:p-5 rounded-[1.5rem] bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 text-white relative overflow-hidden shadow-lg border border-slate-800 shrink-0">
                                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

                                    <div class="flex justify-between items-start mb-3 relative z-10 gap-2">
                                        <div class="min-w-0">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status Dokumen</p>
                                            <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider px-2 sm:px-3 py-1 rounded-xl shadow-inner border border-white/10 inline-block truncate max-w-full"
                                                :class="{
                                  'bg-emerald-500/20 text-emerald-400 border-emerald-500/30': ['selesai', 'diarsip', 'disetujui', 'sudah ttd'].includes(selectedSurat.status?.toLowerCase()),
                                  'bg-rose-500/20 text-rose-400 border-rose-500/30': selectedSurat.status?.toLowerCase() === 'ditolak',
                                  'bg-amber-500/20 text-amber-400 border-amber-500/30': !['selesai', 'diarsip', 'disetujui', 'sudah ttd', 'ditolak'].includes(selectedSurat.status?.toLowerCase())
                              }"
                                                x-text="selectedSurat.status || 'PROSES'">
                                            </span>
                                        </div>
                                        <div class="p-2 bg-white/5 rounded-xl border border-white/10 shrink-0">
                                            <i class="fa-solid fa-shield-halved text-slate-400 text-xs sm:text-sm"></i>
                                        </div>
                                    </div>

                                    <div class="relative z-10 w-full">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Perihal / Subjek</p>
                                        <p class="text-[11px] sm:text-xs font-semibold text-slate-100 leading-relaxed line-clamp-2 w-full break-words" x-text="selectedSurat.perihal"></p>
                                    </div>
                                </div>

                                <div class="relative ml-2 sm:ml-3 flex-1 border-l-2 border-slate-100 pl-4 sm:pl-5 space-y-5 my-2">
                                    <template x-for="(step, index) in timeline" :key="index">
                                        <div class="relative group w-full">

                                            <div class="absolute -left-[23px] sm:-left-[27px] top-1 w-3 h-3 sm:w-3.5 sm:h-3.5 rounded-full border-2 border-white shadow-sm transition-all duration-300 z-10 group-hover:scale-125"
                                                :class="{
                                 'bg-emerald-500 ring-4 ring-emerald-100': ['DISETUJUI', 'COMPLETED', 'SELESAI', 'DIARSIP'].includes(step.status),
                                 'bg-blue-500 ring-4 ring-blue-100': ['REGISTERED', 'FORWARDED', 'SUBMITTED'].includes(step.status),
                                 'bg-rose-500 ring-4 ring-rose-100': step.status === 'DITOLAK',
                                 'bg-amber-500 ring-4 ring-amber-100': step.status === 'REPORTED' || step.status === 'PENDING'
                             }">
                                            </div>

                                            <div class="bg-slate-50/50 group-hover:bg-white border border-slate-100 group-hover:border-slate-200 p-3 sm:p-4 rounded-2xl transition-all duration-300 shadow-none group-hover:shadow-md overflow-hidden">
                                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-2">
                                                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 w-full truncate"
                                                        :class="{
                                          'text-emerald-600': ['DISETUJUI', 'COMPLETED', 'SELESAI', 'DIARSIP'].includes(step.status?.toUpperCase()),
                                          'text-blue-600': ['REGISTERED', 'FORWARDED', 'SUBMITTED', 'DISPOSISI', 'PROSES'].includes(step.status?.toUpperCase()),
                                          'text-rose-600': ['DITOLAK', 'REJECTED'].includes(step.status?.toUpperCase()),
                                          'text-amber-600': ['REPORTED', 'PENDING', 'REVIEW'].includes(step.status?.toUpperCase())
                                          }">
                                                        <i class="fa-solid text-[8px]" :class="step.icon || 'fa-circle-dot'"></i>
                                                        <span class="truncate" x-text="step.title"></span>
                                                    </span>
                                                    <span class="text-[8px] sm:text-[9px] font-mono text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded shrink-0 self-start" x-text="formatDate(step.date)"></span>
                                                </div>

                                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed mb-2 font-medium break-words w-full" x-text="step.desc"></p>

                                                <template x-if="step.peran">
                                                    <div class="mb-2">
                                                        <span class="text-[8px] sm:text-[9px] inline-flex items-center gap-1 px-1.5 sm:px-2 py-0.5 rounded-md font-bold uppercase tracking-wide border max-w-full truncate"
                                                            :class="{
                                              'bg-rose-50 border-rose-100 text-rose-600': step.peran.toLowerCase() === 'pelaksana',
                                              'bg-blue-50 border-blue-100 text-blue-600': step.peran.toLowerCase() === 'pemantau',
                                              'bg-slate-50 border-slate-100 text-slate-500': !['pelaksana', 'pemantau'].includes(step.peran.toLowerCase())
                                          }">
                                                            <i class="fa-solid text-[7px]" :class="step.peran.toLowerCase() === 'pelaksana' ? 'fa-fire-pulse' : 'fa-eye'"></i>
                                                            <span class="truncate" x-text="step.peran.toLowerCase() === 'pelaksana' 
                                                ? (step.ketua_tim ? 'Pelaksana (' + step.ketua_tim + ')' : 'Pelaksana')
                                                : (step.peran.toLowerCase() === 'pemantau'
                                                    ? (step.ketua_tim ? 'Pemantau (' + step.ketua_tim + ')' : 'Pemantau')
                                                    : step.peran)">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </template>

                                                <div class="flex items-center gap-2 pt-2 mt-2 border-t border-slate-100 w-full">
                                                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-md bg-slate-100 flex items-center justify-center border border-slate-200/50 shrink-0">
                                                        <i class="fa-solid fa-user-shield text-[7px] sm:text-[8px]"
                                                            :class="step.actor_role === 'admin' ? 'text-emerald-500' : 'text-slate-400'"></i>
                                                    </div>
                                                    <div class="flex flex-col min-w-0 flex-1">
                                                        <p class="text-[8px] sm:text-[9px] font-bold text-slate-700 leading-tight truncate w-full" x-text="step.actor"></p>
                                                        <p class="text-[7px] text-slate-400 font-medium uppercase tracking-wider truncate" x-text="step.actor_role === 'admin' ? 'Sekretariat' : 'Divisi / Unit'"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-auto pt-4 border-t border-slate-100 shrink-0 pb-1">
                                    <button @click="closeDetail()"
                                        class="w-full py-2.5 sm:py-3 bg-slate-50 hover:bg-slate-100 active:scale-[0.98] border border-slate-200 hover:border-slate-300 text-slate-600 hover:text-slate-800 text-[9px] sm:text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-circle-xmark text-slate-400"></i> Tutup Detail Log
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <style>
                /* Optional: Untuk memastikan scrollbar di dalam timeline tetap ramping dan tidak merusak layout */
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
        </main>


        <style>
            /* Smooth transition for glassmorphism */
            .glass-card {
                background: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }

            /* Perbaikan Syntax Error pada Keyframes */
            @keyframes status-ping {
                0% {
                    transform: scale(1);
                    opacity: 1;
                }

                100% {
                    transform: scale(2.5);
                    opacity: 0;
                }
            }

            .animate-status-ping {
                animation: status-ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
            }

            /* Scrollbar Styling */
            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #020617;
            }

            ::-webkit-scrollbar-thumb {
                background: #1e293b;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #10b981;
            }
        </style>


        <style>
            /* Agar scrollbar terlihat rapi dan tipis */
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

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #cbd5e1;
            }
        </style>

        <script>
            function trackingSystem() {
                return {
                    selectedId: null,
                    isLoading: false,
                    mobileSidebar: false,
                    selectedSurat: {},
                    timeline: [],

                    async fetchDetail(id) {
                        this.selectedId = id;
                        this.isLoading = true;
                        this.timeline = [];


                        try {
                            const response = await fetch(`/divisi/tracking/${id}`);
                            if (!response.ok) throw new Error('Network response was not ok');

                            const data = await response.json();

                            // DATA MAPPING
                            this.selectedSurat = data.surat;
                            this.timeline = data.timeline; // <--- Inilah yang merender x-for di atas

                        } catch (error) {
                            console.error("Fetch error:", error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal mengambil detail tracking.'
                            });
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // --- FUNGSI TUTUP/CLOSE ---
                    closeDetail() {
                        this.selectedId = null;
                        this.selectedSurat = {};
                        this.timeline = [];
                        // Opsional: Jika Anda ingin scroll kembali ke atas daftar surat
                        // window.scrollTo({ top: 0, behavior: 'smooth' });
                    },

                    formatDate(dateString) {
                        if (!dateString) return '-';
                        const date = new Date(dateString);
                        return date.toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            hour: '2-digit',
                            minute: '2-digit'
                        }).replace('.', ':');
                    }
                }
            }

            // Fungsi Logout (di luar trackingSystem agar bisa dipanggil langsung)
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
