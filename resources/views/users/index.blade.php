@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8">
    <div class="mb-8 px-2">
        <h1 class="text-3xl md:text-4xl font-black text-white italic uppercase tracking-tighter leading-none">
            User <span class="text-emerald-500">Management</span>
        </h1>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2 italic">Kelola Akses Admin & Kasir</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-slate-900 p-8 rounded-[2rem] border border-slate-800 shadow-2xl h-fit sticky top-24">
            <h2 class="text-emerald-500 font-black uppercase tracking-[0.2em] text-xs mb-8 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Tambah Akun Baru
            </h2>
            
            <form action="/users/simpan" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Contoh: Budi Santoso" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500 transition-all font-bold text-sm" required>
                </div>
                
                <div>
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest">Email Login</label>
                    <input type="email" name="email" placeholder="budi@apotek.com" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500 transition-all font-bold text-sm" required>
                </div>
                
                <div>
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest">Password</label>
                    <input type="password" name="password" placeholder="Min. 6 Karakter" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500 transition-all font-bold text-sm" required>
                </div>
                
                <div>
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest">Role / Jabatan</label>
                    <select name="role" class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white outline-none focus:border-emerald-500 transition-all font-bold text-sm appearance-none">
                        <option value="kasir">Kasir (Staf Lapangan)</option>
                        <option value="admin">Admin (Owner / Manager)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-400 text-slate-900 font-black py-5 rounded-2xl uppercase tracking-widest transition-all text-xs active:scale-95 shadow-lg shadow-emerald-900/20">
                    Daftarkan Karyawan
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] border border-slate-800 shadow-2xl overflow-hidden h-fit">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-950/50">
                        <tr class="text-slate-500 text-[10px] uppercase tracking-[0.2em]">
                            <th class="px-8 py-6 font-black">User Details</th>
                            <th class="px-6 py-6 font-black text-center">Status Role</th>
                            <th class="px-8 py-6 font-black text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-800/30 transition-all">
                            <td class="px-8 py-6">
                                <div class="font-bold text-slate-200 text-base leading-none">{{ $user->name }}</div>
                                <div class="text-[10px] text-slate-600 mt-2 font-mono uppercase italic tracking-widest">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-sky-500/10 text-sky-500 border border-sky-500/20' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if($user->id != auth()->id())
                                <form action="/users/hapus/{{ $user->id }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus akun ini?')" class="text-rose-500 hover:text-white p-2 transition-all group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @else
                                <span class="text-[9px] text-slate-700 italic font-bold">You (Active)</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection