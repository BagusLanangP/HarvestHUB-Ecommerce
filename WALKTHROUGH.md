# Walkthrough: Backend Refactoring & Features

This document provides an overview of the recent backend implementations and tests created for HarvestHUB-Ecommerce.

## 1. Authentication & Seeders Optimization
* **UserSeeder**: Refactored to use dynamic `Hash::make()` for plain-text password definitions, improving readability and security practices.
* **Feature Tests (`AuthTest.php`)**: Added robust tests covering both successful and failed scenarios for `register` and `login` functionalities using `RefreshDatabase`.
* **Factory Update**: Handled missing non-nullable fields like `phone` within `UserFactory.php` to prevent integrity constraint violations during testing.

## 2. Image Management System (Intervention Image)
A robust system for handling product images was implemented.

* **Intervention Image v3 Integration**: Integrated `intervention/image` to automatically crop and resize uploaded product photos to a standard `800x800px` resolution before saving. This ensures consistency across the UI and saves bandwidth.
* **Default Fallback Logic**: Added an Eloquent Accessor `getImageUrlAttribute()` to the `Product` model. If a product does not have an image, it automatically falls back to `default-product.png`.
* **Automatic Deletion**: The `DashboardProductController` now cleans up storage by deleting the old image when a product is updated, and deletes the image when a product is deleted from the database.
* **Feature Tests (`ProductImageUploadTest.php`)**: Added an automated test simulating a user uploading a product photo to guarantee the Intervention Image resizing and `public` disk storage function perfectly.

## 13. Redesain Premium Halaman & Form "Tulis Ulasan" Produk

- **Tata Letak Terpusat & Fokus (Centered Layout)**:
  - Memosisikan panel penulisan ulasan tepat di tengah layar (`col-md-8 col-lg-6 mx-auto`) dalam kartu elegan berbayangan tebal (`review-card`).
  - Menampilkan kartu ringkasan produk belanja (`product-summary-card`) di atas form, yang menyertakan foto produk bershadow, nama produk, nomor invoice pesanan, serta tautan identitas nama toko resmi.
- **Glowing Star Rating Selector yang Interaktif**:
  - Mengganti elemen dropdown pilihan rating konvensional menjadi 5 bintang emas raksasa (`bi-star` berukuran `2.5rem`) yang sangat interaktif.
  - **Efek Sorot Hover & Klik**: Menyusun skrip JavaScript responsif agar bintang-bintang di sebelah kiri otomatis menyala (*golden glow*) dengan bayangan berpendar saat diarahkan kursor (*hover highlight*). Mengeklik bintang akan mengunci rating dan menampilkan status keterangan ulasan yang dinamis (contoh: "Sangat Bagus! 😍").
- **Validasi Tombol & Kolom Komentar Modern**:
  - Menyediakan kolom komentar ulasan teks (`comment`) berdesain modern dengan sudut lengkung dan placeholder yang informatif.
  - Tombol **Kirim Ulasan** dinonaktifkan (disabled) secara bawaan dan hanya akan aktif begitu pembeli telah memilih minimal 1 bintang, mencegah kesalahan penyerahan data ulasan kosong secara sengaja.
- **Adaptasi Sempurna Mode Gelap (Dark Mode)**:
  - Seluruh komponen riwayat transaksi, badge status, list grup, modal konfirmasi, teks nama toko, dan tombol aksi WhatsApp beradaptasi 100% secara otomatis dengan kontras tinggi saat mode malam diaktifkan.

## 14. Redesain Total Dashboard HarvestHUB Premium (Admin & Penjual)

- **Transformasi Kustom CSS Modern (`public/css/dashboard.css`)**:
  - Mereset total gaya css dashboard yang kaku menjadi visualisasi yang sangat modern, mengimplementasikan font **Poppins & Outfit** secara konsisten.
  - Merancang layout menu sidebar dengan desain kapsul melayang (*rounded pill*) dan efek mikro-animasi geser (*hover translate-X and icon scale*).
  - Menyusun ulang borders dan spacing tabel-tabel daftar agar loose/spaced (tidak lagi rapat/kaku) dengan baris bersudut lengkung dan tombol badge kustom.
- **Header Glassmorphic & Dropdown Profil (`layouts/header.blade.php`)**:
  - Mendesain ulang header navigasi atas bershadow tipis dengan inisial avatar pengguna, detail peran (*Administrator* atau *Shop Owner*), serta integrasi dropdown menu keluar yang fungsional.
  - Menyediakan form pencarian di header dengan desain pill yang bersih.
- **Sidebar Kapsul & Tombol Beranda Utama (`layouts/sidebar.blade.php`)**:
  - Mengganti seluruh ikon bawaan yang kaku menjadi **Bootstrap Icons** modern yang seragam.
  - Menyematkan menu jalan pintas **"Keluar ke Toko"** dengan latar belakang light-gray di bagian bawah sidebar untuk navigasi cepat kembali ke beranda e-commerce utama.
- **Layout Master Dashboard Adaptif (`layouts/main.blade.php`)**:
  - Menambahkan styling global khusus di dalam master layout untuk transisi halus warna latar belakang, scrollbar melengkung estetik, dan perbatasan kartu form.
- **Diferensiasi Khusus Dashboard Super Admin vs Pemilik Toko (`dashboard/index.blade.php`)**:
  - **Dashboard Super Admin (Visual Royal Blue)**:
    - Menyajikan banner selamat datang dengan gradien biru kerajaan premium (`linear-gradient(135deg, #0d6efd, #1e3d59)`) khusus penanda hak akses tertinggi.
    - Menghitung secara riil **4 Kartu Metrik**: Total Pengguna terdaftar, Total Produk global, Total Transaksi global, dan Total Pendapatan finansial HarvestHUB global.
    - Menampilkan panel kiri berisi produk global terbaru, dan panel kanan berisi **Antrean Pengajuan Upgrade Role** lengkap dengan form aksi cepat **Setujui** & **Tolak** terintegrasi.
  - **Dashboard Pemilik Toko (Visual Organic Green)**:
    - Menyajikan banner selamat datang dengan gradien hijau pertanian HarvestHUB (`linear-gradient(135deg, #198754, #2c4d3d)`).
    - Menghitung secara riil **3 Kartu Metrik**: Total Produk Toko, Total Pesanan masuk ke Toko, dan Total Hasil Tani Terjual (pcs) khusus tokonya saja.
    - Menampilkan panel kiri berisi katalog produk toko terbaru, dan panel kanan berisi daftar **Pesanan Toko Terbaru** untuk memudahkan penjual memantau pesanan masuk.
- **Dukungan Dark Mode Dinamis**:
  - Seluruh komponen sidebar, header, tabel list, trix editor, kartu metrik, welcome banner, dan dropdown beradaptasi 100% secara instan dengan kontras tinggi saat mode malam diaktifkan.

## 15. Perbaikan Bug SQL ONLY_FULL_GROUP_BY pada Dashboard Toko

- **Masalah SQLSTATE[42000]**:
  - Saat pengguna dengan role **Pemilik Toko / Penjual** (`role_id == 5`) mengakses halaman `/dashboard`, sistem mengalami error `SQLSTATE[42000]: Syntax error or access violation: 1055`. Hal ini terjadi karena MySQL strict mode (`ONLY_FULL_GROUP_BY`) melarang pemilihan kolom non-agregat (seperti `cart_details.id` dan kolom lainnya) ketika menggunakan klausa `groupBy('transactions.id')` tanpa mendaftarkan kolom-kolom tersebut ke dalam klausa `GROUP BY`.
- **Pendekatan Refactoring Menggunakan `pluck()->distinct()`**:
  - **Kueri Metrik & Pesanan Masuk Terbaru**:
    - Alih-alih melakukan query join yang rumit dengan `groupBy` pada model `Transaction`, kita terlebih dahulu memisahkan proses pengambilan data dengan mengambil daftar ID transaksi yang unik (*distinct ID*) yang berisi produk dari toko penjual yang bersangkutan:
      ```php
      $tokoTransactionIds = \App\Models\Transaction::join('orders', 'transactions.order_id', '=', 'orders.id')
          ->join('carts', 'orders.cart_id', '=', 'carts.id')
          ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
          ->join('products', 'cart_details.produk_id', '=', 'products.id')
          ->where('products.toko_id', $toko->id)
          ->distinct()
          ->pluck('transactions.id')
          ->toArray();
      ```
    - Dengan metode ini, SELECT list SQL hanya mengambil kolom tunggal `transactions.id` dengan filter `distinct`, sehingga sepenuhnya kompatibel dengan aturan strict mode MySQL tanpa memicu error `ONLY_FULL_GROUP_BY`.
  - **Metrik Total Pesanan**:
    - Dihitung secara aman dan cepat menggunakan fungsi bawaan PHP `count($tokoTransactionIds)`.
  - **Kueri Pesanan Terbaru**:
    - Pesanan masuk terbaru diambil menggunakan `whereIn('id', $tokoTransactionIds)` yang dikombinasikan dengan metode *eager loading* relation `with('order')` untuk mengambil data transaksi beserta rincian pesanan pembelinya dengan aman dan optimal.
- **Pembaruan Kode Tampilan UI**:
  - Mengubah pemanggilan nama penerima pesanan pada tabel pesanan masuk terbaru di baris tampilan (`resources/views/dashboard/index.blade.php`) menjadi `{{ $order->order->nama_penerima ?? $order->nama_penerima ?? 'Pembeli' }}`. Ini menjamin data penerima dari relasi `order` yang telah di-eager load dapat ditampilkan dengan sempurna dan aman dari potensi error *null pointer*.

## 16. Perbaikan dan Penyelarasan Tabel Produk di Dashboard

- **Penyelesaian Bug Perbedaan Kolom (Kolom Mismatch)**:
  - Pada halaman manajemen produk di dashboard (`resources/views/dashboard/product/index.blade.php`), terdapat ketidaksesuaian jumlah kolom antara header table (`<thead>` memiliki 5 kolom: *Id Produk, Name, Kategori, Harga, Action*) dengan isi baris table (`<tbody>` hanya memiliki 3 kolom td). Hal ini terjadi karena kolom data **Kategori** dan **Harga** sebelumnya dalam kondisi dinonaktifkan/dikomentari (`{{-- ... --}}`).
  - Kami telah mengaktifkan kembali kolom **Kategori** dan **Harga** dengan tata letak visual modern, mengembalikan simetri kolom table menjadi tepat 5 kolom di header dan data baris.
- **Pemuatan Gambar Produk Premium dengan Fallback**:
  - Mengganti tag gambar manual `<img src="{{ asset('storage/' . $product->foto) }}">` yang kaku dan rawan pecah/error jika path kosong, dengan pemanggilan accessor dinamis premium `{{ $product->image_url }}` yang telah terintegrasi dengan Intervention Image serta fallback otomatis ke berkas gambar bawaan `default-product.png` yang bersih jika gambar kosong.
  - Gambar dikonfigurasi menggunakan rasio aspek yang rapi (`width: 50px; height: 50px; object-fit: cover;`) dengan border melengkung halus (`rounded-3`) dan bayangan lembut (`shadow-xs`) untuk tampilan premium.
- **Format Keuangan Rupiah (IDR)**:
  - Menyajikan data kolom harga dalam format rupiah standar nasional: `Rp {{ number_format($product->harga, 0, ',', '.') }}` dengan gaya tipografi hijau kontras (`text-success fw-bold`).
- **Modernisasi Aksi & Ikon Aksi**:
  - Mendesain ulang tombol aksi edit, hapus, dan lihat menjadi berbentuk tombol pil modern Bootstrap dengan ikon bawaan yang seragam dan tooltip yang deskriptif.
- **Perbaikan Relasi `kategori()` pada Model `Product.php`**:
  - Memperbaiki bug definisi relasi `kategori` pada model `Product.php` dari `belongsTo(ProductCategory::class, 'id')` menjadi `belongsTo(ProductCategory::class, 'category_id')`. Perubahan kunci asing (foreign key) ke `category_id` menjamin relasi pemanggilan nama kategori produk (`$product->kategori->productName`) terbaca dengan akurat dari database.
- **Penyelarasan Bayangan (Table Card Shadow) & Kontainer Premium**:
  - Membungkus tabel produk ke dalam kontainer kartu tanpa border bershadow modern (`card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white`) yang membuat tabel tampak melayang premium dan kontras tinggi. Model pembungkus ini juga secara otomatis mendukung adaptasi Dark Mode.
- **Optimasi Ukuran Tombol Aksi Toolbar (Share, Export, This Week)**:
  - Merampingkan ukuran tombol Share, Export, dan dropdown "This week" di bagian atas halaman dengan membatasi ukuran teks (`font-size: 0.78rem`), menggunakan *padding* yang proporsional, serta menambahkan ikon Bootstrap yang fungsional (`bi-share`, `bi-download`, `bi-calendar3`) sehingga toolbar terlihat ringkas, estetis, dan tidak memakan ruang visual.
- **Integrasi Tombol Tambah Produk & Flash Alert Modern**:
  - Memindahkan rute tombol "Tambah Produk" dari tengah halaman ke dalam satu kesatuan baris toolbar aksi kanan atas, memberikan visualisasi alur navigasi satu pintu (*one-stop navigation toolbar*).
  - Menyematkan desain box alert modern untuk notifikasi flash session success (`alert-success`) dengan latar belakang transparan-hijau organik bersudut lengkung (`rounded-4 border-0 shadow-xs`) untuk menghadirkan umpan balik interaksi yang menyenangkan bagi pengguna.

## 17. Perbaikan Error status_pembayaran Default pada Livewire Checkout

- **Masalah SQLSTATE[HY000] Error 1364**:
  - Saat pengguna menekan tombol "Checkout" pada keranjang belanja, Livewire memproses pemisahan keranjang (*split cart*) untuk memisahkan produk yang dicentang (yang akan dicheckout) dengan produk yang tidak dicentang (yang tetap di keranjang). Proses ini membuat entri keranjang belanja sementara baru (`status_cart => temp`) menggunakan perintah `Cart::create(...)`.
  - Dikarenakan kolom `status_pembayaran` di dalam tabel `carts` didefinisikan sebagai kolom wajib yang tidak boleh kosong (*not null*) dan tidak memiliki nilai bawaan (*default value*) pada skema database migrasi, proses pembuatan keranjang sementara gagal dan memicu error `SQLSTATE[HY000]: General error: 1364 Field 'status_pembayaran' doesn't have a default value`.
- **Solusi Penambahan Parameter Default**:
  - Kami telah memodifikasi logika pembuatan keranjang belanja sementara (`$tempCart`) pada fungsi `proceedToCheckout` di dalam berkas [CartComponent.php](file:///Users/baguslanangpurbhawa/Documents/PROJECT/WEB/HarvestHUB-Ecommerce/app/Livewire/CartComponent.php).
  - Sekarang, perintah pembuatan keranjang menyertakan parameter `'status_pembayaran' => 'belum'` secara eksplisit, yang selaras dengan nilai standar inisiasi pembayaran di seluruh sistem HarvestHUB. Perubahan ini secara instan mengatasi kendala error 1364 dan memungkinkan proses checkout berjalan dengan mulus tanpa hambatan.

## 18. Perbaikan URL & Redesain Premium Kategori pada Beranda Utama

- **Penyelesaian Bug Routing 404 (Salah URL)**:
  - Tautan menu kategori pada halaman beranda utama (`resources/views/home/index.blade.php`) sebelumnya mengarah ke `{{ url('kategori/' . $k->id) }}` yang tidak didefinisikan dalam berkas rute (`routes/web.php`), sehingga memicu error **404 Not Found**. 
  - Kami telah memperbaiki tautan tersebut agar mengarah ke rute resmi `/home/kategori/{id}` (`{{ url('home/kategori/' . $k->id) }}`) sehingga navigasi rincian kategori hasil tani berjalan sempurna.
- **Visualisasi Premium Kategori Persegi Panjang**:
  - Menyajikan desain kartu kategori persegi panjang yang proporsional sesuai dengan arahan visual Anda. Gambar kategori diletakkan di dalam kontainer berukuran proporsional (`width: 100%; height: 110px; object-fit: cover;`) lengkap dengan sudut melengkung modern (`rounded-3`) dan bayangan lembut (`shadow-xs`) untuk tampilan premium.
- **Font Kategori & Data Produk Dinamis**:
  - Memperkecil dan merapikan tipografi nama kategori menggunakan font **Outfit** (`font-size: 0.88rem; font-weight: bold;`) untuk menghadirkan kesan yang ringkas dan modern.
  - Menambahkan baris lencana dinamis (*dynamic badge*) di bawah nama kategori untuk menampilkan jumlah produk terdaftar pada masing-masing kategori secara *real-time* via relasi Eloquent (`{{ $k->produk->count() }} Produk`).
- **Mikro-animasi Interaktif & Grid Responsif**:
  - Menyematkan transisi CSS kustom (`transform: translateY(-5px)`) dan perbesaran ikon (`scale(1.06)`) saat kursor mengarah (*hover*) ke kartu kategori.
  - Memanfaatkan grid dinamis Bootstrap (`col-6 col-sm-4 col-md-3 col-lg-2`) agar tata letak kategori responsif dan rapi di semua perangkat (menampilkan 6 item per baris di komputer, 4 di tablet, dan 2 di perangkat seluler).

## 19. Perbaikan Bug & Redesain Premium Manajemen User / Customer (Admin Sidebar)

- **Penyelesaian Bug Routing 404 pada Update User**:
  - Sebelumnya, form aksi pada halaman edit user (`resources/views/dashboard/user/edit.blade.php`) menggunakan parameter ID (`{{ route('user.update', $user->id) }}`). Hal ini bertabrakan dengan setelan route key model `User.php` yang menggunakan kolom `slug` (`getRouteKeyName() => 'slug'`), sehingga memicu error **404 Model Not Found** saat admin menyimpan hasil edit.
  - Kami telah memperbaiki form action tersebut agar memuat parameter slug (`{{ route('user.update', $user->slug) }}`), sehingga proses penyimpanan update user dari admin berjalan dengan lancar dan lolos uji unit test (`✓ admin can update user`).
- **Optimalisasi Kolom & Penyajian Data Pendukung Lengkap**:
  - Di halaman daftar utama `/dashboard/user`, kami merestrukturisasi tabel agar menampilkan seluruh data pendukung yang Anda minta: **Nama/Username, Email, No. Telepon, Alamat, Role ID & Role Name, serta Status Akun**.
  - Tabel dibungkus dalam kontainer berbayangan mewah tanpa border (`card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white`) yang sangat adaptif dalam mode malam (dark mode).
- **Redesain Detail Profil User Premium (`view.blade.php`)**:
  - Menyelesaikan total error *column mismatch* (di mana tabel sebelumnya memiliki 6 header namun hanya memiliki 5 kolom di body tanpa baris aksi).
  - Kami merombak total visual halaman rincian detail user menjadi bentuk **User Profile Details Card** terpusat yang mewah, lengkap dengan inisial avatar sirkuler bershadow, grid detail yang bersih, lencana status akun, serta baris tombol aksi melengkung (Edit, Ban, Backup, Kembali) yang interaktif.

## 20. Redesain Premium Halaman Formulir Pengajuan Upgrade Role

- **Pengaturan Batas Jarak Melayang (Navbar Overlap Safety)**:
  - Menyematkan `padding-top: 100px !important;` pada area penampung utama container untuk memastikan visual form pengajuan tidak terhalang atau tertutup oleh bilah navbar utama yang melayang (*fixed top navbar*).
- **Visualisasi Kartu Gradien Organik Premium**:
  - Mengubah tampilan form pengajuan kotak abu-abu yang polos menjadi kartu bersutud bulat mewah (`card border-0 shadow rounded-4 overflow-hidden`) dengan aksen tajuk gradien hijau pertanian HarvestHUB (`linear-gradient(135deg, #198754 0%, #2c4d3d 100%)`).
  - Menyematkan simbol perisai kemitraan sirkuler (`bi-shield-shaded` di dalam lingkaran putih transparan-blur) pada kepala formulir untuk menegaskan otoritas keamanan pengajuan peningkatan role.
- **Penyaringan Pilihan Dropdown Dropdown Filter**:
  - Mengatur daftar dropdown dinamis agar memfilter dan mengecualikan role Administrator utama dari pilihan (hanya menampilkan role *Penjual, Ahli Pakar, dan Tenaga Kerja* yang relevan untuk diajukan oleh pengguna umum).
- **Tipografi & Desain Elemen Form Sleek**:
  - Menyerasikan setiap label input dengan ukuran tipografi halus yang ramah dibaca (`font-family: 'Outfit', sans-serif`).
  - Menggunakan kotak isian modern dengan warna abu-abu organik lembut yang melengkung tanpa garis tepi yang kaku, serta melengkapi tombol penyerahan data berbentuk pil bershadow hijau premium yang sangat adaptif dalam mode malam.




