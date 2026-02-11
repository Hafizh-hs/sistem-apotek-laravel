<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function index()
    {
        // Ambil semua data obat dari database
        $semua_obat = Medicine::all();

        // Kirim data ke file tampilan (view)
        return view('obat_index', compact('semua_obat'));
    }

    public function tambah()
    {
        return view('obat_tambah');
    }

    public function simpan(Request $request)
    {
        // 1. Cek apakah barcode sudah ada
        $obatAda = Medicine::where('kode_barcode', $request->kode_barcode)->first();

        if ($obatAda) {
            // Jika barcode ada tapi NAMA BEDA -> Gagalkan
            if ($obatAda->nama_obat !== $request->nama_obat) {
                return redirect()->back()
                    ->withErrors(['kode_barcode' => 'Barcode ini sudah digunakan oleh produk lain: ' . $obatAda->nama_obat])
                    ->withInput();
            }

            // Jika barcode ada dan NAMA SAMA -> Tambah Stok Saja
            $obatAda->increment('stok', $request->stok);
            return redirect('/obat')->with('success', 'Produk sudah ada, stok otomatis ditambahkan!');
        }

        // 2. Jika benar-benar baru, simpan normal
        Medicine::create($request->all());
        return redirect('/obat')->with('success', 'Obat baru berhasil disimpan!');
    }

    public function edit($id)
    {
        $obat = Medicine::find($id);
        return view('obat_edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $obat = Medicine::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kode_barcode' => $request->kode_barcode,
            'harga_modal' => $request->harga_modal,
            'stok' => $request->stok,
            'harga_jual' => $request->harga_jual,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
        ]);
        return redirect('/obat')->with('success', 'Data Berhasil diupdate!');
    }

    public function hapus($id)
    {
        $obat = Medicine::findorFail($id);
        $obat->delete();
        return redirect('/obat')->with('success', 'Data berhasil dihapus!');
    }

    public function halamanKasir()
    {
        // Kita hanya tampilkan obat yang stoknya lebih dari 0
        $obat = Medicine::where('stok', '>', 0)
            ->where('tgl_kadaluarsa', '>', now())
            ->get();
        return view('kasir_index', compact('obat'));
    }

    public function prosesBayar(Request $request)
    {
        // 1. Validasi minimal: Harus ada item yang dibeli & uang bayar cukup
        if (!$request->has('items')) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        if ($request->bayar < $request->total_harga) {
            return back()->with('error', 'Uang bayar kurang!');
        }

        // Gunakan DB Transaction agar data aman
        DB::beginTransaction();

        try {
            // 2. Simpan Header Transaksi
            $transaksi = Transaction::create([
                'total_harga' => $request->total_harga,
                'bayar'       => $request->bayar,
                'kembali'     => $request->kembali,
                
            ]);

            // 3. Simpan Detail Item (Looping)
            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaksi->id,
                    'medicine_id'    => $item['medicine_id'],
                    'jumlah'         => $item['qty'],
                    'harga_satuan'   => $item['harga'],
                    'diskon_item'    => $item['diskon'],
                    'subtotal'       => $item['subtotal'],
                ]);

                // 4. Potong Stok Obat
                $obat = Medicine::find($item['medicine_id']);
                if ($obat) {
                    $obat->decrement('stok', $item['qty']);
                }
            }

            DB::commit();

            // Alihkan ke halaman nota
            return redirect('/kasir/nota/' . $transaksi->id);
        } catch (\Exception $e) {
            DB::rollback();
            // notif error jika gagal simpan
            return "Gagal menyimpan transaksi: " . $e->getMessage();
        }
    }
    public function laporan()
    {
        // Mengambil semua transaksi beserta detail dan data obatnya
        $transaksi = \App\Models\Transaction::with('details.medicine')->latest()->get();

        // 1. Total Omzet (Uang yang diterima dari pelanggan)
        $total_omzet = $transaksi->sum('total_harga');

        // 2. Hitung Total Modal & Laba Bersih
        $total_modal = 0;
        foreach ($transaksi as $t) {
            foreach ($t->details as $d) {
                if ($d->medicine) {
                    // Modal = Harga Modal Obat x Jumlah yang dibeli
                    $total_modal += ($d->medicine->harga_modal * $d->jumlah);
                }
            }
        }

        // Laba Bersih = Omzet - Total Modal
        $total_laba = $total_omzet - $total_modal;

        // 3. Nilai Stok Expired (Potensi Kerugian)
        $total_expired = \App\Models\Medicine::where('tgl_kadaluarsa', '<', now())
            ->get()
            ->sum(function ($o) {
                return $o->stok * $o->harga_modal;
            });

        return view('laporan_index', compact('transaksi', 'total_omzet', 'total_laba', 'total_expired'));
    }
    public function dashboard()
    {
        // 1. Hitung total jenis obat
        $total_obat = Medicine::count();

        // 2. Cari obat yang stoknya sisa sedikit (misal di bawah 10)
        $stok_rendah = Medicine::where('stok', '<', 10)->get();

        // 3. Hitung total pendapatan dari semua transaksi
        $total_pendapatan = \App\Models\Transaction::sum('total_harga');

        // 4. Hitung jumlah transaksi yang terjadi HARI INI saja
        $transaksi_hari_ini = \App\Models\Transaction::whereDate('created_at', today())->count();

        return view('dashboard', compact('total_obat', 'stok_rendah', 'total_pendapatan', 'transaksi_hari_ini'));
    }

    public function musnahkan(Request $request, $id)
    {
        // 1. Cari data obat
        $obat = Medicine::findOrFail($id);

        // 2. Validasi alasan harus dipilih
        $request->validate([
            'alasan' => 'required'
        ]);

        // Simpan informasi lama untuk notifikasi (opsional)
        $nama = $obat->nama_obat;
        $stok_lama = $obat->stok;

        // 3. Eksekusi: Ubah stok menjadi 0
        $obat->stok = 0;
        $obat->save();

        // 4. Catat ke log atau tabel riwayat (Sangat disarankan untuk audit medis)
        // Log::info("Obat $nama sebanyak $stok_lama unit telah dieksekusi dengan alasan: " . $request->alasan);

        return redirect()->back()->with('success', "Stok $nama telah berhasil disesuaikan (Alasan: {$request->alasan}).");
    }
    // Tambahkan ini di dalam class MedicineController
    public function cetakNota($id)
    {
        // Kita ambil transaksi, beserta details-nya, DAN beserta data medicine di dalam details tersebut
        $transaksi = \App\Models\Transaction::with('details.medicine')->findOrFail($id);

        return view('nota_cetak', compact('transaksi'));
    }

    public function riwayat()
    {
        // Mengambil transaksi terbaru beserta detail obatnya
        $riwayat = \App\Models\Transaction::with('details.medicine')->latest()->get();

        return view('kasir_riwayat', compact('riwayat'));
    }

public function cekBarcode($barcode)
{
    // Cari obat berdasarkan barcode
    $obat = \App\Models\Medicine::where('kode_barcode', $barcode)->first();

    if ($obat) {
        return response()->json([
            'success' => true,
            'nama_obat' => $obat->nama_obat,
            'harga_modal' => $obat->harga_modal,
            'harga_jual' => $obat->harga_jual,
        ]);
    }

    return response()->json(['success' => false]);
}
}
