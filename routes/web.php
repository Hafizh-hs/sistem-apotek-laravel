<?php

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AuthController; // Pastikan ini ada
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- AREA PUBLIK (Bisa dibuka tanpa login) ---
Route::get('/login', [AuthController::class, 'halamanLogin'])->name('login');
Route::post('/login/proses', [AuthController::class, 'prosesLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

// --- AREA TERPROTEKSI (Wajib Login) ---
// --- AREA TERPROTEKSI (Wajib Login) ---
Route::middleware(['auth'])->group(function () {

    // --- KHUSUS ADMIN (Owner/Bos) ---
    // Tambahkan middleware 'role:admin' di sini
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [MedicineController::class, 'dashboard']);
        Route::get('/laporan', [MedicineController::class, 'laporan']);
        Route::delete('/obat/hapus/{id}', [MedicineController::class, 'hapus']);
        Route::post('/obat/musnahkan/{id}', [MedicineController::class, 'musnahkan'])->name('obat.musnahkan');
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users/simpan', [UserController::class, 'store']);
        Route::delete('/users/hapus/{id}', [UserController::class, 'destroy']);
    });

    // --- BISA DIAKSES ADMIN & KASIR ---
    Route::get('/obat', [MedicineController::class, 'index']);
    Route::get('/obat/tambah', [MedicineController::class, 'tambah']);
    Route::post('/obat/simpan', [MedicineController::class, 'simpan']);
    Route::get('/obat/edit/{id}', [MedicineController::class, 'edit']);
    Route::post('/obat/update/{id}', [MedicineController::class, 'update']);

    Route::get('/kasir', [MedicineController::class, 'halamanKasir']);
    Route::post('/kasir/proses', [MedicineController::class, 'prosesBayar']);
    Route::get('/kasir/nota/{id}', [MedicineController::class, 'cetakNota']);
    Route::get('/kasir/riwayat', [MedicineController::class, 'riwayat']);
    Route::get('/obat/cek-barcode/{barcode}', [MedicineController::class, 'cekBarcode']);

    Route::post('/ganti-password', [UserController::class, 'gantiPassword']);

    // Halaman Utama Redirect berdasarkan Role
    Route::get('/', function () {
        return auth()->user()->role == 'admin' ? redirect('/dashboard') : redirect('/kasir');
    });

});
