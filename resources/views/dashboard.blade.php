@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8">

    <header class="mb-8 md:mb-10 px-2">
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white italic uppercase">Insight Bisnis</h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base">Selamat bekerja! Berikut adalah performa apotek Anda hari ini.</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 mb-10">
        <div class="stat-card relative overflow-hidden bg-slate-900 p-6 rounded-3xl border border-slate-800 group">
            <div class="absolute -right-4 -top-4 bg-emerald-500/10 h-24 w-24 rounded-full transition-transform group-hover:scale-150 duration-500"></div>
            <div class="relative">
                <p class="text-slate-500 text-sm font-black uppercase tracking-widest mb-1">Total Pendapatan</p>
                <h3 class="text-2xl md:text-3xl font-bold text-white tracking-tighter">Rp {{ number_format($total_pendapatan) }}</h3>
                <div class="mt-4 flex items-center text-emerald-400 text-[10px] font-black uppercase tracking-tighter">
                    <span class="bg-emerald-500/10 px-2 py-1 rounded-lg">Live Update</span>
                </div>
            </div>
        </div>

        <div class="stat-card relative overflow-hidden bg-slate-900 p-6 rounded-3xl border border-slate-800 group">
            <div class="absolute -right-4 -top-4 bg-blue-500/10 h-24 w-24 rounded-full transition-transform group-hover:scale-150 duration-500"></div>
            <div class="relative">
                <p class="text-slate-500 text-sm font-black uppercase tracking-widest mb-1">Transaksi Hari Ini</p>
                <h3 class="text-2xl md:text-3xl font-bold text-white tracking-tighter">{{ $transaksi_hari_ini }} <span class="text-sm font-normal text-slate-500 lowercase">Orders</span></h3>
                <div class="mt-4 flex items-center text-blue-400 text-[10px] font-black uppercase tracking-tighter">
                    <span class="bg-blue-500/10 px-2 py-1 rounded-lg">Performa Stabil</span>
                </div>
            </div>
        </div>

        <div class="stat-card relative overflow-hidden bg-slate-900 p-6 rounded-3xl border border-slate-800 group sm:col-span-2 lg:col-span-1">
            <div class="absolute -right-4 -top-4 bg-purple-500/10 h-24 w-24 rounded-full transition-transform group-hover:scale-150 duration-500"></div>
            <div class="relative">
                <p class="text-slate-500 text-sm font-black uppercase tracking-widest mb-1">Total Katalog</p>
                <h3 class="text-2xl md:text-3xl font-bold text-white tracking-tighter">{{ $total_obat }} <span class="text-sm font-normal text-slate-500 lowercase">Obat</span></h3>
                <div class="mt-4 flex items-center text-purple-400 text-[10px] font-black uppercase tracking-tighter">
                    <a href="/obat" class="hover:underline flex items-center gap-1">Kelola Stok <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden border border-slate-800">
        <div class="p-6 md:p-8 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950/20">
            <div>
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    Inventory Alert
                </h2>
                <p class="text-xs text-slate-500 mt-1">Obat-obatan dengan stok kritis (dibawah 10 unit)</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-950/50">
                    <tr class="text-left text-slate-500 text-[10px] md:text-xs uppercase tracking-[0.2em]">
                        <th class="px-6 md:px-8 py-5">Nama Produk</th>
                        <th class="px-6 md:px-8 py-5 text-center">Sisa Unit</th>
                        <th class="px-6 md:px-8 py-5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @forelse($stok_rendah as $s)
                    <tr class="hover:bg-slate-800/30 transition-colors group">
                        <td class="px-6 md:px-8 py-5">
                            <div class="font-bold text-slate-200 group-hover:text-emerald-400 transition-colors">{{ $s->nama_obat }}</div>
                            <div class="text-[10px] text-slate-500 mt-1 font-mono uppercase">SKU: #MED-{{ $s->id }}</div>
                        </td>
                        <td class="px-6 md:px-8 py-5 text-center">
                            <span class="bg-red-500/10 text-red-500 font-black px-3 py-1 rounded-full text-xs">
                                {{ $s->stok }}
                            </span>
                        </td>
                        <td class="px-6 md:px-8 py-5 text-right">
                            <a href="/obat/edit/{{ $s->id }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2 rounded-xl text-xs font-black hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-900/40 uppercase tracking-tighter">
                                ⚡ Restok
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-16 text-center">
                            <div class="flex flex-col items-center opacity-30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="font-medium text-slate-500 italic">Semua stok aman dan terkendali.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection