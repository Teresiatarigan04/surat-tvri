<!DOCTYPE html>
<html lang="id" x-data="{ 
    sidebarOpen: true, 
    mobileSidebar: false, 
    editModal: false,
    addModal: false,
    selectedUser: { id: '', nama: '', username: '', role: '' } 
}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Akun | TVRI Sumut</title>

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

        .premium-swal-success-confirm {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: white !important;
            padding: 12px 30px !important;
            border-radius: 0.75rem !important;
            font-weight: 900 !important;
            font-size: 10px !important;
            letter-spacing: 0.1em !important;
            transition: all 0.3s !important;
        }

        .premium-swal-success-confirm:hover {
            filter: brightness(1.2);
            transform: translateY(-2px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ mobileSidebar: false, isLoaded: false, addModal: false, editModal: false, selectedUser: null }"
    x-init="setTimeout(() => isLoaded = true, 50)"
    class="text-slate-300 antialiased overflow-x-hidden bg-slate-50">

    <!-- OVERLAY: Sekarang sinkron dengan mobileSidebar di body -->
    <div x-show="mobileSidebar"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/80 z-40 lg:hidden" @click="mobileSidebar = false"></div>

    <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 border-r border-white/5 transition-transform duration-300 ease-in-out flex flex-col">

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

                <div x-data="{ open: {{ request()->routeIs('kelola-akun.*') ? 'true' : 'false' }} }">
                    <div x-show="open" x-transition class="ml-9 mt-1 space-y-1">
                        <a href="{{ route('kelola-akun.index') }}"
                            class="flex items-center gap-3 px-4 py-2 text-xs font-medium transition-colors group rounded-lg
                    {{ request()->routeIs('kelola-akun.index') 
                        ? 'text-blue-400 bg-blue-500/5' 
                        : 'text-slate-500 hover:text-blue-400' }}">

                            <i class="fa-solid fa-users-gear text-[10px] 
                        {{ request()->routeIs('kelola-akun.index') ? 'opacity-100' : 'opacity-50 group-hover:opacity-100' }}">
                            </i>

                            <span>Kelola Akun</span>
                        </a>

                        <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-medium text-slate-500 hover:text-blue-400 transition-colors group">
                            <i class="fa-solid fa-clock-rotate-left text-[10px] opacity-50 group-hover:opacity-100"></i>
                            <span>Log Aktivitas</span>
                        </a>
                    </div>
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
        <!-- HEADER: Putih Bersih dengan Border Bawah Jelas -->
        <header x-show="isLoaded"
            x-transition:enter="transition-all cubic-bezier(0.16, 1, 0.3, 1) duration-1000"
            x-transition:enter-start="opacity-0 -translate-y-12 backdrop-blur-0 shadow-none"
            x-transition:enter-end="opacity-100 translate-y-0 backdrop-blur-xl shadow-[0_15px_30px_-5px_rgba(15,23,42,0.15),0_4px_12px_rgba(29,78,216,0.15)]"
            class="sticky top-0 z-30 bg-white/[0.75] backdrop-blur-xl border-b border-blue-900/30 px-4 lg:px-8 py-4 flex items-center justify-between transition-all duration-500 hover:bg-white/[0.82] hover:border-blue-700/50 shadow-[0_10px_25px_-5px_rgba(15,23,42,0.12),0_4px_10px_rgba(29,78,216,0.1)] hover:shadow-[0_20px_35px_-5px_rgba(15,23,42,0.18),0_8px_20px_rgba(29,78,216,0.25)]">
            <div class="flex items-center gap-4">
                <button @click="mobileSidebar = true" class="lg:hidden text-slate-500 hover:text-blue-600 transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight uppercase italic">Pengaturan Sistem</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manajemen Hak Akses Pengguna</p>
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
            <!-- Title Section -->
            <div x-show="isLoaded"
                x-transition:enter="transition ease-out duration-700 delay-100"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase italic flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span> Database Pengguna
                    </h2>
                    <p class="text-[10px] text-slate-500 font-bold ml-4 uppercase tracking-tighter">Kelola hak akses Admin Divisi & Sekretariat</p>
                </div>
                <button @click="addModal = true" class="bg-blue-600 hover:bg-slate-900 text-white px-6 py-3 rounded-2xl text-xs font-black transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20 active:scale-95 uppercase tracking-widest">
                    <i class="fa-solid fa-user-plus"></i> TAMBAH USER BARU
                </button>
            </div>

            <!-- Grid Table Section -->
            <div x-show="isLoaded"
                x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-20"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                <!-- Admin Divisi Table -->
                <div class="space-y-4">
                    <h3 class="text-[11px] font-black text-emerald-600 uppercase tracking-[0.2em] flex items-center gap-2 px-2 italic">
                        <i class="fa-solid fa-building-user"></i> Admin Divisi
                    </h3>
                    <div class="bg-white rounded-[35px] overflow-hidden border-2 border-slate-200 shadow-sm transition-all hover:shadow-md">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-900">
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center w-16">No</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest">Informasi Akun</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($adminDivisi as $index => $u)
                                <tr class="hover:bg-slate-50 transition-all group">
                                    <td class="p-5 text-center font-black text-slate-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="p-5">
                                        <p class="text-sm font-black text-slate-900 tracking-tight uppercase italic transition-colors group-hover:text-blue-600">{{ $u->nama }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 font-bold">@ {{ $u->username }}</p>
                                    </td>
                                    <td class="p-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="selectedUser = {{ json_encode($u) }}; editModal = true" class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all shadow-sm active:scale-90">
                                                <i class="fa-solid fa-user-pen text-xs"></i>
                                            </button>
                                            <button onclick="confirmDelete('{{ $u->id }}', '{{ $u->username }}')" class="w-9 h-9 rounded-xl bg-red-50 border border-red-200 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm active:scale-90">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Admin Sekretariat Table -->
                <div class="space-y-4">
                    <h3 class="text-[11px] font-black text-blue-600 uppercase tracking-[0.2em] flex items-center gap-2 px-2 italic">
                        <i class="fa-solid fa-user-gear"></i> Admin Sekretariat
                    </h3>
                    <div class="bg-white rounded-[35px] overflow-hidden border-2 border-slate-200 shadow-sm transition-all hover:shadow-md">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-900">
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center w-16">No</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest">Informasi Akun</th>
                                    <th class="p-5 text-[10px] font-black text-blue-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($adminSekret as $index => $u)
                                <tr class="hover:bg-slate-50 transition-all group">
                                    <td class="p-5 text-center font-black text-slate-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="p-5">
                                        <p class="text-sm font-black text-slate-900 tracking-tight uppercase italic transition-colors group-hover:text-blue-600">{{ $u->nama }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 font-bold">@ {{ $u->username }}</p>
                                    </td>
                                    <td class="p-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="selectedUser = {{ json_encode($u) }}; editModal = true" class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all shadow-sm active:scale-90">
                                                <i class="fa-solid fa-user-pen text-xs"></i>
                                            </button>
                                            <button onclick="confirmDelete('{{ $u->id }}', '{{ $u->username }}')" class="w-9 h-9 rounded-xl bg-red-50 border border-red-200 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm active:scale-90">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div x-show="addModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4" x-cloak x-transition>
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" @click="addModal = false"></div>
        <div class="glass-card w-full max-w-xl rounded-[40px] p-8 z-10 border border-white/10 animate__animated animate__fadeInDown">
            <h3 class="text-xl font-black text-white italic uppercase mb-6 flex items-center gap-3">
                <i class="fa-solid fa-user-shield text-blue-500 text-sm"></i> Registrasi Akses Baru
            </h3>

            <form
                id="registrationForm"
                action="{{ route('kelola-akun.store') }}"
                method="POST"
                class="space-y-5"
                x-data="{ 
                    showPassword: false, 
                    nama: '',
                    username: '',
                    password: '',
                    isFormValid: false,
                    validateForm() {
                        // Memeriksa apakah element form memenuhi semua aturan HTML5 (required, minlength, dll)
                        this.isFormValid = $el.checkValidity();
                    }
                }"
                @input="validateForm()"
                @init="validateForm()">
                @csrf
                <div>
                    <label class="text-[10px] font-bold text-slate-500 ml-2 uppercase tracking-tighter">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        x-model="nama"
                        required
                        placeholder="Masukkan Nama Lengkap"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 ml-2 uppercase tracking-tighter">Username</label>
                        <input
                            type="text"
                            name="username"
                            x-model="username"
                            required
                            placeholder="username_login"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 ml-2 uppercase tracking-tighter">Password</label>
                        <div class="relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                x-model="password"
                                name="password"
                                required
                                minlength="6"
                                placeholder="******"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl pl-4 pr-12 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all"
                                :class="password.length > 0 && password.length < 6 ? 'border-red-500/50 focus:border-red-500' : ''">
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors focus:outline-none">
                                <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>

                        <span
                            x-show="password.length > 0 && password.length < 6"
                            x-transition
                            class="text-[10px] font-semibold text-red-400 ml-2 mt-1 block tracking-wide">
                            * Password harus minimal 6 karakter!
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-2">Pilih Role Akses</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative group cursor-pointer">
                            <input type="radio" name="role" value="ADMINDIVISI" class="peer hidden" checked>
                            <div class="relative overflow-hidden flex items-center justify-center py-4 rounded-2xl bg-white/[0.03] border border-white/10 transition-all duration-500 
                                        peer-checked:border-emerald-500/50 peer-checked:bg-emerald-500/10 hover:bg-white/[0.08] group-active:scale-95">
                                <span class="relative z-10 text-[11px] font-black text-slate-400 peer-checked:text-emerald-400 uppercase tracking-widest transition-colors">Admin Divisi</span>
                                <div class="absolute inset-0 opacity-0 peer-checked:opacity-100 bg-gradient-to-t from-emerald-500/10 to-transparent transition-opacity"></div>
                            </div>
                        </label>

                        <label class="relative group cursor-pointer">
                            <input type="radio" name="role" value="ADMINSEKRET" class="peer hidden">
                            <div class="relative overflow-hidden flex items-center justify-center py-4 rounded-2xl bg-white/[0.03] border border-white/10 transition-all duration-500 
                                        peer-checked:border-blue-500/50 peer-checked:bg-blue-500/10 hover:bg-white/[0.08] group-active:scale-95">
                                <span class="relative z-10 text-[11px] font-black text-slate-400 peer-checked:text-blue-400 uppercase tracking-widest transition-colors">Admin Sekret</span>
                                <div class="absolute inset-0 opacity-0 peer-checked:opacity-100 bg-gradient-to-t from-blue-500/10 to-transparent transition-opacity"></div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="button" @click="addModal = false" class="flex-1 py-4 bg-white/5 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white/10 transition-all border border-white/5">Batal</button>

                    <button
                        type="submit"
                        :disabled="!isFormValid"
                        class="flex-1 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all"
                        :class="isFormValid 
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:scale-[1.02] shadow-lg shadow-blue-600/20 active:scale-95 cursor-pointer' 
                            : 'bg-white/5 text-slate-600 border border-white/5 cursor-not-allowed opacity-50'">
                        Daftarkan User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="editModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4" x-cloak x-transition>
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" @click="editModal = false"></div>
        <div class="glass-card w-full max-w-xl rounded-[40px] p-8 z-10 border border-white/10 animate__animated animate__fadeInUp">
            <h3 class="text-xl font-black text-white italic uppercase mb-6 flex items-center gap-3">
                <i class="fa-solid fa-user-pen text-amber-500 text-sm"></i> Update Data Pengguna
            </h3>
            <form :action="'{{ route('kelola-akun.update', '') }}/' + selectedUser.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-[10px] font-bold text-slate-500 ml-2 uppercase tracking-tighter">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="selectedUser.nama" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 ml-2 uppercase tracking-tighter">Username</label>
                    <input type="text" name="username" x-model="selectedUser.username" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 ml-2 uppercase tracking-tighter text-amber-500 italic">Kosongkan password jika tidak ingin diubah *</label>
                    <input type="password" name="password" placeholder="********" class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                </div>

                <input type="hidden" name="role" x-model="selectedUser.role">

                <div class="flex gap-3 mt-8">
                    <button type="button" @click="editModal = false" class="flex-1 py-4 bg-white/5 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white/10 transition-all border border-white/5">Batal</button>
                    <button type="submit" class="flex-1 py-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:scale-[1.02] shadow-lg shadow-amber-600/20 transition-all active:scale-95">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>


    @if(session('success'))
    <script>
        Swal.fire({
            title: '<span class="text-emerald-400 text-lg font-black italic block mb-2">BERHASIL</span>',
            html: `
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-emerald-500/10 flex items-center justify-center mb-4">
                <i class="fa-solid fa-check text-emerald-500 text-2xl"></i>
            </div>
            <p class="text-[11px] text-slate-400 tracking-wider uppercase font-bold">
                {{ session('success') }}
            </p>
        </div>
    `,
            background: '#0f172a',
            showConfirmButton: true,
            confirmButtonText: 'TUTUP',
            timer: 3000, // Otomatis hilang setelah 3 detik
            timerProgressBar: true, // Progress bar di bawah
            customClass: {
                popup: 'premium-swal-popup',
                confirmButton: 'premium-swal-success-confirm'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        });
    </script>
    @endif
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

        function confirmDelete(id, username) {
            Swal.fire({
                title: '<span class="text-white text-lg font-black italic block mb-2">HAPUS PENGGUNA?</span>',
                html: `
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center">
                    <i class="fa-solid fa-trash-can text-red-500 text-2xl"></i>
                </div>
                <p class="text-[11px] text-slate-400 tracking-wider leading-relaxed">
                    Tindakan ini tidak dapat dibatalkan. Data akses untuk 
                    <span class="text-white font-bold italic">"${username}"</span> 
                    akan dihapus permanen dari sistem.
                </p>
            </div>
        `,
                showCancelButton: true,
                background: '#0f172a',
                confirmButtonText: 'YA, HAPUS PERMANEN',
                cancelButtonText: 'BATALKAN',
                reverseButtons: true, // Tombol confirm di sebelah kanan
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-confirm',
                    cancelButton: 'premium-swal-cancel'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutDown animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = `{{ route('kelola-akun.destroy', '') }}/${id}`;

                    // Tambahkan loading state pada tombol jika perlu
                    Swal.showLoading();
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>