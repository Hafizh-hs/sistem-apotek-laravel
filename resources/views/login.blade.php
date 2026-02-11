<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotek Pro Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,700;1,800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(20px); }
        .glow { box-shadow: 0 0 50px -12px rgba(16, 185, 129, 0.2); }
    </style>
</head>
<body class="bg-slate-950 h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-500/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-emerald-600/10 blur-[120px] rounded-full"></div>

    <div class="glass p-8 md:p-12 rounded-[2.5rem] border border-slate-800 w-full max-w-md glow relative z-10 animate-in fade-in zoom-in duration-700">
        
        <div class="text-center mb-10">
            <div class="inline-flex p-4 rounded-3xl bg-emerald-500/10 border border-emerald-500/20 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 .517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-white italic uppercase tracking-tighter">
                Apotek <span class="text-emerald-500 text-glow">Pro</span>
            </h2>
            <p class="text-slate-500 mt-2 text-xs font-bold uppercase tracking-[0.3em]">Management System</p>
        </div>
        
        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-2xl mb-6 text-[11px] font-bold text-center uppercase tracking-widest animate-bounce">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form action="/login/proses" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Karyawan</label>
                <div class="relative">
                    <input type="email" name="email" 
                        class="w-full bg-slate-950/50 border border-slate-800 text-slate-200 p-4 rounded-2xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-700 font-medium" 
                        placeholder="nama@apotek.com" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" 
                        class="w-full bg-slate-950/50 border border-slate-800 text-slate-200 p-4 rounded-2xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-700 font-medium" 
                        placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" id="btnMasuk" 
                class="w-full bg-emerald-600 text-slate-950 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-400 hover:scale-[1.02] transition-all active:scale-95 shadow-lg shadow-emerald-900/20 flex items-center justify-center gap-2">
                Otentikasi Sistem
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </form>

        <p class="text-center mt-10 text-[9px] text-slate-700 font-black uppercase tracking-[0.4em]">
            Secure Access Terminal v3.0
        </p>
    </div>

    <script>
        // Mencegah Double Click
        document.querySelector('form').onsubmit = function() {
            const btn = document.getElementById('btnMasuk');
            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 mr-3 text-slate-950" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memverifikasi...`;
            btn.classList.add('opacity-50');
        };

        // Mencegah Back Button (History Control)
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.history.go(1);
        };
    </script>
</body>
</html>