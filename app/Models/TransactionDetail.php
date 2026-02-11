<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'transaction_details';

    // Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'transaction_id',
        'medicine_id',
        'jumlah',
        'harga_satuan',
        'diskon_item',
        'subtotal'
    ];

    /**
     * Relasi ke Header Transaksi (Induk)
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi ke data Obat
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}