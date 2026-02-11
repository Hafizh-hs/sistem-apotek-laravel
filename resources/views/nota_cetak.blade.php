<!DOCTYPE html>
<html>

<head>
    <title>Nota #{{ $transaksi->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">CETAK</button>
        <a href="/kasir">KEMBALI KE KASIR</a>
    </div>

    <div class="text-center">
        <h3 style="margin:0">APOTEK PRO</h3>
        <p>Nota Transaksi #{{ $transaksi->id }}</p>
    </div>

    <div class="line"></div>
    @foreach($transaksi->details as $detail)
    <div style="margin-bottom: 5px;">
        <div class="flex">
            <span>{{ $detail->medicine->nama_obat ?? 'Produk Dihapus' }}</span>
        </div>
        <div class="flex" style="font-size: 11px;">
            <span>{{ $detail->jumlah }} x {{ number_format($detail->harga_satuan) }}</span>
            <span>Rp {{ number_format($detail->subtotal) }}</span>
        </div>
        @if($detail->diskon_item > 0)
        <div class="flex" style="font-size: 10px; font-style: italic;">
            <span> Diskon</span>
            <span>-Rp {{ number_format($detail->diskon_item) }}</span>
        </div>
        @endif
    </div>
    @endforeach
    <div class="line"></div>

    <div class="flex" style="font-weight: bold;">
        <span>TOTAL:</span>
        <span>Rp {{ number_format($transaksi->total_harga) }}</span>
    </div>
    <div class="flex">
        <span>Bayar:</span>
        <span>Rp {{ number_format($transaksi->bayar) }}</span>
    </div>
    <div class="flex">
        <span>Kembali:</span>
        <span>Rp {{ number_format($transaksi->kembali) }}</span>
    </div>
    <div class="line"></div>

    <p class="text-center">Terima Kasih</p>
</body>

</html>