<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
    $table->id();
    $table->string('nama_obat');
    $table->string('kode_barcode')->unique();
    $table->integer('stok')->default(0);
    $table->decimal('harga_jual', 15, 2);
    $table->date('tgl_kadaluarsa');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
