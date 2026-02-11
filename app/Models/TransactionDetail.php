<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'medicine_id',
        'jumlah',
        'harga_satuan',
        'diskon_item',
        'subtotal'
    ];

    // relasi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}