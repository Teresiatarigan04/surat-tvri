<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Secretary TVRI Sumut | Official Portal</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.lordicon.com/lordicon.js"></script>

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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617;
            scroll-behavior: smooth;
        }

        .glass-premium {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes blob {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite alternate ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .animate-float {
            animation: float 5s infinite ease-in-out;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* --- FIXED & IMPROVED LOADER CSS --- */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(2, 6, 23, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            display: none;
            /* Default hidden */
            justify-content: center;
            align-items: center;
            z-index: 99999;
            /* Sangat tinggi agar tidak tertutup */
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        #page-loader.show {
            display: flex;
            opacity: 1;
        }

        #loader-inner {
            transform: scale(0.7);
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        #page-loader.show #loader-inner {
            transform: scale(1);
        }
    </style>
</head>

<body class="text-slate-200 overflow-x-hidden no-scrollbar" x-data="{ mobileMenu: false }">

    <div id="page-loader">
        <div id="loader-inner" class="text-center">
            <lord-icon
                src="https://cdn.lordicon.com/pxruoqrv.json"
                trigger="loop"
                colors="primary:#3b82f6,secondary:#10b981"
                style="width:150px;height:150px">
            </lord-icon>
            <p class="mt-4 text-blue-400 font-black text-[11px] tracking-[0.5em] uppercase animate-pulse">
                Menyiapkan Dashboard...
            </p>
        </div>
    </div>

    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-[-10%] w-72 h-72 md:w-96 md:h-96 bg-blue-600/20 rounded-full blur-[100px] animate-blob"></div>
        <div class="absolute bottom-0 right-[-5%] w-80 h-80 md:w-[500px] md:h-[500px] bg-emerald-600/10 rounded-full blur-[120px] animate-blob" style="animation-delay: 2s"></div>
    </div>

    <header class="fixed top-0 left-0 w-full z-[100] px-4 py-4 md:px-10">
        <nav class="max-w-7xl mx-auto glass-premium rounded-2xl md:rounded-full p-3 md:p-4 flex justify-between items-center shadow-2xl border border-white/5">
            <div class="flex items-center gap-3 ml-2">
                <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-8 md:h-10">
                <div class="hidden sm:block h-6 w-px bg-white/20"></div>
                <p class="hidden sm:block text-[10px] font-black tracking-[0.3em] text-blue-400">TVRI SUMUT</p>
            </div>

            <div class="hidden lg:flex items-center gap-8 mr-4">
                <a href="#fitur" class="nav-link text-[10px] font-black tracking-widest hover:text-blue-400 transition-all uppercase">Layanan</a>
                <a href="#statistik" class="nav-link text-[10px] font-black tracking-widest hover:text-blue-400 transition-all uppercase">Data</a>
                <a href="#alur" class="nav-link text-[10px] font-black tracking-widest hover:text-blue-400 transition-all uppercase">Alur</a>
                <a href="#gallery" class="nav-link text-[10px] font-black tracking-widest hover:text-blue-400 transition-all uppercase">Gallery</a>
                <a href="{{ route('login') }}" class="loader-trigger px-8 py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-black text-[10px] tracking-widest transition-all hover:scale-105 active:scale-95 shadow-lg shadow-blue-600/30 text-white">LOGIN ADMIN</a>
            </div>

            <button @click="mobileMenu = true" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-white/5">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </nav>
    </header>

    <section class="relative min-h-screen flex flex-col z-10" x-data="{ 
        active: 0,
        slides: [
            '{{ asset('assets/img/gedung1.jpg') }}',
            '{{ asset('assets/img/controlroom.jpg') }}',
            '{{ asset('assets/img/studio.jpg') }}',
            '{{ asset('assets/img/serverroom.jpg') }}'
        ]
    }" x-init="setInterval(() => active = (active + 1) % slides.length, 7000)">

        <div class="absolute inset-0 z-[-1] overflow-hidden">
            <template x-for="(img, i) in slides" :key="i">
                <div x-show="active === i"
                    x-transition:enter="transition opacity duration-1000 ease-in"
                    x-transition:leave="transition opacity duration-1000 ease-out"
                    class="absolute inset-0">
                    <img :src="img" class="w-full h-full object-cover brightness-[0.25] scale-105">
                </div>
            </template>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/60 via-transparent to-slate-950"></div>
        </div>

        <div class="flex-1 flex flex-col justify-center items-center px-6 text-center pt-32 pb-12 md:py-20">
            <div class="glass-premium px-5 py-2 rounded-full mb-6 animate-float border border-white/10">
                <span class="text-[9px] md:text-[10px] font-black tracking-[0.4em] text-blue-300 uppercase">E-Secretary TVRI Sumatera Utara</span>
            </div>

            <h1 class="text-4xl md:text-7xl lg:text-8xl font-black tracking-tighter leading-[1.1] mb-6 uppercase">
                INTEGRATED <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-emerald-400">WORKFLOW</span>
            </h1>

            <p class="max-w-2xl text-slate-400 text-sm md:text-lg mb-10 leading-relaxed font-medium italic">
                "Mengoptimalkan setiap lembar dokumen menjadi data digital yang bermakna."
            </p>

            <div class="flex flex-col sm:flex-row gap-4 w-full max-w-sm">
                <a href="{{ route('login') }}" class="loader-trigger flex-1 py-4 bg-white text-slate-950 font-black rounded-xl shadow-2xl hover:bg-blue-50 transition-all text-sm uppercase tracking-widest text-center">Mulai Sekarang</a>
                <a href="#fitur" class="nav-link flex-1 py-4 glass-premium font-black rounded-xl hover:bg-white/10 transition-all text-sm uppercase tracking-widest text-center">Eksplor Fitur</a>
            </div>
        </div>
    </section>

    <section id="fitur" class="relative py-24 px-6 bg-slate-950/50 pt-32">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-blue-500 font-black tracking-widest text-xs uppercase mb-3 reveal">Core Systems</h2>
                <h3 class="text-3xl md:text-5xl font-black uppercase tracking-tighter reveal">Fitur Utama</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-premium p-8 rounded-[32px] group hover:border-blue-500/50 transition-all duration-500 reveal">
                    <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 text-2xl mb-6"><i class="fa-solid fa-layer-group"></i></div>
                    <h4 class="font-black mb-3 uppercase tracking-tight">Manajemen Terpusat</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic text-white/60">Sentralisasi surat masuk dan keluar melalui dashboard admin sekretariat yang intuitif.</p>
                </div>
                <div class="glass-premium p-8 rounded-[32px] group hover:border-emerald-500/50 transition-all duration-500 reveal" style="transition-delay: 100ms">
                    <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 text-2xl mb-6"><i class="fa-solid fa-map-location-dot"></i></div>
                    <h4 class="font-black mb-3 uppercase tracking-tight">Real-time Tracking</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic text-white/60">Pantau status perjalanan surat secara langsung mulai dari pengajuan hingga disposisi.</p>
                </div>
                <div class="glass-premium p-8 rounded-[32px] group hover:border-amber-500/50 transition-all duration-500 reveal" style="transition-delay: 200ms">
                    <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 text-2xl mb-6"><i class="fa-solid fa-file-invoice"></i></div>
                    <h4 class="font-black mb-3 uppercase tracking-tight">Digital Archiving</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic text-white/60">Penyimpanan arsip berbasis digital yang aman dan mudah dicari kapan saja dibutuhkan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="statistik" class="py-20 px-6">
        <div class="max-w-7xl mx-auto glass-premium rounded-[40px] p-10 md:p-16">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="reveal">
                    <h5 class="text-4xl md:text-5xl font-black text-blue-500 mb-2">1.2K+</h5>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-slate-500 uppercase">Surat Masuk</p>
                </div>
                <div class="reveal" style="transition-delay: 100ms">
                    <h5 class="text-4xl md:text-5xl font-black text-emerald-500 mb-2">850+</h5>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-slate-500 uppercase">Surat Keluar</p>
                </div>
                <div class="reveal" style="transition-delay: 200ms">
                    <h5 class="text-4xl md:text-5xl font-black text-indigo-500 mb-2">100%</h5>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-slate-500 uppercase">Terverifikasi</p>
                </div>
                <div class="reveal" style="transition-delay: 300ms">
                    <h5 class="text-4xl md:text-5xl font-black text-amber-500 mb-2">24/7</h5>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-slate-500 uppercase">Sistem Aktif</p>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-24 px-6 bg-slate-900/30">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter text-center mb-20 reveal">Workflow Alur Surat</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center reveal">
                    <div class="w-16 h-16 bg-white text-slate-950 font-black rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3">01</div>
                    <h5 class="font-bold uppercase tracking-widest text-xs mb-2">Submission</h5>
                    <p class="text-[10px] text-slate-500 uppercase tracking-tighter italic">Input Dokumen Digital</p>
                </div>
                <div class="text-center reveal" style="transition-delay: 100ms">
                    <div class="w-16 h-16 bg-blue-600 font-black rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-3 shadow-lg shadow-blue-600/40 text-white">02</div>
                    <h5 class="font-bold uppercase tracking-widest text-xs mb-2">Verification</h5>
                    <p class="text-[10px] text-slate-500 uppercase tracking-tighter italic">Validasi Sekretariat</p>
                </div>
                <div class="text-center reveal" style="transition-delay: 200ms">
                    <div class="w-16 h-16 bg-indigo-600 font-black rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3 shadow-lg shadow-indigo-600/40 text-white">03</div>
                    <h5 class="font-bold uppercase tracking-widest text-xs mb-2">Disposition</h5>
                    <p class="text-[10px] text-slate-500 uppercase tracking-tighter italic">Penerusan Pimpinan</p>
                </div>
                <div class="text-center reveal" style="transition-delay: 300ms">
                    <div class="w-16 h-16 bg-emerald-500 font-black rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-3 shadow-lg shadow-emerald-500/40 text-white">04</div>
                    <h5 class="font-bold uppercase tracking-widest text-xs mb-2">Archived</h5>
                    <p class="text-[10px] text-slate-500 uppercase tracking-tighter italic">Selesai & Diarsipkan</p>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-24 px-6 bg-slate-950/50">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="reveal">
                    <h2 class="text-blue-500 font-black tracking-widest text-xs uppercase mb-3">Documentation</h2>
                    <h3 class="text-3xl md:text-5xl font-black uppercase tracking-tighter">Gallery Kegiatan</h3>
                </div>
                <p class="text-xs text-slate-500 max-w-xs italic reveal">Visualisasi infrastruktur dan aktivitas digital TVRI Sumatera Utara.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 reveal">
                <div class="group relative overflow-hidden rounded-3xl h-64 glass-premium"><img src="{{ asset('assets/img/gedung1.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-60 group-hover:opacity-100"></div>
                <div class="group relative overflow-hidden rounded-3xl h-64 glass-premium md:mt-12"><img src="{{ asset('assets/img/studio.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-60 group-hover:opacity-100"></div>
                <div class="group relative overflow-hidden rounded-3xl h-64 glass-premium"><img src="{{ asset('assets/img/controlroom.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-60 group-hover:opacity-100"></div>
                <div class="group relative overflow-hidden rounded-3xl h-64 glass-premium md:mt-12"><img src="{{ asset('assets/img/serverroom.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-60 group-hover:opacity-100"></div>
            </div>
        </div>
    </section>

    <footer class="py-16 px-6 border-t border-white/5 text-center">
        <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-10 mx-auto mb-6 opacity-40 grayscale hover:opacity-100 hover:grayscale-0 transition-all">
        <p class="text-[9px] font-black tracking-[0.5em] text-slate-600 uppercase mb-2">LPP TVRI Sumatera Utara &copy; 2026</p>
        <div class="flex justify-center gap-6 mt-4">
            <a href="#" class="text-slate-600 hover:text-blue-400 text-xs transition-colors"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="text-slate-600 hover:text-blue-400 text-xs transition-colors"><i class="fa-brands fa-youtube"></i></a>
            <a href="#" class="text-slate-600 hover:text-blue-400 text-xs transition-colors"><i class="fa-brands fa-facebook"></i></a>
        </div>
    </footer>

    <div x-show="mobileMenu" x-transition.opacity class="fixed inset-0 z-[200] bg-slate-950/95 backdrop-blur-xl p-8 lg:hidden flex flex-col items-center justify-center text-center">
        <button @click="mobileMenu = false" class="absolute top-10 right-10 text-3xl text-white/50"><i class="fa-solid fa-times"></i></button>
        <div class="flex flex-col gap-8">
            <a href="#fitur" @click="mobileMenu = false" class="nav-link text-4xl font-black uppercase tracking-tighter">Layanan</a>
            <a href="#statistik" @click="mobileMenu = false" class="nav-link text-4xl font-black uppercase tracking-tighter">Data</a>
            <a href="#alur" @click="mobileMenu = false" class="nav-link text-4xl font-black uppercase tracking-tighter">Workflow</a>
            <a href="#gallery" @click="mobileMenu = false" class="nav-link text-4xl font-black uppercase tracking-tighter">Gallery</a>
            <a href="{{ route('login') }}" class="loader-trigger text-4xl font-black uppercase tracking-tighter text-blue-500">Sign In</a>
        </div>
    </div>

    <script>
        // Reveal animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Smooth Scroll with Offset
        document.querySelectorAll('.nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId.startsWith('#')) {
                    e.preventDefault();
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        const offset = 100;
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - offset;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        /* --- SCRIPT LOADER PERBAIKAN --- */
        function startLoading(e) {
            const loader = document.getElementById('page-loader');
            // Cegah loading jika klik kanan atau ctrl+klik
            if (e.ctrlKey || e.shiftKey || e.metaKey || e.button === 1) return;

            loader.style.display = 'flex'; // Munculkan dulu strukturnya
            setTimeout(() => {
                loader.classList.add('show'); // Baru jalankan animasi fade & scale
            }, 10);
        }

        // Pasang trigger pada semua tombol login/mulai
        document.querySelectorAll('.loader-trigger').forEach(el => {
            el.addEventListener('click', function(e) {
                startLoading(e);
            });
        });

        // Hilangkan loader jika user menekan back browser
        window.onpageshow = function(event) {
            const loader = document.getElementById('page-loader');
            if (event.persisted) {
                loader.classList.remove('show');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }
        };
    </script>
</body>

</html>