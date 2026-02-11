<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Pro - Pharmacy Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }

        ::selection {
            background: rgba(16, 185, 129, 0.3);
            color: white;
        }
    </style>
</head>

<body class="bg-[#020617] text-slate-300 min-h-screen flex flex-col" x-data="{ openPassword: false }">

    <div class="max-w-7xl mx-auto w-full p-4 md:p-8 pb-0 md:pb-0">
        <nav class="glass sticky top-4 z-50 flex flex-row items-center justify-between p-3 md:p-4 rounded-2xl shadow-2xl border border-slate-800">
            <div class="flex items-center gap-2 flex-shrink-0">
                <div class="bg-emerald-500 p-2 rounded-lg shadow-lg shadow-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span class="text-lg md:text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-cyan-400 hidden sm:block uppercase tracking-tighter">Apotek Pro</span>
            </div>
            @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 md:px-8 mt-4">
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 px-6 py-4 rounded-2xl font-bold text-sm">
                    ✨ {{ session('success') }}
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 md:px-8 mt-4">
                <div class="bg-rose-500/10 border border-rose-500/20 text-rose-500 px-6 py-4 rounded-2xl font-bold text-sm">
                    {{ $errors->first() }}
                </div>
            </div>
            @endif

            <div class="flex flex-row items-center gap-1 md:gap-4 mx-2 overflow-x-auto no-scrollbar py-1 px-2 flex-1 justify-center">

                @if(Auth::check() && Auth::user()->role == 'admin')
                <a href="/dashboard" class="group flex-none flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition-all {{ Request::is('dashboard') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="hidden lg:inline">Dashboard</span>
                </a>
                @endif

                <a href="/obat" class="group flex-none flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition-all {{ Request::is('obat*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="hidden lg:inline">Stok</span>
                </a>

                <a href="/kasir" class="group flex-none flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition-all {{ Request::is('kasir') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="hidden lg:inline">Kasir</span>
                </a>

                <a href="/kasir/riwayat" class="group flex-none flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition-all {{ Request::is('kasir/riwayat*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="hidden lg:inline">Riwayat</span>
                </a>

                @if(Auth::check() && Auth::user()->role == 'admin')
                <a href="/laporan" class="group flex-none flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition-all {{ Request::is('laporan*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="hidden lg:inline">Laporan</span>
                </a>

                <a href="/users" class="group flex-none flex items-center gap-2 px-3 py-2 rounded-xl text-sm transition-all {{ Request::is('users*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="hidden lg:inline">Karyawan</span>
                </a>
                @endif
            </div>

            <div class="flex-shrink-0 flex items-center gap-3">
                <div class="hidden md:flex flex-col items-end mr-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">{{ Auth::user()->role ?? 'Guest' }}</span>
                    <button @click="openPassword = true" class="text-xs font-bold text-white leading-none hover:text-emerald-400 transition-all cursor-pointer">
                        {{ Auth::user()->name ?? 'User' }} ⚙️
                    </button>
                </div>
                <a href="/logout" class="flex items-center justify-center bg-red-500/10 text-red-500 border border-red-500/20 w-10 h-10 md:w-auto md:px-5 md:py-2 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="hidden lg:block ml-2 text-sm font-bold">Keluar</span>
                </a>
            </div>
        </nav>
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    <div x-show="openPassword" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm">
        <div @click.away="openPassword = false" class="bg-slate-900 border border-slate-800 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
            <h2 class="text-xl font-black text-white uppercase italic mb-6">Ganti <span class="text-emerald-500">Password</span></h2>
            <form action="/ganti-password" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 tracking-widest">Password Lama</label>
                    <input type="password" name="current_password" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500" required>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 tracking-widest">Password Baru</label>
                    <input type="password" name="new_password" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500" required>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase ml-2 tracking-widest">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500" required>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" @click="openPassword = false" class="flex-1 bg-slate-800 text-slate-400 font-bold py-4 rounded-2xl uppercase text-[10px] tracking-widest">Batal</button>
                    <button type="submit" class="flex-1 bg-emerald-600 text-slate-900 font-black py-4 rounded-2xl uppercase text-[10px] tracking-widest hover:bg-emerald-400 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="mt-auto py-8 px-4 border-t border-slate-900 bg-slate-950/20 text-center">
        <p class="text-slate-500 text-[10px] md:text-xs font-medium uppercase tracking-[0.2em]">
            &copy; 2026 <span class="text-emerald-500 font-black">Apotek Pro</span> - Professional Pharmacy System
        </p>
    </footer>

</body>

</html>