@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-8 animate-in fade-in duration-700">
    <div class="mb-10 px-2">
        <h1 class="text-3xl md:text-5xl font-black text-white italic uppercase tracking-tighter">
            Entry <span class="text-emerald-500">Stok</span>
        </h1>
    </div>

    <div class="bg-slate-900/50 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-slate-800 p-6 md:p-12 relative">
        <form action="/obat/simpan" method="POST" id="formObat">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kode Barcode</label>
                    <input type="text" name="kode_barcode" id="input_barcode"
                        oninput="cariObatOtomatis(this.value)"
                        class="w-full bg-slate-950 border border-slate-800 text-slate-200 p-4 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-mono"
                        placeholder="Scan atau ketik..." autofocus required autocomplete="off">
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Produk</label>
                    <input type="text" name="nama_obat" id="input_nama"
                        class="w-full bg-slate-950 border border-slate-800 text-slate-200 p-4 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Harga Modal</label>
                    <input type="number" name="harga_modal" id="input_modal" class="w-full bg-slate-950 border border-slate-800 text-emerald-500 font-black p-4 rounded-2xl outline-none" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Harga Jual</label>
                    <input type="number" name="harga_jual" id="input_jual" class="w-full bg-slate-950 border border-slate-800 text-emerald-400 font-black p-4 rounded-2xl outline-none" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Stok Masuk</label>
                    <input type="number" name="stok" id="input_stok" class="w-full bg-slate-950 border border-slate-800 text-slate-200 p-4 rounded-2xl outline-none font-bold" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 text-emerald-400">Tanggal Expired</label>
                    <input type="date" name="tgl_kadaluarsa" onclick="this.showPicker()" class="w-full bg-slate-950 border border-slate-800 text-slate-200 p-4 rounded-2xl outline-none font-bold text-xs uppercase cursor-pointer" required>
                </div>
            </div>

            <div class="mt-12 flex flex-col md:flex-row gap-4 border-t border-slate-800 pt-8">
                <button type="submit" id="btnSimpan" class="flex-[2] bg-emerald-600 text-slate-900 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-400 transition-all active:scale-95 shadow-lg">
                    Simpan Data Obat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function cariObatOtomatis(barcode) {
        barcode = barcode.trim();
        console.log("Mendeteksi Barcode: " + barcode);

        //    filter barcode
        if (barcode.length >= 1) {
            const urlBasis = "{{ url('/obat/cek-barcode') }}";
            const urlLengkap = urlBasis + "/" + barcode;

            console.log("Mengirim request ke: " + urlLengkap);

            fetch(urlLengkap)
                .then(response => {
                    console.log("Status Koneksi: " + response.status);
                    if (!response.ok) throw new Error('Data tidak ditemukan');
                    return response.json();
                })
                .then(data => {
                    console.log("Respon Database:", data);

                    if (data.success) {
                        document.getElementById('input_nama').value = data.nama_obat;
                        document.getElementById('input_modal').value = data.harga_modal;
                        document.getElementById('input_jual').value = data.harga_jual;

                        // Fokus otomatis ke stok agar admin cepat kerjanya
                        document.getElementById('input_stok').focus();

                        // Beri tanda warna hijau pada border nama agar tahu data ditemukan
                        document.getElementById('input_nama').style.borderColor = "#10b981";
                    } else {
                        // Jika tidak ketemu, kosongkan kolom nama agar tidak tertukar dengan barang sebelumnya
                        document.getElementById('input_nama').value = "";
                        document.getElementById('input_modal').value = "";
                        document.getElementById('input_jual').value = "";
                        document.getElementById('input_nama').style.borderColor = "";
                    }
                })
                .catch(err => {
                    console.log("Belum ada data untuk barcode ini.");
                });
        }
    }
</script>
@endsection