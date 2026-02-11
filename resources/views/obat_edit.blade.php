@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8">

    <header class="mb-8 px-2 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white italic">Edit Data Obat</h1>
            <p class="text-slate-500 mt-1 text-sm md:text-base">Perbarui informasi stok dan harga katalog.</p>
        </div>
        <a href="/obat" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 text-sm font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </header>

    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-900 rounded-[2rem] border border-slate-800 shadow-2xl overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

            <form action="/obat/update/{{ $obat->id }}" method="POST" class="p-6 md:p-10 space-y-6">
                @csrf
                @method('POST')

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Nama Produk</label>
                        <input type="text" name="nama_obat" value="{{ $obat->nama_obat }}"
                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl p-4 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all font-medium"
                            placeholder="Contoh: Paracetamol 500mg" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Kode Barcode / SKU</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </span>
                            <input type="text" name="kode_barcode" value="{{ $obat->kode_barcode }}"
                                class="w-full bg-slate-950 border border-slate-800 rounded-2xl p-4 pl-12 text-white focus:border-emerald-500 outline-none transition-all font-mono text-sm uppercase"
                                required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Stok Saat Ini</label>
                        <input type="number" name="stok" value="{{ $obat->stok }}"
                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl p-4 text-white focus:border-emerald-500 outline-none transition-all font-bold text-center"
                            required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Tanggal Kadaluarsa</label>
                        <div class="relative">
                            <input type="date"
                                name="tgl_kadaluarsa"
                                value="{{ $obat->tgl_kadaluarsa }}"
                                onclick="this.showPicker()"
                                class="w-full bg-slate-950 border border-slate-800 rounded-2xl p-4 text-white focus:border-emerald-500 outline-none transition-all appearance-none cursor-pointer"
                                required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-600 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">
                            Harga Modal (Rp)
                        </label>
                        <input type="number"
                            name="harga_modal"
                            value="{{ $obat->harga_modal }}"
                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl p-4 text-slate-400 focus:border-emerald-500 outline-none transition-all font-mono"
                            required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] ml-1">
                            Harga Jual (Rp)
                        </label>
                        <input type="number"
                            name="harga_jual"
                            value="{{ $obat->harga_jual }}"
                            class="w-full bg-slate-950 border-2 border-emerald-500/20 rounded-2xl p-4 text-emerald-400 font-bold focus:border-emerald-500 outline-none transition-all shadow-lg shadow-emerald-900/10 font-mono"
                            required>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-[2] bg-emerald-600 text-slate-900 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-900/20 active:scale-95">
                        Simpan Perubahan
                    </button>
                    <a href="/obat" class="flex-1 bg-slate-800 text-slate-400 py-4 rounded-2xl font-bold uppercase tracking-widest hover:bg-slate-700 hover:text-white transition-all text-center text-sm flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection