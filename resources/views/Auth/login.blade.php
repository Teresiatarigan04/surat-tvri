<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Secretary TVRI Sumut</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; }
        
        .glass-login {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes blob {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }
        .animate-blob { animation: blob 10s infinite alternate ease-in-out; }

        /* Loader Overlay */
        #page-loader {
            position: fixed; inset: 0; background: rgba(2, 6, 23, 0.98);
            backdrop-filter: blur(20px); display: none;
            justify-content: center; align-items: center; z-index: 99999;
            opacity: 0; transition: opacity 0.4s ease;
        }
        #page-loader.show { display: flex; opacity: 1; }

        /* SweetAlert Custom Dark Theme */
        .swal2-popup {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(15px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 28px !important;
            color: #e2e8f0 !important;
        }
        .swal2-styled.swal2-confirm {
            background-color: #3b82f6 !important;
            border-radius: 12px !important;
            padding: 10px 30px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            font-size: 10px !important;
            letter-spacing: 1px !important;
        }
    </style>
</head>
<body class="text-slate-200 min-h-[100dvh] flex items-center justify-center p-4 md:p-6 overflow-hidden">

    <div id="page-loader">
        <div class="text-center">
            <lord-icon src="https://cdn.lordicon.com/pxruoqrv.json" trigger="loop" 
                colors="primary:#3b82f6,secondary:#10b981" style="width:150px;height:150px"></lord-icon>
            <p class="mt-4 text-blue-400 font-black text-[10px] tracking-[0.5em] uppercase animate-pulse">Memverifikasi Otoritas...</p>
        </div>
    </div>

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-72 h-72 md:w-96 md:h-96 bg-blue-600/20 rounded-full blur-[100px] animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-72 h-72 md:w-96 md:h-96 bg-emerald-600/10 rounded-full blur-[100px] animate-blob" style="animation-delay: 3s"></div>
    </div>

    <div id="session-bridge" 
         data-error="{{ $errors->any() ? $errors->first() : '' }}" 
         data-success="{{ session('success') }}"></div>

    <main class="relative z-10 w-full max-w-[400px]">
        <div class="text-center mb-10">
            <a href="/">
                <img src="{{ asset('assets/img/logo-tvri.png') }}" class="h-10 md:h-12 mx-auto mb-4 drop-shadow-2xl" alt="Logo TVRI">
            </a>
            <h2 class="text-xl md:text-2xl font-black tracking-tighter uppercase italic">Security Portal</h2>
            <p class="text-[10px] text-slate-500 tracking-[0.3em] mt-2 uppercase font-bold">LPP TVRI SUMATERA UTARA</p>
        </div>

        <div class="glass-login rounded-[35px] p-8 md:p-10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-50"></div>

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-6" id="loginForm">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black tracking-widest text-blue-400 uppercase ml-1">Account Username</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 group-focus-within:text-blue-400 transition-colors">
                            <i class="fa-solid fa-user-gear text-sm"></i>
                        </span>
                        <input type="text" name="username" value="{{ old('username') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600"
                            placeholder="Enter username">
                    </div>
                </div>

                <div class="space-y-2" x-data="{ show: false }">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-[10px] font-black tracking-widest text-blue-400 uppercase">Access Password</label>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 group-focus-within:text-blue-400 transition-colors">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" name="password" required 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-12 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-600 hover:text-white transition-colors">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-lg shadow-blue-600/30 transition-all active:scale-[0.97] text-[11px] uppercase tracking-[0.2em] mt-4 flex items-center justify-center gap-2">
                    Authorize Login <i class="fa-solid fa-right-to-bracket"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-[9px] text-slate-600 uppercase tracking-widest leading-relaxed">
                    Protected by TVRI Sumut Infrastructure <br>
                    <span class="text-slate-700">Digital Administration Security v1.0</span>
                </p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="/" class="text-[10px] font-black text-slate-500 hover:text-white transition-colors uppercase tracking-[0.3em] flex items-center justify-center gap-2">
                <i class="fa-solid fa-chevron-left"></i> Back to Homepage
            </a>
        </div>
    </main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loader = document.getElementById('page-loader');
    
    // PERBAIKAN: Definisikan variabel bridge terlebih dahulu
    const bridge = document.getElementById('session-bridge');

    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            // Tampilkan loader saat tombol ditekan
            loader.style.display = 'flex';
            setTimeout(() => loader.classList.add('show'), 10);
        });
    }

    // Pastikan elemen bridge ada sebelum mengambil atributnya
    if (bridge) {
        // Ambil data dan hapus spasi kosong dengan trim()
        const errorMsg = bridge.getAttribute('data-error') ? bridge.getAttribute('data-error').trim() : "";
        const successMsg = bridge.getAttribute('data-success') ? bridge.getAttribute('data-success').trim() : "";

        // Alert Error (Jika login gagal)
        if (errorMsg !== "") {
            Swal.fire({
                icon: 'error',
                title: '<span style="font-weight:900; font-size:18px; color:#f87171;">ACCESS DENIED</span>',
                html: `<p style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">${errorMsg}</p>`,
                confirmButtonText: 'TRY AGAIN'
            });
        }

        // Alert Success (Jika ada pesan sukses)
        if (successMsg !== "") {
            Swal.fire({
                icon: 'success',
                title: '<span style="font-weight:900; font-size:18px; color:#10b981;">AUTHORIZED</span>',
                html: `<p style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">${successMsg}</p>`,
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
    }
});

// Menghilangkan loader jika user menekan tombol 'Back' di browser
window.onpageshow = function(event) {
    const loader = document.getElementById('page-loader');
    if (event.persisted && loader) {
        loader.classList.remove('show');
        setTimeout(() => { loader.style.display = 'none'; }, 500);
    }
};
</script>
</body>
</html>