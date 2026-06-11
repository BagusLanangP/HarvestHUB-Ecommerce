<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Get or create a Toko for our Sellers (role_id 5)
        $sellers = User::where('role_id', 5)->get();

        if ($sellers->isEmpty()) {
            // In case no sellers exist, let's fallback to some user or create one
            $seller = User::create([
                'name' => 'Steven Seller',
                'email' => 'steven@gmail.com',
                'password' => bcrypt('password123'),
                'phone' => '+62858581581',
                'alamat' => 'Tabanan',
                'role_id' => 5,
            ]);
            $sellers = collect([$seller]);
        }

        foreach ($sellers as $seller) {
            $toko = Toko::where('user_id', $seller->id)->first();
            if (!$toko) {
                $toko = Toko::create([
                    'nama' => 'Toko ' . $seller->name,
                    'email' => 'toko_' . strtolower(str_replace(' ', '', $seller->name)) . '@gmail.com',
                    'phone' => $seller->phone,
                    'alamat' => $seller->alamat,
                    'deskripsi' => 'Toko pertanian resmi milik ' . $seller->name,
                    'foto' => 'default-shop.png',
                    'user_id' => $seller->id,
                ]);
            }
        }

        // 2. Get all categories
        $categories = ProductCategory::all();
        if ($categories->isEmpty()) {
            // Seed categories if empty
            $this->call(ProductCategorySeeder::class);
            $categories = ProductCategory::all();
        }

        // 3. Setup some realistic product data
        $tokoSteven = Toko::whereHas('user', function($q) { $q->where('email', 'steven@gmail.com'); })->first() ?? Toko::first();
        $tokoAdi = Toko::whereHas('user', function($q) { $q->where('email', 'adi_s@gmail.com'); })->first() ?? Toko::first();
        $tokoWayan = Toko::whereHas('user', function($q) { $q->where('email', 'wayantani@gmail.com'); })->first() ?? Toko::first();

        // Categories match: 1 -> Sayur, 2 -> Buah, 3 -> Hewani, 4 -> Obat dan pupuk, 5 -> Peralatan, 6 -> pakan ternak
        $productsData = [
            // SAYUR (Toko Steven)
            [
                'name' => 'Pokcoy Sawi Segar',
                'category_name' => 'Sayur',
                'harga' => 6000.00,
                'description' => 'Sawi pakcoy hidroponik segar bebas hama, renyah dan bergizi tinggi.',
                'jumlah_produk' => 60,
                'foto' => 'product-images/pokcoi.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Wortel Hidroponik Bedugul',
                'category_name' => 'Sayur',
                'harga' => 12000.00,
                'description' => 'Wortel renyah manis ditanam secara hidroponik tanpa pestisida kimia.',
                'jumlah_produk' => 50,
                'foto' => 'product-images/wortel.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Daun Bawang Gianyar',
                'category_name' => 'Sayur',
                'harga' => 4500.00,
                'description' => 'Daun bawang segar organik cocok untuk pelengkap masakan dan tumisan.',
                'jumlah_produk' => 75,
                'foto' => 'product-images/daunbawang.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Bawang Putih Kintamani',
                'category_name' => 'Sayur',
                'harga' => 28000.00,
                'description' => 'Bawang putih lokal berkualitas tinggi dengan aroma yang tajam dan khas.',
                'jumlah_produk' => 40,
                'foto' => 'product-images/bawangputih.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Jagung Manis Organik',
                'category_name' => 'Sayur',
                'harga' => 7000.00,
                'description' => 'Jagung manis segar dipetik langsung dari kebun Bedugul, rasa manis alami.',
                'jumlah_produk' => 90,
                'foto' => 'product-images/jagung.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Ubi Ungu Bedugul 1kg',
                'category_name' => 'Sayur',
                'harga' => 9000.00,
                'description' => 'Ubi ungu manis kaya serat dan vitamin cocok untuk dikukus atau olahan kue.',
                'jumlah_produk' => 110,
                'foto' => 'product-images/ubiungu.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Jahe Emprit Segar 500g',
                'category_name' => 'Sayur',
                'harga' => 15000.00,
                'description' => 'Jahe emprit lokal dengan rasa pedas yang mantap untuk jamu dan bumbu dapur.',
                'jumlah_produk' => 35,
                'foto' => 'product-images/jahe.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],

            // BUAH (Toko Wayan)
            [
                'name' => 'Anggur Hitam Manis 1kg',
                'category_name' => 'Buah',
                'harga' => 35000.00,
                'description' => 'Anggur hitam manis segar tanpa biji dengan kandungan air melimpah.',
                'jumlah_produk' => 25,
                'foto' => 'product-images/anggur.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Buah Naga Merah Manis 1kg',
                'category_name' => 'Buah',
                'harga' => 18000.00,
                'description' => 'Buah naga merah organik super manis, kaya serat dan antioksidan alami.',
                'jumlah_produk' => 45,
                'foto' => 'product-images/buahnaga.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Durian Montong Bali Super',
                'category_name' => 'Buah',
                'harga' => 85000.00,
                'description' => 'Durian montong Bali dengan daging tebal manis legit, aroma harum memikat.',
                'jumlah_produk' => 12,
                'foto' => 'product-images/durian.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Kiwi Gold Impor Segar',
                'category_name' => 'Buah',
                'harga' => 42000.00,
                'description' => 'Kiwi Gold pilihan kaya vitamin C, rasa manis menyegarkan.',
                'jumlah_produk' => 20,
                'foto' => 'product-images/kiwi.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Leci Segar Kintamani',
                'category_name' => 'Buah',
                'harga' => 30000.00,
                'description' => 'Buah leci lokal Kintamani yang manis, harum, dan dipetik dalam kondisi prima.',
                'jumlah_produk' => 30,
                'foto' => 'product-images/leci.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Lemon Lokal Segar 1kg',
                'category_name' => 'Buah',
                'harga' => 20000.00,
                'description' => 'Lemon lokal berkualitas dengan kandungan air asam menyegarkan untuk detoks.',
                'jumlah_produk' => 50,
                'foto' => 'product-images/lemon.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Manggis Manis Tabanan 1kg',
                'category_name' => 'Buah',
                'harga' => 24000.00,
                'description' => 'Manggis manis segar dengan daging putih bersih dan kulit tebal pelindung nutrisi.',
                'jumlah_produk' => 40,
                'foto' => 'product-images/manggis.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],
            [
                'name' => 'Pisang Kepok Kuning 1 Sisir',
                'category_name' => 'Buah',
                'harga' => 15000.00,
                'description' => 'Pisang kepok kuning matang pohon, sangat cocok untuk digoreng atau dikukus.',
                'jumlah_produk' => 30,
                'foto' => 'product-images/pisang.jpg',
                'toko_id' => $tokoWayan->id,
                'user_id' => $tokoWayan->user_id,
            ],

            // HEWANI (Toko Steven)
            [
                'name' => 'Daging Ayam Fillet 1kg',
                'category_name' => 'Hewani',
                'harga' => 45000.00,
                'description' => 'Fillet dada ayam segar higienis tanpa tulang dan kulit, siap olah.',
                'jumlah_produk' => 25,
                'foto' => 'product-images/ayamfillet.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Daging Ayam Utuh Bersih',
                'category_name' => 'Hewani',
                'harga' => 38000.00,
                'description' => 'Ayam broiler karkas utuh tanpa cakar dan kepala, bersih dan higienis.',
                'jumlah_produk' => 30,
                'foto' => 'product-images/ayamutuh.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Telur Ayam Kampung Isi 10',
                'category_name' => 'Hewani',
                'harga' => 27000.00,
                'description' => 'Telur ayam kampung asli kaya nutrisi, diproduksi dari peternakan ayam umbaran organik.',
                'jumlah_produk' => 40,
                'foto' => 'product-images/telur.jpg',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],

            // OBAT DAN PUPUK (Toko Adi)
            [
                'name' => 'Pupuk NPK Cair 03 1L',
                'category_name' => 'Obat dan pupuk',
                'harga' => 32000.00,
                'description' => 'Pupuk cair formulasi khusus untuk memaksimalkan fase pertumbuhan vegetatif tanaman hias dan sayur.',
                'jumlah_produk' => 80,
                'foto' => 'product-images/pupuk03.jpg',
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Pupuk Booster Pembuahan',
                'category_name' => 'Obat dan pupuk',
                'harga' => 45000.00,
                'description' => 'Pupuk khusus pembungaan dan pembuahan tanaman hortikultura agar hasil panen lebat manis.',
                'jumlah_produk' => 45,
                'foto' => 'product-images/pupukbooster.jpg',
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Pupuk Kompos Organik Halus',
                'category_name' => 'Obat dan pupuk',
                'harga' => 15000.00,
                'description' => 'Pupuk kompos kambing fermentasi halus tidak berbau, siap pakai untuk media tanam.',
                'jumlah_produk' => 100,
                'foto' => 'product-images/pupukcompos1.jpg',
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Pupuk Organik Cair Penyubur',
                'category_name' => 'Obat dan pupuk',
                'harga' => 28000.00,
                'description' => 'Cairan penyubur akar dan daun tanaman hias dan kebun sayuran organik.',
                'jumlah_produk' => 60,
                'foto' => 'product-images/pupukorganic.jpg',
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],

            // PERALATAN (Toko Adi)
            [
                'name' => 'Cangkul Baja Kuat',
                'category_name' => 'Peralatan',
                'harga' => 75000.00,
                'description' => 'Cangkul berbahan baja asli berkualitas tinggi, sangat kuat untuk mengolah lahan pertanian.',
                'jumlah_produk' => 15,
                'foto' => null,
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Gunting Stek Ranting Dahan',
                'category_name' => 'Peralatan',
                'harga' => 45000.00,
                'description' => 'Gunting dahan tajam dengan mata pisau baja karbon dan pegangan ergonomis berlapis karet anti-slip.',
                'jumlah_produk' => 25,
                'foto' => null,
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Gembor Penyiram Maspion 5L',
                'category_name' => 'Peralatan',
                'harga' => 38000.00,
                'description' => 'Alat penyiram tanaman berbahan plastik tebal anti pecah dengan kepala pancuran stainless steel halus.',
                'jumlah_produk' => 20,
                'foto' => null,
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],

            // PAKAN TERNAK (Toko Adi)
            [
                'name' => 'Pakan Sapi Konsentrat 50kg',
                'category_name' => 'pakan ternak',
                'harga' => 150000.00,
                'description' => 'Konsentrat pakan sapi potong berkualitas tinggi untuk mempercepat penggemukan.',
                'jumlah_produk' => 25,
                'foto' => null,
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Pakan Ayam Broiler BR-1 10kg',
                'category_name' => 'pakan ternak',
                'harga' => 95000.00,
                'description' => 'Pakan ayam broiler fase starter berkualitas dengan kandungan protein dan nutrisi tinggi untuk tumbuh kembang optimal.',
                'jumlah_produk' => 30,
                'foto' => null,
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Dedak Padi Halus Super 25kg',
                'category_name' => 'pakan ternak',
                'harga' => 80000.00,
                'description' => 'Bekatul / dedak padi halus murni hasil penggilingan modern, kaya serat dan karbohidrat untuk pakan ternak.',
                'jumlah_produk' => 40,
                'foto' => null,
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ]
        ];

        foreach ($productsData as $prod) {
            $category = ProductCategory::where('productName', 'like', $prod['category_name'])->first();
            if ($category) {
                Product::create([
                    'name' => $prod['name'],
                    'category_id' => $category->id,
                    'harga' => $prod['harga'],
                    'description' => $prod['description'],
                    'jumlah_produk' => $prod['jumlah_produk'],
                    'foto' => $prod['foto'],
                    'slug' => Str::slug($prod['name']),
                    'toko_id' => $prod['toko_id'],
                    'user_id' => $prod['user_id'],
                ]);
            }
        }
    }
}
