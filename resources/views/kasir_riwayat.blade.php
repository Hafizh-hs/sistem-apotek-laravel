@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 px-2">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-white italic uppercase tracking-tighter leading-none">
                Riwayat <span class="text-emerald-500">Penjualan</span>
            </h1>
            <p class="text-slate-500 mt-2 text-sm italic font-medium">Audit transaksi dan manajemen nota pelanggan.</p>
        </div>
        <a href="/kasir" class="w-full md:w-auto flex items-center justify-center gap-2 bg-emerald-600 text-slate-900 px-6 py-3 rounded-2xl font-black hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-900/40 active:scale-95 text-xs uppercase tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Transaksi Baru
        </a>
    </div>

    <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-slate-950/50">
                    <tr class="text-slate-500 text-[10px] md:text-xs uppercase tracking-[0.2em]">
                        <th class="px-8 py-6 font-black">ID Transaksi</th>
                        <th class="px-6 py-6 font-black hidden md:table-cell">Waktu</th>
                        <th class="px-6 py-6 font-black hidden lg:table-cell">Item Terjual</th>
                        <th class="px-6 py-6 text-right font-black">Total Akhir</th>
                        <th class="px-8 py-6 text-center font-black">Nota</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-slate-800/30 transition-all group">
                        <td class="px-8 py-6">
                            <div class="font-mono font-black text-emerald-400 text-sm md:text-base tracking-tighter">
                                #TRX-{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="md:hidden text-[10px] text-slate-600 mt-1 font-bold uppercase tracking-widest">
                                {{ $r->created_at->format('d/m, H:i') }}
                            </div>
                        </td>

                        <td class="px-6 py-6 hidden md:table-cell">
                            <div class="text-slate-200 text-sm font-bold tracking-tight">{{ $r->created_at->format('d M Y') }}</div>
                            <div class="text-slate-500 text-[10px] font-mono mt-0.5">{{ $r->created_at->format('H:i') }} WIB</div>
                        </td>

                        <td class="px-6 py-6 hidden lg:table-cell">
                            <div class="max-h-16 overflow-y-auto no-scrollbar">
                                <ul class="space-y-1">
                                    @foreach($r->details as $d)
                                    <li class="text-[10px] text-slate-500 flex items-center gap-2">
                                        <span class="text-slate-300 font-black">{{ $d->jumlah }}x</span> 
                                        <span class="truncate max-w-[150px]">{{ $d->medicine->nama_obat ?? 'Produk Terhapus' }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>

                        <td class="px-6 py-6 text-right">
                            <div class="flex flex-col items-end">
                                <div class="text-emerald-400 font-black text-sm md:text-xl font-mono tracking-tighter">
                                    Rp {{ number_format($r->total_harga) }}
                                </div>
                                <div class="text-[9px] text-slate-700 font-black uppercase tracking-tighter lg:hidden">Total Lunas</div>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <a href="/kasir/nota/{{ $r->id }}" target="_blank" 
                               class="inline-flex items-center justify-center p-3 bg-slate-800 text-slate-400 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-slate-700 active:scale-90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="bg-slate-950/30 p-6 border-t border-slate-800 flex justify-between items-center text-[10px] text-slate-600 font-bold uppercase tracking-[0.2em]">
            <span>Total {{ $riwayat->count() }} Transaksi</span>
            <span class="italic text-emerald-500/30">Pharmacy History Module</span>
        </div>
    </div>
</div>
@endsection