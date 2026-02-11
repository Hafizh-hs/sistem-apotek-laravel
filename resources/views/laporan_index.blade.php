@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8">
    
    <header class="mb-8 md:mb-10 px-2">
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white italic">Laporan Keuangan</h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base">Ringkasan performa bisnis dan profitabilitas apotek Anda.</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-10">
    
    <div class="bg-slate-900 p-5 rounded-2xl shadow-xl border border-slate-800 flex items-center gap-4 group">
        <div class="bg-blue-500/10 p-3 rounded-xl transition-colors group-hover:bg-blue-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM17 21H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Omzet</p>
            <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">Rp {{ number_format($total_omzet) }}</h2>
        </div>
    </div>

    <div class="bg-slate-900 p-5 rounded-2xl shadow-xl border border-slate-800 flex items-center gap-4 group">
        <div class="bg-emerald-500/10 p-3 rounded-xl transition-colors group-hover:bg-emerald-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Laba Bersih</p>
            <h2 class="text-xl md:text-2xl font-black text-emerald-400 tracking-tight">Rp {{ number_format($total_laba) }}</h2>
        </div>
    </div>

    <div class="bg-slate-900 p-5 rounded-2xl shadow-xl border border-slate-800 flex items-center gap-4 group">
        <div class="bg-rose-500/10 p-3 rounded-xl transition-colors group-hover:bg-rose-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Resiko Expired</p>
            <h2 class="text-xl md:text-2xl font-black text-rose-400 tracking-tight">Rp {{ number_format($total_expired) }}</h2>
        </div>
    </div>

</div>

    <div class="bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden border border-slate-800">
        <div class="p-6 md:p-8 border-b border-slate-800 flex justify-between items-center bg-slate-950/20">
            <h3 class="font-bold text-white flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01" />
                </svg>
                Rincian Transaksi Terkini
            </h3>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full">
                <thead class="bg-slate-950/50">
                    <tr class="text-left text-slate-500 text-[10px] uppercase tracking-[0.2em]">
                        <th class="px-6 py-5">Tanggal & Waktu</th>
                        <th class="px-6 py-5">Item Penjualan</th>
                        <th class="px-6 py-5 text-right">Nilai Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @foreach($transaksi as $t)
                    <tr class="hover:bg-slate-800/30 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="text-slate-300 font-bold text-xs md:text-sm">{{ $t->created_at->format('d M Y') }}</div>
                            <div class="text-slate-600 text-[10px] font-mono">{{ $t->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="space-y-2">
                                @forelse($t->details as $d)
                                <div class="flex items-center gap-3 text-[11px]">
                                    <span class="text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded font-bold">{{ $d->jumlah }}x</span>
                                    <span class="text-slate-400 font-medium">{{ $d->medicine->nama_obat ?? 'N/A' }}</span>
                                    <span class="text-slate-600 ml-auto font-mono">Rp{{ number_format($d->subtotal) }}</span>
                                </div>
                                @empty
                                <span class="text-slate-600 italic text-[11px]">Data tidak tersedia</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="text-white font-black text-sm md:text-base">
                                Rp {{ number_format($t->total_harga) }}
                            </div>
                            <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest">TRX-{{ $t->id }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection