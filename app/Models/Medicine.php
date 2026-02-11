<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = ['nama_obat', 'kode_barcode', 'harga_modal', 'stok', 'harga_jual', 'tgl_kadaluarsa'];

    protected $casts = [
        'tgl_kadaluarsa' => 'date',
    ];

    public static function rules()
    {
        return [
            'nama_obat' => 'required',
            'kode_barcode' => 'required|unique:medicines,kode_barcode',
            'stok' => 'required|integer',
            'harga_jual' => 'required|numeric',
        ];
    }
}
