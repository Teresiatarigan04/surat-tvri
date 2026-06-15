<!DOCTYPE html>
<html lang="id" x-data="{ mobileSidebar: false, detailModal: false, selectedSurat: {} }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan | TVRI Sumut</title>

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
            height: 5px;
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

    <div x-show="mobileSidebar" x-cloak class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900/50 backdrop-blur-2xl border-r border-white/5 flex flex-col">
        <div class="p-6 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-layer-group text-white text-xs"></i>
                </div>
                <span class="text-sm font-black tracking-tighter text-white uppercase">Divisi Panel</span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1 overflow-y-auto pb-4">
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
            <a href="{{ route('ajukan.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('ajukan.riwayat') ? 'sidebar-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition-all group">
                <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                <span class="text-sm font-semibold">Riwayat Pengajuan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 bg-slate-900/40 backdrop-blur-md">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl transition-all font-bold text-xs uppercase tracking-widest border border-red-500/5">
                <i class="fa-solid fa-power-off"></i> Logout
            </button>
        </div>
    </aside>

    <main class="lg:ml-72 min-h-screen bg-white">
        <!-- Header: Putih Bersih dengan Shadow Halus -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-600 p-2">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight italic uppercase">Riwayat Surat</h1>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest italic flex items-center gap-2">
                        <span class="w-1 h-1 bg-emerald-600 rounded-full animate-ping"></span>Daftar Pengajuan Anda
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

        <div class="p-4 lg:p-10 max-w-7xl mx-auto animate__animated animate__fadeInUp">
            @if($surats->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-[32px] border border-slate-100 shadow-xl shadow-slate-100/50">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-emerald-500/5 blur-3xl rounded-full"></div>
                    <i class="fa-solid fa-folder-open text-8xl text-slate-100 relative"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest mb-2">Belum Ada Riwayat</h3>
                <p class="text-slate-400 text-sm max-w-xs text-center mb-8">Anda belum pernah melakukan pengajuan surat.</p>
                <a href="{{ route('ajukan.index') }}" class="px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 hover:bg-emerald-600">
                    Mulai Ajukan Sekarang
                </a>
            </div>
            @else
            <!-- Container Luar: Putih Bersih dengan Border & Shadow agar terlihat "Outer" nya -->
            <div class="bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-2xl shadow-slate-200/60">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[950px] lg:min-w-full">
                        <thead>
                            <!-- Header Tabel: Warna Emerald Gelap (Sangat Kontras) -->
                            <tr class="bg-slate-900">
                                <th class="px-6 py-5 text-[10px] font-black text-emerald-400 uppercase tracking-widest border-b border-white/5">Info Surat</th>
                                <th class="px-6 py-5 text-[10px] font-black text-emerald-400 uppercase tracking-widest leading-relaxed border-b border-white/5">Perihal / Pengirim</th>
                                <th class="px-6 py-5 text-[10px] font-black text-emerald-400 uppercase tracking-widest text-center border-b border-white/5">Status Progres</th>
                                <th class="px-6 py-5 text-[10px] font-black text-emerald-400 uppercase tracking-widest text-right border-b border-white/5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($surats as $surat)
                            @php
                            $statusVal = strtolower($surat->status ?? 'pending');
                            $statusCfg = match($statusVal) {
                            'disetujui' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'dot' => 'bg-emerald-500', 'label' => 'DISETUJUI'],
                            'diproses' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-100', 'dot' => 'bg-blue-500', 'label' => 'DIPROSES'],
                            'ditolak' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-100', 'dot' => 'bg-red-500', 'label' => 'DITOLAK'],
                            default => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'dot' => 'bg-amber-500', 'label' => 'PENDING'],
                            };
                            $filePath = asset('uploads/surat_masuk/' . $surat->file_surat);
                            $detailData = json_encode([
                            'no' => $surat->no_surat,
                            'tgl' => \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'),
                            'perihal' => $surat->perihal,
                            'tujuan' => $surat->pengirim,
                            'status' => $statusCfg['label'],
                            'ket' => $surat->keterangan ?? 'Tidak ada catatan tambahan.',
                            ]);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:border-emerald-500 group-hover:text-emerald-600 transition-all shadow-sm">
                                            <i class="fa-solid fa-file-contract text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-[11px] font-black text-slate-900 uppercase tracking-tighter">{{ $surat->no_surat }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">
                                                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="max-w-xs">
                                        <div class="text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-emerald-600 transition-colors uppercase tracking-tight">{{ $surat->perihal }}</div>
                                        <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-2 italic">
                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span> Pengirim: {{ $surat->pengirim }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-xl border {{ $statusCfg['border'] }} {{ $statusCfg['bg'] }} {{ $statusCfg['text'] }} shadow-sm">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $statusCfg['dot'] }} opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $statusCfg['dot'] }}"></span>
                                        </span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">{{ $statusCfg['label'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click='selectedSurat = {!! $detailData !!}; detailModal = true'
                                            class="h-10 px-4 rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition-all flex items-center gap-2 text-[10px] font-black uppercase tracking-widest shadow-md shadow-emerald-500/20">
                                            <i class="fa-solid fa-circle-info"></i> DETAIL
                                        </button>

                                        @php
                                        $safeFilePath = asset('uploads/surat_masuk/' . rawurlencode($surat->file_surat));
                                        @endphp

                                        <button onclick="previewFile('{{ $safeFilePath }}')"
                                            class="h-10 px-4 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2 text-[10px] font-black uppercase tracking-widest">
                                            <i class="fa-solid fa-eye text-emerald-500"></i> LIHAT
                                        </button>

                                        <a href="{{ $safeFilePath }}" download
                                            class="h-10 w-10 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-slate-400 hover:text-emerald-600 flex items-center justify-center transition-all shadow-sm">
                                            <i class="fa-solid fa-download text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <footer class="py-10 text-center">
                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.5em]">© 2026 TVRI Sumatera Utara • Divisi Panel System</p>
            </footer>
        </div>
    </main>

    <!-- Modal Detail: Background Backdrop Lebih Terang -->
    <div x-show="detailModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md" x-cloak>

        <!-- Card Modal: Putih Bersih -->
        <div @click.away="detailModal = false"
            x-show="detailModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-8"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="w-full max-w-lg bg-white rounded-[32px] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-slate-100">

            <!-- Header Modal -->
            <div class="relative p-8 bg-emerald-50/50 border-b border-slate-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Informasi Detail</p>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter" x-text="selectedSurat.no"></h2>
                    </div>
                    <button @click="detailModal = false" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:border-rose-200 transition-all shadow-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Body Modal -->
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Tanggal Pengajuan</label>
                        <p class="text-sm font-bold text-slate-800" x-text="selectedSurat.tgl"></p>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Status Saat Ini</label>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-black text-emerald-600 uppercase tracking-widest" x-text="selectedSurat.status"></span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Perihal Surat</label>
                        <p class="text-sm font-bold text-slate-800 leading-relaxed uppercase" x-text="selectedSurat.perihal"></p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Pengirim</label>
                        <p class="text-sm font-bold text-slate-800 uppercase" x-text="selectedSurat.tujuan"></p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-dashed border-slate-200">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Catatan / Keterangan</label>
                        <p class="text-xs text-slate-500 italic leading-relaxed" x-text="selectedSurat.ket"></p>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="p-6 bg-slate-50 border-t border-slate-100 text-center">
                <button @click="detailModal = false"
                    class="w-full py-4 bg-white border border-slate-200 hover:bg-slate-900 hover:text-white hover:border-slate-900 text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-sm">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>

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

        function previewFile(url) {
            Swal.fire({
                title: '<span style="font-weight:900; color:#fff; font-size:16px;">PREVIEW DOKUMEN</span>',
                html: `<iframe src="${url}" class="w-full h-[70vh] rounded-2xl border-none"></iframe>`,
                width: '90%',
                background: '#0f172a',
                customClass: {
                    popup: 'premium-swal-popup'
                },
                showConfirmButton: false,
                showCloseButton: true
            });
        }
    </script>
</body>

</html>