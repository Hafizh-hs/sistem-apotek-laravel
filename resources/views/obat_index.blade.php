@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto p-4 md:p-8" x-data="{ tab: 'aktif' }">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-5 px-2">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-white italic uppercase tracking-tighter leading-none">
                Inventory <span class="text-emerald-500">Control</span>
            </h1>
            
            <div class="flex gap-4 md:gap-8 mt-6 border-b border-slate-800 overflow-x-auto no-scrollbar">
                <button @click="tab = 'aktif'" :class="tab === 'aktif' ? 'text-emerald-500 border-b-2 border-emerald-500' : 'text-slate-500'" class="pb-2 text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Siap Jual</button>
                <button @click="tab = 'semua'" :class="tab === 'semua' ? 'text-sky-500 border-b-2 border-sky-500' : 'text-slate-500'" class="pb-2 text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Semua Stok</button>
                <button @click="tab = 'perlu_audit'" :class="tab === 'perlu_audit' ? 'text-orange-500 border-b-2 border-orange-500' : 'text-slate-500'" class="pb-2 text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap text-orange-400">⚠️ Butuh Audit</button>
                <button @click="tab = 'arsip'" :class="tab === 'arsip' ? 'text-rose-500 border-b-2 border-rose-500' : 'text-slate-500'" class="pb-2 text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Arsip Audit</button>
            </div>
        </div>
        
        {{-- TOMBOL TAMBAH: HANYA UNTUK ADMIN --}}
        @if(auth()->user()->role == 'admin')
        <a href="/obat/tambah" class="flex items-center justify-center gap-2 bg-emerald-600 text-slate-900 px-6 py-3 rounded-2xl font-black hover:bg-emerald-400 transition-all text-xs uppercase tracking-widest active:scale-95 shadow-lg shadow-emerald-900/20">
            + Tambah Obat
        </a>
        @endif
    </div>

    <div class="bg-slate-900 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-slate-950/50 hidden md:table-header-group">
                    <tr class="text-slate-500 text-[10px] md:text-xs uppercase tracking-[0.2em]">
                        <th class="px-8 py-6 font-black">Produk</th>
                        <th class="px-6 py-6 text-center font-black">Stok</th>
                        <th class="px-6 py-6 text-center font-black">Kadaluarsa</th>
                        <th class="px-8 py-6 text-right font-black">Kelola / Eksekusi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 flex flex-col md:table-row-group">
                    
                    @foreach($semua_obat as $obat)
                    @php 
                        $isExpired = $obat->tgl_kadaluarsa && \Carbon\Carbon::parse($obat->tgl_kadaluarsa)->isPast();
                        $isHabis = $obat->stok <= 0;
                    @endphp
                    
                    <tr class="obat-row flex flex-col md:table-row p-4 md:p-0 transition-all 
                        {{ $isExpired ? 'bg-red-500/[0.04] border-l-4 border-red-600' : '' }}" 
                        x-show="
                            (tab === 'aktif' && {{ $obat->stok }} > 0 && !{{ $isExpired ? 'true' : 'false' }}) || 
                            (tab === 'semua') || 
                            (tab === 'perlu_audit' && {{ $isExpired ? 'true' : 'false' }} && {{ $obat->stok }} > 0) ||
                            (tab === 'arsip' && {{ $obat->stok }} <= 0)
                        ">
                        
                        <td class="px-2 md:px-8 py-2 md:py-6">
                            <div class="flex items-start gap-3">
                                <div>
                                    <div class="font-bold text-slate-200 text-base tracking-tight leading-tight">{{ $obat->nama_obat }}</div>
                                    <div class="text-[10px] text-slate-600 mt-1 font-mono uppercase tracking-widest italic">Barcode: {{ $obat->kode_barcode ?? 'N/A' }}</div>
                                </div>
                                <div class="flex gap-1">
                                    @if($isExpired) <span class="bg-red-600 text-white text-[8px] px-2 py-0.5 rounded-full font-black uppercase shadow-lg shadow-red-900/40">Expired</span> @endif
                                    @if($isHabis) <span class="bg-slate-700 text-slate-300 text-[8px] px-2 py-0.5 rounded-full font-black uppercase">Archived</span> @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-2 md:px-6 py-2 md:py-6 flex justify-between md:table-cell items-center">
                            <span class="md:hidden text-[10px] font-black text-slate-500 uppercase tracking-widest">Stok</span>
                            <div class="text-center">
                                <span class="px-3 py-1 rounded-xl text-xs md:text-sm font-black {{ $obat->stok < 10 ? 'bg-red-500/10 text-red-500' : 'bg-slate-800 text-slate-400' }}">
                                    {{ $obat->stok }}
                                </span>
                            </div>
                        </td>

                        <td class="px-2 md:px-6 py-2 md:py-6 flex justify-between md:table-cell items-center text-xs font-bold text-right md:text-center">
                            <span class="md:hidden text-[10px] font-black text-slate-500 uppercase tracking-widest mr-auto">Kadaluarsa</span>
                            <span class="{{ $isExpired ? 'text-red-500' : 'text-slate-400' }}">
                                {{ $obat->tgl_kadaluarsa ? \Carbon\Carbon::parse($obat->tgl_kadaluarsa)->format('d/m/Y') : 'N/A' }}
                            </span>
                        </td>

                        <td class="px-2 md:px-8 py-4 md:py-6">
                            {{-- PROTEKSI ROLE ADMIN DI KOLOM AKSI --}}
                            @if(auth()->user()->role == 'admin')
                                <template x-if="tab === 'perlu_audit'">
                                    <form action="{{ route('obat.musnahkan', $obat->id) }}" method="POST" class="flex items-center gap-2 w-full md:justify-end">
                                        @csrf
                                        <select name="alasan" class="flex-1 md:flex-none md:w-40 text-[11px] bg-slate-950 border border-orange-500/30 text-orange-100 rounded-xl px-4 py-3 md:py-2.5 outline-none font-bold" required>
                                            <option value="" disabled selected>Alasan...</option>
                                            <option value="Dimusnahkan (Dibuang)">🗑️ Dimusnahkan</option>
                                            <option value="Retur ke Supplier">📦 Retur Supplier</option>
                                        </select>
                                        <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white p-3 md:p-2.5 rounded-xl transition-all shadow-lg active:scale-90 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </template>

                                <template x-if="tab !== 'perlu_audit'">
                                    <div class="flex gap-2 w-full md:justify-end">
                                        @if($isHabis)
                                            <span class="text-[9px] text-slate-700 font-bold uppercase italic px-4">Audit Record</span>
                                        @else
                                            <a href="/obat/edit/{{ $obat->id }}" class="flex-1 md:flex-none flex justify-center items-center p-3.5 md:p-2.5 bg-slate-800 text-slate-400 rounded-xl border border-slate-700/50 hover:bg-emerald-600 hover:text-white transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </a>
                                            <form action="/obat/hapus/{{ $obat->id }}" method="post" class="flex-1 md:flex-none">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-full flex justify-center items-center p-3.5 md:p-2.5 bg-slate-800 text-slate-400 rounded-xl border border-slate-700/50 hover:bg-rose-600 transition-all" onclick="return confirm('Hapus permanen?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </template>
                            @else
                                {{-- JIKA KASIR: TAMPILKAN LABEL SAJA --}}
                                <div class="flex justify-end italic text-slate-600 text-[10px] uppercase font-bold tracking-widest">
                                    Read Only
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection