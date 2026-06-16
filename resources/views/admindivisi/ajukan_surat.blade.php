
<!DOCTYPE html>
<html lang="id" x-data="{ mobileSidebar: false, fileName: '', filePreview: false, sifatSelected: 'penting' }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Surat | TVRI Sumut</title>

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
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0%' stop-color='%230A2A66'/><stop offset='100%' stop-color='%23071C45'/></linearGradient></defs><rect width='100' height='100' rx='18' fill='url(%23g)'/><text x='50' y='64' font-size='36' font-weight='700' text-anchor='middle' fill='white' font-family='Arial, Helvetica, sans-serif'>TVRI</text></svg>">

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

        /* INPUT STYLE CONSISTENCY */
        .input-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
        }

        .input-glass:focus {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
            outline: none;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(100%) sepia(100%) saturate(10000%) hue-rotate(120deg);
            cursor: pointer;
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

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-slate-300 antialiased overflow-x-hidden">

    <div x-show="mobileSidebar" x-cloak x-transition.opacity class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

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

    <main class="lg:ml-72 min-h-screen bg-slate-50 text-slate-600">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 p-2">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight italic uppercase">Ajukan Surat</h1>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest italic flex items-center gap-2">
                        <span class="w-1 h-1 bg-emerald-500 rounded-full animate-ping"></span>Layanan Input Mandiri
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

        <div class="p-4 lg:p-10 flex flex-col items-center"
            x-data="{ sifatSelected: 'penting', fileName: '', filePreview: false }">

            <div class="w-full max-w-4xl animate__animated animate__fadeInUp">

                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-black text-slate-800 tracking-[0.2em] uppercase italic">
                        Form Pengajuan Surat
                    </h2>
                    <div class="h-1 w-20 bg-emerald-500 mx-auto mt-2 rounded-full"></div>
                </div>

                <form action="{{ route('ajukan.store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white rounded-[40px] lg:rounded-[50px] p-6 lg:p-12 space-y-8 shadow-2xl shadow-emerald-900/10 border-2 border-emerald-500/20 relative overflow-hidden">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-emerald-700 uppercase ml-2 tracking-widest">Nomor Surat</label>
                            <input type="text" name="no_surat" required
                                class="w-full px-6 py-4 rounded-2xl bg-white border-2 border-slate-200 text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all shadow-sm"
                                placeholder="001/TVRI/2026">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-emerald-700 uppercase ml-2 tracking-widest">Pengirim</label>
                            <input type="text" value="{{ Auth::user()->name ?? Auth::user()->nama ?? 'N/A' }}" readonly
                                class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-slate-200 text-slate-500 cursor-not-allowed focus:outline-none shadow-sm font-semibold"
                                placeholder="Nama pengirim...">
                            <input type="hidden" name="pengirim" value="{{ Auth::user()->name ?? Auth::user()->nama }}">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-emerald-700 uppercase ml-2 tracking-widest">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" required
                                class="w-full px-6 py-4 rounded-2xl bg-white border-2 border-slate-200 text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-emerald-700 uppercase ml-2 tracking-widest">Sifat Surat</label>
                            <div class="flex gap-2 p-1 bg-slate-100 rounded-2xl border-2 border-slate-200">
                                <template x-for="option in ['penting', 'segera', 'rahasia']">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="sifat" :value="option" x-model="sifatSelected" class="hidden">
                                        <div :class="sifatSelected === option ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-500 hover:text-emerald-600'"
                                            class="text-center py-3 rounded-xl text-[9px] font-black uppercase tracking-tighter transition-all duration-300">
                                            <span x-text="option"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-emerald-700 uppercase ml-2 tracking-widest">Perihal</label>
                        <textarea name="perihal" required
                            class="w-full px-6 py-5 h-32 resize-none rounded-2xl bg-white border-2 border-slate-200 text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all shadow-sm"
                            placeholder="Tulis perihal surat secara detail..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-emerald-700 uppercase ml-2 tracking-widest">Dokumen (PDF / WORD)</label>
                        <div class="relative group h-40">
                            <input type="file" name="file_surat" id="file_surat" required
                                class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer"
                                x-on:change="if(validateFile($event) !== false) { fileName = $event.target.files[0].name; filePreview = true; }">
                            <div class="w-full h-full border-2 border-dashed border-emerald-500/30 rounded-[30px] bg-emerald-50/5 flex flex-col items-center justify-center group-hover:border-emerald-500 group-hover:bg-emerald-50/20 transition-all duration-300">
                                <i class="fa-solid fa-file-lines text-4xl text-emerald-600 mb-3 group-hover:scale-110 transition-transform"></i>
                                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest text-center px-4"
                                    x-text="filePreview ? fileName : 'Klik atau Seret PDF / WORD ke Sini (Max 1MB)'"></p>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.3em] shadow-xl shadow-emerald-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                        Kirim Pengajuan <i class="fa-solid fa-paper-plane"></i>
                    </button>

                    <i class="fa-solid fa-envelope-circle-check absolute -right-8 -bottom-8 text-9xl text-emerald-500/[0.03] -rotate-12 pointer-events-none"></i>
                </form>

                <footer class="py-10 text-center">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.5em]">© 2026 TVRI Sumatera Utara • Divisi Panel System</p>
                </footer>
            </div>
        </div>
    </main>

    <div id="swal-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-validation='@json($errors->all())'>
    </div>

    <script>
        // 1. FUNGSI LOGOUT
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

        // 2. FUNGSI VALIDASI FILE (CLIENT SIDE)
        function validateFile(event) {
            const file = event.target.files[0];
            const allowedExtensions = /(\.pdf|\.doc|\.docx)$/i;
            const maxSize = 1 * 1024 * 1024; // 1MB

            if (!file) return false;

            // Cek Ekstensi
            if (!allowedExtensions.exec(file.name)) {
                showErrorSwal("FORMAT GAGAL", "Hanya file PDF, DOC, atau DOCX yang diperbolehkan.");
                event.target.value = ''; // Reset input
                return false;
            }

            // Cek Ukuran
            if (file.size > maxSize) {
                showErrorSwal("FILE TERLALU BESAR", "Ukuran file maksimal adalah 1MB.");
                event.target.value = ''; // Reset input
                return false;
            }
            return true;
        }

        // 3. FUNGSI REUSABLE ERROR SWAL (PREMIUM WHITE)
        function showErrorSwal(title, message) {
            Swal.fire({
                icon: 'error',
                iconColor: '#ef4444',
                title: `<span style="font-family: sans-serif; font-weight:900; color:#0f172a; font-size:16px; letter-spacing: 0.05em;">${title}</span>`,
                html: `<p style="font-family: sans-serif; font-size:12px; color:#64748b; text-transform:uppercase; font-weight:600; letter-spacing: 0.025em; line-height: 1.5;">${message}</p>`,
                background: '#ffffff',
                showConfirmButton: true,
                confirmButtonColor: '#0f172a',
                confirmButtonText: '<span style="font-size:10px; font-weight:900; letter-spacing:0.1em;">MENGERTI</span>',
                customClass: {
                    popup: 'premium-swal-white',
                    confirmButton: 'premium-swal-confirm-dark'
                },
                didOpen: (toast) => {
                    toast.style.borderRadius = '24px';
                    toast.style.border = '1px solid #f1f5f9';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const swalData = document.getElementById('swal-data');
            if (!swalData) return;

            const pesanSukses = swalData.dataset.success;
            const pesanError = swalData.dataset.error;

            let validationErrors = [];
            try {
                validationErrors = JSON.parse(swalData.dataset.validation || "[]");
            } catch (e) {
                validationErrors = [];
            }

            // Logika Sukses
            if (pesanSukses) {
                Swal.fire({
                    icon: 'success',
                    iconColor: '#10b981',
                    title: '<span style="font-family: sans-serif; font-weight:900; color:#0f172a; font-size:16px; letter-spacing: 0.05em;">BERHASIL</span>',
                    html: `<p style="font-family: sans-serif; font-size:12px; color:#64748b; text-transform:uppercase; font-weight:600; letter-spacing: 0.025em; line-height: 1.5;">${pesanSukses}</p>`,
                    background: '#ffffff',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'premium-swal-white'
                    },
                    didOpen: (toast) => {
                        toast.style.borderRadius = '24px';
                        toast.style.border = '1px solid #f1f5f9';
                        toast.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.1)';
                    }
                });
            }

            // Logika Error
            if (pesanError) {
                showErrorSwal("PENGIRIMAN GAGAL", pesanError);
            } else if (validationErrors.length > 0) {
                showErrorSwal("VALIDASI GAGAL", validationErrors[0]);
            }
        });
    </script>
</body>

</html>
