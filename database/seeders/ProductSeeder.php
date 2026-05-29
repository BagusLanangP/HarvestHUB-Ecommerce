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

        // Categories match: 1 -> Sayur, 2 -> Buah, 3 -> Hewani, 4 -> Obat dan pupuk, 5 -> Peralatan, 6 -> pakan ternak
        $productsData = [
            [
                'name' => 'Bayam Segar Gianyar',
                'category_name' => 'Sayur',
                'harga' => 5000.00,
                'description' => 'Bayam segar organik berkualitas tinggi, dipetik langsung dari kebun Gianyar.',
                'jumlah_produk' => 100,
                'foto' => 'bayam.png',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Wortel Hidroponik',
                'category_name' => 'Sayur',
                'harga' => 12000.00,
                'description' => 'Wortel renyah manis ditanam secara hidroponik tanpa pestisida kimia.',
                'jumlah_produk' => 50,
                'foto' => 'wortel.png',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Apel Malang Manis',
                'category_name' => 'Buah',
                'harga' => 25000.00,
                'description' => 'Apel Malang segar pilihan dengan rasa manis keasaman yang khas.',
                'jumlah_produk' => 40,
                'foto' => 'apel.png',
                'toko_id' => $tokoSteven->id,
                'user_id' => $tokoSteven->user_id,
            ],
            [
                'name' => 'Pupuk NPK Mutiara 1kg',
                'category_name' => 'Obat dan pupuk',
                'harga' => 18000.00,
                'description' => 'Pupuk NPK 16-16-16 Mutiara sangat baik untuk pertumbuhan vegetatif maupun generatif tanaman.',
                'jumlah_produk' => 80,
                'foto' => 'pupuk-npk.png',
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Cangkul Baja Kuat',
                'category_name' => 'Peralatan',
                'harga' => 75000.00,
                'description' => 'Cangkul berbahan baja asli berkualitas tinggi, sangat kuat untuk mengolah lahan pertanian.',
                'jumlah_produk' => 15,
                'foto' => 'cangkul.png',
                'toko_id' => $tokoAdi->id,
                'user_id' => $tokoAdi->user_id,
            ],
            [
                'name' => 'Pakan Sapi Konsentrat',
                'category_name' => 'pakan ternak',
                'harga' => 150000.00,
                'description' => 'Konsentrat pakan sapi potong berkualitas tinggi untuk mempercepat penggemukan.',
                'jumlah_produk' => 25,
                'foto' => 'pakan-sapi.png',
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
