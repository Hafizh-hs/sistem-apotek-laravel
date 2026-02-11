<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::table('transactions', function (Blueprint $table) {
        $table->decimal('harga_satuan_deal', 15, 2)->after('medicine_id');
        $table->decimal('diskon', 15, 2)->default(0)->after('jumlah_beli');
        $table->decimal('bayar', 15, 2)->after('total_harga');
        $table->decimal('kembali', 15, 2)->after('bayar');
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
