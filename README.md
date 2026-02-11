# 💊 Apotek Pro - Pharmacy Management System

Apotek Pro adalah sistem manajemen apotek berbasis web yang dirancang untuk mengelola stok obat, transaksi kasir, dan laporan keuangan secara profesional. Dibangun menggunakan **Laravel 10** dan **Tailwind CSS**, sistem ini menawarkan antarmuka modern dengan fitur keamanan berbasis peran (RBAC).



## 🚀 Fitur Utama

* **Inventory Control:** Kelola stok obat, kategori, hingga masa kadaluarsa (Expired).
* **Audit System:** Fitur pemusnahan obat expired atau retur ke supplier dengan alasan yang terdokumentasi.
* **Kasir (POS):** Antarmuka penjualan yang cepat dan responsif.
* **Role Based Access Control (RBAC):**
    * **Admin:** Memiliki akses penuh (Laporan, Dashboard, Manajemen User, Edit Stok).
    * **Kasir:** Akses terbatas (Hanya untuk transaksi dan melihat stok).
* **User Management:** Admin bisa menambah, mengedit, atau menghapus akun karyawan langsung dari aplikasi.
* **Security:** Fitur ganti password mandiri bagi setiap user untuk menjaga keamanan akun.

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel 10](https://laravel.com)
* **Database:** MySQL
* **Frontend:** Tailwind CSS & Alpine.js
* **Icons:** Heroicons

## 📦 Cara Instalasi

1.  Clone repository ini:
    ```bash
    git clone [https://github.com/username-anda/nama-repo.git](https://github.com/username-anda/nama-repo.git)
    ```
2.  Masuk ke folder proyek:
    ```bash
    cd nama-proyek
    ```
3.  Install dependencies:
    ```bash
    composer install
    ```
4.  Copy file `.env.example` menjadi `.env` dan atur koneksi database:
    ```bash
    cp .env.example .env
    ```
5.  Generate key aplikasi:
    ```bash
    php artisan key:generate
    ```
6.  Migrate database (pastikan database sudah dibuat di MySQL):
    ```bash
    php artisan migrate
    ```
7.  Jalankan aplikasi:
    ```bash
    php artisan serve
    ```

---
© 2026 **Apotek Pro** - Built with Love by [Hafizh]