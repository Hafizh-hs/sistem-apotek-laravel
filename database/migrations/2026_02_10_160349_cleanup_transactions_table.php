<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kita hapus kolom yang sudah pindah ke tabel detail
            $table->dropForeign(['medicine_id']); // Hapus foreign key dulu
            $table->dropColumn(['medicine_id', 'harga_satuan_deal', 'diskon', 'jumlah_beli']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
