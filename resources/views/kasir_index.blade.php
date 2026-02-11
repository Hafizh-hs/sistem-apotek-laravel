@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-8">
    
    <header class="mb-6 md:mb-10 px-2 text-center md:text-left">
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white italic">Terminal Kasir</h1>
        <p class="text-slate-500 mt-2 text-sm">Lengkapi pesanan pelanggan dengan cepat.</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-900 p-6 rounded-[2rem] border border-slate-800 shadow-xl">
                <h3 class="font-bold text-white mb-6 flex items-center gap-2 text-lg">
                    <span class="text-emerald-400">01.</span> Pilih Produk
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Cari Obat</label>
                        <select id="select-obat" class="w-full p-3 md:p-4 rounded-xl border border-slate-700 bg-slate-950 focus:outline-none transition-all text-white">
                            <option value="" data-harga="0" data-stok="0">-- Pilih Obat --</option>
                            @foreach($obat as $o)
                            <option value="{{ $o->id }}" data-nama="{{ $o->nama_obat }}" data-harga="{{ $o->harga_jual }}" data-stok="{{ $o->stok }}">
                                {{ $o->nama_obat }} (Stok: {{ $o->stok }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 px-1 text-white">Jumlah</label>
                            <input type="number" id="input-qty" value="1" min="1" class="w-full p-3 rounded-xl border border-slate-700 bg-slate-950 text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 px-1 text-white">Diskon</label>
                            <div class="flex">
                                <input type="number" id="input-diskon" value="0" class="w-full p-3 rounded-l-xl border border-r-0 border-slate-700 bg-slate-950 text-white">
                                <select id="jenis-diskon" class="p-3 border rounded-r-xl bg-slate-800 text-xs font-bold border-slate-700 text-white">
                                    <option value="rp">Rp</option>
                                    <option value="persen">%</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="tambahKeKeranjang()" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-emerald-900/20 transition-all active:scale-95">
                        + Tambah Item
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-900 rounded-[2rem] border border-slate-800 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900/50">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <span class="text-emerald-400 text-lg">02.</span> Item Belanja
                    </h3>
                </div>

                <div class="overflow-x-auto min-h-[200px] max-h-[400px] overflow-y-auto no-scrollbar">
                    <table class="w-full">
                        <thead class="bg-slate-950/50 sticky top-0 z-10">
                            <tr class="text-left text-slate-500 text-[10px] uppercase tracking-widest">
                                <th class="px-6 py-4">Obat</th>
                                <th class="px-4 py-4 text-center">Qty</th>
                                <th class="px-6 py-4 text-right">Subtotal</th>
                                <th class="px-4 py-4 text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="keranjang-body" class="divide-y divide-slate-800/50">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-slate-950 p-6 md:p-8 rounded-[2rem] border border-slate-800 shadow-2xl">
                <form action="/kasir/proses" method="POST" id="form-transaksi">
                    @csrf
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-2">
                        <span class="text-slate-500 font-bold uppercase tracking-widest text-[10px]">Total Tagihan:</span>
                        <span id="label-total" class="text-4xl md:text-5xl font-black text-white">Rp 0</span>
                        <input type="hidden" name="total_harga" id="input-total-harga">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="block font-bold text-emerald-400 text-xs uppercase tracking-wide px-1">Diterima (Cash)</label>
                            <input type="number" name="bayar" id="input-bayar" class="w-full p-4 rounded-2xl bg-slate-950 border-2 border-emerald-500/20 text-2xl font-bold text-white focus:border-emerald-500 transition-all" placeholder="0" oninput="hitungKembali()" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block font-bold text-slate-500 text-xs uppercase tracking-wide px-1">Kembalian</label>
                            <input type="text" id="label-kembali" class="w-full p-4 rounded-2xl bg-slate-800 border border-slate-800 text-2xl font-bold text-slate-400" readonly value="Rp 0">
                            <input type="hidden" name="kembali" id="input-kembali">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 text-white py-5 rounded-2xl font-black text-lg md:text-xl hover:bg-emerald-500 shadow-xl shadow-emerald-900/40 transition-all active:scale-95 uppercase tracking-widest">
                        Simpan & Cetak Nota
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let keranjang = [];

    function tambahKeKeranjang() {
        const select = document.getElementById('select-obat');
        const selectedOption = select.options[select.selectedIndex];
        const id = select.value;
        const nama = selectedOption.getAttribute('data-nama');
        const harga = parseFloat(selectedOption.getAttribute('data-harga'));
        const stok = parseInt(selectedOption.getAttribute('data-stok'));
        const qty = parseInt(document.getElementById('input-qty').value);
        const nilaiDiskon = parseFloat(document.getElementById('input-diskon').value) || 0;
        const jenisDiskon = document.getElementById('jenis-diskon').value;

        if (!id) return alert('Pilih obat dulu!');
        if (qty > stok) return alert('Stok tidak cukup!');

        let totalDiskonRp = (jenisDiskon === 'persen') ? (harga * qty) * (nilaiDiskon / 100) : nilaiDiskon;

        const index = keranjang.findIndex(item => item.id === id);
        if (index > -1) {
            keranjang[index].qty += qty;
            keranjang[index].diskon += totalDiskonRp;
            keranjang[index].subtotal = (keranjang[index].harga * keranjang[index].qty) - keranjang[index].diskon;
        } else {
            keranjang.push({ id, nama, harga, qty, diskon: totalDiskonRp, subtotal: (harga * qty) - totalDiskonRp });
        }
        renderKeranjang();
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function renderKeranjang() {
        const body = document.getElementById('keranjang-body');
        body.innerHTML = '';
        let total = 0;
        keranjang.forEach((item, index) => {
            total += item.subtotal;
            body.innerHTML += `
            <tr class="hover:bg-slate-800/30 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-200 text-sm">${item.nama}</div>
                    <div class="text-[10px] text-slate-500 font-mono">@Rp ${new Intl.NumberFormat().format(item.harga)}</div>
                    <input type="hidden" name="items[${index}][medicine_id]" value="${item.id}">
                </td>
                <td class="text-center font-bold text-slate-300">${item.qty}<input type="hidden" name="items[${index}][qty]" value="${item.qty}"></td>
                <td class="text-right px-6 font-bold text-white text-sm">${new Intl.NumberFormat().format(item.subtotal)}<input type="hidden" name="items[${index}][subtotal]" value="${item.subtotal}"></td>
                <td class="text-center px-4"><button type="button" onclick="hapusItem(${index})" class="text-red-500 bg-red-500/10 w-8 h-8 rounded-full flex items-center justify-center mx-auto hover:bg-red-500 hover:text-white transition-all text-xs">✕</button></td>
            </tr>`;
        });
        document.getElementById('label-total').innerText = 'Rp ' + new Intl.NumberFormat().format(total);
        document.getElementById('input-total-harga').value = total;
        hitungKembali();
    }

    function hitungKembali() {
        const total = parseFloat(document.getElementById('input-total-harga').value) || 0;
        const bayar = parseFloat(document.getElementById('input-bayar').value) || 0;
        const kembali = bayar - total;
        document.getElementById('label-kembali').value = 'Rp ' + new Intl.NumberFormat().format(kembali);
        document.getElementById('input-kembali').value = kembali;
    }
</script>
@endsection