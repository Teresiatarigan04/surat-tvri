<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk | Divisi Panel TVRI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,400;0,600;0,800;1,800&display=swap" rel="stylesheet">
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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar-item-active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid #10b981;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0) 100%);
            border-left: 4px solid #10b981;
            color: #10b981;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
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

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="text-slate-600 antialiased overflow-x-hidden" x-data="{ mobileSidebar: false }">

    <!-- OVERLAY MOBILE -->
    <div x-show="mobileSidebar"
        x-transition.opacity
        class="fixed inset-0 bg-black/80 z-40 lg:hidden"
        @click="mobileSidebar = false" x-cloak></div>

    <!-- ASIDE / SIDEBAR -->
    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

        <div class="p-6 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-layer-group text-white text-xs"></i>
                </div>
                <span class="text-sm font-black tracking-tighter text-white uppercase italic">Divisi Panel</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto scrollbar-hide pb-4">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2 mt-2">Workspace</p>

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
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admindivisi.disposisi.*') ? 'sidebar-item-active' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-file-import text-sm"></i>
                <span class="text-sm font-semibold">Disposisi Masuk</span>
            </a>

            <!-- MENU AKTIF: SURAT MASUK -->
            <a href="{{ route('divisi.surat-masuk') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group sidebar-item-active">
                <i class="fa-solid fa-inbox text-sm"></i>
                <span class="text-sm font-semibold">Surat Masuk</span>
            </a>

            <a href="{{ route('admindivisi.surat_keluar.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admindivisi.surat_keluar.*') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-paper-plane text-sm"></i>
                <span class="text-sm font-semibold">Surat Keluar</span>
            </a>

            <a href="{{ route('divisi.tracking.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group hover:bg-white/5 text-slate-400 hover:text-white">
                <i class="fa-solid fa-route text-sm"></i>
                <span class="text-sm font-semibold">Tracking Surat</span>
            </a>

            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-6 mb-2">Archive</p>

            <a href="{{ route('ajukan.riwayat') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group hover:bg-white/5 text-slate-400 hover:text-white">
                <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                <span class="text-sm font-semibold">Riwayat Pengajuan</span>
            </a>

        </nav>

        <div class="p-4 border-t border-white/5 bg-slate-900/40 shrink-0">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-500/10">
                    <i class="fa-solid fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <!-- MAIN CONTENT -->
    <main class="lg:ml-72 min-h-screen pb-12">

        <!-- HEADER -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between animate__animated animate__fadeInDown transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight italic">Surat Masuk</h1>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest italic flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-ping"></span>
                        Unit: {{ Auth::user()->divisi_name ?? 'TVRI SUMUT' }}
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

        <div x-data="{ 
    detailModal: false, 
    selectedSurat: {},
    openDetail(surat) {
        this.selectedSurat = surat;
        this.detailModal = true;
    }
}" class="p-4 lg:p-10 space-y-10 animate__animated animate__fadeIn">

            <!-- STATS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-envelope-open-text text-2xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Live Update</span>
                    </div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Surat Masuk</p>
                    <p class="text-4xl font-black text-slate-900 italic mt-1">{{ $suratMasuk->count() }} <span class="text-sm font-normal text-slate-400 uppercase tracking-normal font-sans">Dokumen</span></p>
                </div>

                <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all group border-b-4 border-b-emerald-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-calendar-day text-2xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-emerald-300 uppercase tracking-widest">Status</span>
                    </div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Diterima Hari Ini</p>
                    <p class="text-4xl font-black text-emerald-600 italic mt-1">{{ $stats['hari_ini'] ?? 0 }} <span class="text-sm font-normal text-slate-400 uppercase tracking-normal font-sans">Surat Baru</span></p>
                </div>
            </div>

            <!-- TABLE SECTION -->
            <<!-- WRAPPER UTAMA DENGAN INISIALISASI STATE ALPINE.JS -->
                <div x-data="{ 
    detailModal: false, 
    selectedSurat: {},
    openDetail(surat) {
        this.selectedSurat = surat;
        this.detailModal = true;
    }
}" class="space-y-6">

                    <!-- ARSIP DIGITAL HEADER -->
                    <div class="flex items-center gap-3 px-2">
                        <div class="h-8 w-1.5 bg-slate-900 rounded-full"></div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-[0.3em] italic">Arsip Digital Surat Masuk</h3>
                    </div>

                    <!-- TABEL UTAMA -->
                    <div class="bg-white rounded-[45px] border border-slate-200/60 shadow-2xl overflow-hidden shadow-slate-200/50 transition-all">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[1000px]">
                                <thead>
                                    <tr class="bg-slate-900 text-[10px] font-black text-white uppercase tracking-[0.2em]">
                                        <th class="py-8 px-10">Judul Surat & Identitas</th>
                                        <th class="py-8 px-10 text-center">Asal Pengirim</th>
                                        <th class="py-8 px-10 text-center">Aksi Manajemen</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($suratMasuk as $index => $surat)
                                    @php
                                    // Cek status baca user saat load halaman pertama kali
                                    $isRead = $surat->pembaca->contains(Auth::id());
                                    @endphp
                                    <tr @style([ "animation-delay: " . (0.1 * ($index + 1)) . "s" ])
                                        class="hover:bg-slate-50/80 transition-all group animate__animated animate__fadeInUp">

                                        <!-- IDENTITAS SURAT -->
                                        <td class="p-10">
                                            <div class="flex flex-col gap-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="px-4 py-1.5 bg-slate-100 text-slate-900 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200">
                                                        {{ $surat->no_surat }}
                                                    </span>

                                                    <!-- BADGE NOTIFIKASI DENGAN ID UNIK -->
                                                    @if(!$isRead)
                                                    <span id="badge-unread-{{ $surat->id }}" class="px-2 py-0.5 bg-rose-500 text-white text-[9px] font-black rounded uppercase tracking-wider animate-pulse">
                                                        Belum Dibaca
                                                    </span>
                                                    @endif

                                                    <span class="text-[10px] text-emerald-500 font-black uppercase italic">
                                                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> {{ $surat->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                <p class="text-lg font-black text-slate-800 uppercase leading-tight group-hover:text-emerald-600 transition-colors">{{ $surat->perihal }}</p>
                                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest italic">Registrasi: {{ $surat->created_at->format('d F Y') }}</p>
                                            </div>
                                        </td>

                                        <!-- ASAL PENGIRIM -->
                                        <td class="p-10 text-center">
                                            <div class="inline-flex flex-col items-center gap-3 p-4 bg-slate-50 rounded-[30px] border border-slate-100 group-hover:bg-white group-hover:shadow-lg transition-all">
                                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-colors">
                                                    <i class="fa-solid fa-building-circle-check"></i>
                                                </div>
                                                <span class="text-[10px] font-black text-slate-900 uppercase tracking-tighter">{{ $surat->asal_surat ?? 'Sekretariat' }}</span>
                                            </div>
                                        </td>

                                        <!-- ACTION BUTTONS -->
                                        <td class="p-10">
                                            <div class="flex items-center justify-center gap-3">
                                                <!-- Kirim element ($el) ke function agar target data Alpine bisa terbaca -->
                                                <button @click="clickDetailSurat({{ json_encode($surat) }}, $el)"
                                                    class="w-12 h-12 flex items-center justify-center bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                @if($surat->file_surat)
                                                <a href="{{ asset('uploads/surat_sekret/' . $surat->file_surat) }}"
                                                    download
                                                    class="flex items-center gap-2 px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-600 transition-all hover:scale-105 shadow-lg shadow-emerald-200">
                                                    <i class="fa-solid fa-download"></i> Unduh
                                                </a>
                                                @else
                                                <span class="text-[10px] font-bold text-slate-300 uppercase italic">No File</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="p-10 text-center text-slate-400 font-bold uppercase italic text-sm">Belum ada data surat masuk.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- MODAL DETAIL (FIXED) -->
                    <template x-teleport="body">
                        <!-- Container Utama Modal (Fixed menutupi seluruh layar) -->
                        <div x-show="detailModal"
                            class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6 overflow-x-hidden overflow-y-auto"
                            x-cloak>

                            <!-- Backdrop background (Blur dan Transparan) -->
                            <div x-show="detailModal"
                                x-transition.opacity.duration.300ms
                                class="fixed inset-0 bg-slate-950/70 backdrop-blur-md cursor-pointer"
                                @click="detailModal = false"></div>

                            <!-- Konten Modal (Card Putih) -->
                            <div x-show="detailModal"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                @click.stop
                                class="relative w-full max-w-2xl bg-white rounded-[32px] md:rounded-[48px] shadow-[0_25px_70px_-15px_rgba(0,0,0,0.5)] border border-slate-100 flex flex-col my-auto max-h-[calc(100vh-2rem)] sm:max-h-[calc(100vh-3rem)] overflow-hidden z-10">

                                <!-- Header Modal (Tetap di atas, tidak ikut ter-scroll) -->
                                <div class="p-6 md:p-10 bg-slate-900 text-white relative overflow-hidden shrink-0">
                                    <!-- Tombol Close -->
                                    <button @click="detailModal = false"
                                        type="button"
                                        class="absolute top-4 right-4 md:top-6 md:right-6 w-10 h-10 bg-white/10 hover:bg-rose-500 text-white rounded-xl flex items-center justify-center transition-all duration-300 group z-50">
                                        <i class="fa-solid fa-xmark text-lg group-hover:rotate-90 transition-transform duration-300"></i>
                                    </button>

                                    <!-- Informasi Header -->
                                    <div class="relative z-10 pr-10">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="px-3 py-1 bg-emerald-500 text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-emerald-500/20">Surat Detail</span>
                                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest" x-text="selectedSurat.no_surat"></span>
                                        </div>
                                        <h2 class="text-xl md:text-2xl font-black uppercase italic leading-tight tracking-tighter line-clamp-2" x-text="selectedSurat.perihal"></h2>
                                    </div>

                                    <!-- Watermark Icon Background -->
                                    <i class="fa-solid fa-envelope-open opacity-10 text-8xl absolute -bottom-8 -right-8 rotate-12 pointer-events-none"></i>
                                </div>

                                <!-- Body Modal (Bisa di-scroll ke bawah secara internal jika kontennya panjang) -->
                                <div class="p-6 md:p-10 space-y-6 md:space-y-8 overflow-y-auto custom-scrollbar">

                                    <!-- Info Grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                                <i class="fa-solid fa-hashtag text-emerald-500"></i> Nomor Registrasi
                                            </p>
                                            <p class="font-black text-slate-900 text-base md:text-lg tracking-tight break-all" x-text="selectedSurat.no_surat"></p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                                <i class="fa-solid fa-calendar-check text-emerald-500"></i> Tanggal Masuk
                                            </p>
                                            <p class="font-black text-slate-900 text-base md:text-lg tracking-tight"
                                                x-text="selectedSurat.created_at ? new Date(selectedSurat.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}) : '-'">
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Info Pengirim & Perihal -->
                                    <div class="space-y-4">
                                        <!-- Card Pengirim -->
                                        <div class="p-4 md:p-6 bg-slate-50 rounded-[24px] border border-slate-100 flex items-center gap-4 md:gap-6">
                                            <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-900 text-lg md:text-xl shrink-0">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Nama Pengirim</p>
                                                <p class="font-black text-slate-900 text-base md:text-lg uppercase tracking-tighter truncate"
                                                    x-text="selectedSurat.pengirim ? selectedSurat.pengirim.username : (selectedSurat.asal_surat ?? 'Tidak Diketahui')"></p>
                                            </div>
                                        </div>

                                        <!-- Card Perihal -->
                                        <div class="p-4 md:p-6 bg-slate-50 rounded-[24px] border border-slate-100 flex items-center gap-4 md:gap-6">
                                            <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-900 text-lg md:text-xl shrink-0">
                                                <i class="fa-solid fa-building"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Perihal Utama</p>
                                                <p class="font-black text-slate-900 text-base md:text-lg uppercase tracking-tighter break-words" x-text="selectedSurat.perihal"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Action (Tombol Preview Dokumen di dalam body bawah) -->
                                    <div class="pt-2">
                                        <template x-if="selectedSurat.file_surat">
                                            <div class="flex flex-col sm:flex-row gap-4">
                                                <a :href="'/uploads/surat_sekret/' + selectedSurat.file_surat"
                                                    target="_blank"
                                                    class="flex-1 py-4 md:py-5 bg-slate-900 text-white rounded-[20px] font-black uppercase text-[11px] tracking-[0.2em] hover:bg-slate-800 active:scale-[0.98] transition-all shadow-xl flex items-center justify-center gap-3">
                                                    <i class="fa-solid fa-up-right-from-square text-emerald-400"></i> Preview Dokumen
                                                </a>
                                            </div>
                                        </template>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </template>
                </div>

    </main>
    @if(session('success'))
    <div id="swal-success" data-message="{{ session('success') }}"></div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function clickDetailSurat(suratObj, element) {
            // Dapatkan instance data Alpine terdekat dari elemen tombol yang diklik
            const alpineData = Alpine.$data(element);

            // Kirim status baca ke backend Laravel Controller
            fetch(`/surat-masuk-divisi/${suratObj.id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Hapus badge merah "Belum Dibaca" secara real-time dari baris tabel jika ada
                    const unreadBadge = document.getElementById(`badge-unread-${suratObj.id}`);
                    if (unreadBadge) {
                        unreadBadge.remove();
                    }

                    // Panggil fungsi Alpine untuk mengikat objek surat dan memunculkan modal
                    if (alpineData && typeof alpineData.openDetail === "function") {
                        alpineData.openDetail(suratObj);
                    }
                })
                .catch(err => {
                    console.error("Gagal memperbarui status baca:", err);
                    // Fallback: Jika koneksi bermasalah, modal detail tetap dipaksa terbuka demi UX pengguna
                    if (alpineData && typeof alpineData.openDetail === "function") {
                        alpineData.openDetail(suratObj);
                    }
                });
        }
    </script>

    <script>
        const successElement = document.getElementById('swal-success');

        if (successElement) {
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: successElement.dataset.message,
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                    popup: 'rounded-[35px]'
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