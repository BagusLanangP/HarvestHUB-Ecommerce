# Walkthrough Perubahan: Fitur Checkout & Alamat (AJAX + Reactivity)

Dokumen ini mendokumentasikan seluruh perubahan, optimasi, dan perbaikan yang telah diterapkan pada halaman Checkout dan transaksi di Laravel HarvestHUB E-Commerce.

---

## 🌟 Fitur Baru & Perubahan Utama

### 1. Reaktivitas UI di Halaman Checkout (`checkout.blade.php`)
*   **Instan Sinkronisasi**: Menambahkan event listener JavaScript pada input fields **Nama Penerima**, **No Telp**, **Alamat Detail**, dan **Kelurahan**.
*   **Feedback Visual Langsung**: Setiap karakter yang diketik oleh pengguna di kolom input (kiri) akan langsung ter-update secara real-time pada bagian **Struk Nota / Order Summary** (kanan) tanpa reload halaman.
*   **Penyederhanaan UX**: Menghapus tombol ganda "Edit" dan "Simpan" lama yang membingungkan, dan menggantinya dengan satu tombol dinamis: **Simpan Alamat**.

### 2. Penyimpanan Alamat Asinkron (AJAX / Fetch API)
*   **Asynchronous Save**: Tombol **Simpan Alamat** sekarang memicu Fetch API secara background untuk menyimpan alamat pengguna ke database tanpa me-refresh halaman.
*   **Loading State**: Selama proses penyimpanan berlangsung, tombol akan otomatis berubah menjadi "Menyimpan..." dan dinonaktifkan (disabled) untuk mencegah double-submission.
*   **CSRF Protection**: Pengiriman data asinkron secara aman menyertakan header token CSRF Laravel (`X-CSRF-TOKEN`).

### 3. Backend Route & Controller
*   **Rute API Baru**: Menambahkan endpoint baru di `routes/web.php`:
    ```php
    Route::post('checkout/alamat', [AlamatPengirimanController::class, 'storeAjax'])->name('checkout.alamat.store');
    ```
*   **Logika Penyimpanan Pintar (`AlamatPengirimanController@storeAjax`)**:
    *   Memvalidasi input data alamat dengan ketat.
    *   Mencari apakah pengguna sudah memiliki alamat utama (`status = 'utama'`).
    *   Jika sudah ada, alamat tersebut akan di-update. Jika belum ada, alamat baru akan otomatis dibuat dengan status `'utama'`.
    *   Mengembalikan respon JSON yang sukses (`{ success: true, message: '...' }`).

### 4. Perbaikan Bug Transaksi & Model
*   **Mapping Model Order**: Memperbaiki deklarasi nama tabel di model `Order.php` dari `order` menjadi `orders` agar sinkron dengan migration database Laravel.
*   **Restorasi Redirect**: Mengembalikan logika redirect yang hilang pada `CartDetailController@store` dan `TransaksiController` untuk mencegah error blank page pasca aksi.

---

## 🧪 Pengujian & Pengetesan

### 1. Automated Feature Tests
Telah dibuatkan suite automated test komprehensif di `tests/Feature/CartTest.php` untuk memastikan keandalan alur checkout:
*   `test_user_can_add_product_to_cart`: Memastikan produk bisa masuk ke keranjang belanja.
*   `test_user_can_access_checkout_page`: Memastikan checkout page bisa dimuat tanpa error null.
*   `test_user_can_submit_transaction_with_address`: Memastikan transaksi berhasil ketika data alamat tersedia.
*   `test_user_cannot_submit_transaction_without_address`: Memastikan transaksi ditolak (validasi bekerja) jika alamat kosong.

**Hasil Test Run**:
```bash
php artisan test --filter CartTest

PASS  Tests\Feature\CartTest
✓ user can add product to cart                                         0.37s  
✓ user can access checkout page                                        0.03s  
✓ user can submit transaction with address                             0.01s  
✓ user cannot submit transaction without address                       0.01s  

Tests:    4 passed (13 assertions)
Duration: 0.52s
```

---

## 🛠️ Cara Mencobanya Secara Lokal

1. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
2. Buka halaman checkout (`/checkout`).
3. Coba isi/ubah kolom alamat di sebelah kiri, dan perhatikan teks di **Struk Nota** (sebelah kanan) akan langsung berubah secara real-time.
4. Klik tombol **Simpan Alamat**. Sistem akan menyimpan alamat Anda ke database tanpa me-refresh halaman (muncul notifikasi sukses).
5. Klik **Buat Pesanan** untuk menyelesaikan transaksi Anda dengan sukses!
