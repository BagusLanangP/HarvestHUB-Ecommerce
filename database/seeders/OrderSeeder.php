<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\AlamatPengiriman;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Review::truncate();
        Transaction::truncate();
        Order::truncate();
        CartDetail::truncate();
        Cart::truncate();
        AlamatPengiriman::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Get Customers (role_id 2)
        $customers = User::where('role_id', 2)->get();
        if ($customers->isEmpty()) {
            return;
        }

        $custMap = $customers->keyBy('name');

        // Helper to find customer safe
        $getCust = function($name) use ($custMap, $customers) {
            return $custMap->get($name) ?? $customers->first();
        };

        // 2. Seed shipping addresses for each customer
        $addressesData = [
            'Mardana' => [
                'nama_penerima' => 'Mardana',
                'no_tlp' => '085858158622',
                'alamat' => 'Jl. Mawar No. 12, Sanggulan',
                'provinsi' => 'Bali',
                'kota' => 'Tabanan',
                'kecamatan' => 'Kediri',
                'kelurahan' => 'Banjar Anyar',
                'kodepos' => '82121',
                'ongkir' => 15000,
            ],
            'Dayuani' => [
                'nama_penerima' => 'Dayuani',
                'no_tlp' => '+6282147390098',
                'alamat' => 'Jl. Gajah Mada No. 45, Gianyar Kota',
                'provinsi' => 'Bali',
                'kota' => 'Gianyar',
                'kecamatan' => 'Gianyar',
                'kelurahan' => 'Gianyar',
                'kodepos' => '80511',
                'ongkir' => 12000,
            ],
            'Nyoman Dharma' => [
                'nama_penerima' => 'Nyoman Dharma',
                'no_tlp' => '+6281234567893',
                'alamat' => 'Jl. Hayam Wuruk No. 102, Denpasar Timur',
                'provinsi' => 'Bali',
                'kota' => 'Denpasar',
                'kecamatan' => 'Denpasar Timur',
                'kelurahan' => 'Sumerta Kelod',
                'kodepos' => '80239',
                'ongkir' => 10000,
            ],
            'Gede Sukra' => [
                'nama_penerima' => 'Gede Sukra',
                'no_tlp' => '+6281234567894',
                'alamat' => 'Jl. Ngurah Rai No. 8, Singaraja',
                'provinsi' => 'Bali',
                'kota' => 'Buleleng',
                'kecamatan' => 'Buleleng',
                'kelurahan' => 'Banjar Jawa',
                'kodepos' => '81113',
                'ongkir' => 25000,
            ],
            'Kadek Lestari' => [
                'nama_penerima' => 'Kadek Lestari',
                'no_tlp' => '+6281234567895',
                'alamat' => 'Jl. Sudirman No. 34, Negara',
                'provinsi' => 'Bali',
                'kota' => 'Jembrana',
                'kecamatan' => 'Negara',
                'kelurahan' => 'Pendem',
                'kodepos' => '82218',
                'ongkir' => 30000,
            ],
        ];

        foreach ($addressesData as $name => $addr) {
            $user = $getCust($name);
            AlamatPengiriman::create(array_merge($addr, [
                'user_id' => $user->id,
                'status' => 'utama',
            ]));
        }

        // Get some products for details
        $bayam = Product::where('name', 'Bayam Segar Gianyar')->first() ?? Product::first();
        $wortel = Product::where('name', 'Wortel Hidroponik')->first() ?? Product::first();
        $cangkul = Product::where('name', 'Cangkul Baja Kuat')->first() ?? Product::first();
        $npk = Product::where('name', 'Pupuk NPK Mutiara 1kg')->first() ?? Product::first();
        $mangga = Product::where('name', 'Mangga Harum Manis Super')->first() ?? Product::first();
        $jeruk = Product::where('name', 'Jeruk Kintamani Manis 1kg')->first() ?? Product::first();
        $sapiPakan = Product::where('name', 'Pakan Sapi Konsentrat 50kg')->first() ?? Product::first();
        $telur = Product::where('name', 'Telur Ayam Kampung Isi 10')->first() ?? Product::first();
        $madu = Product::where('name', 'Madu Hutan Alami 250ml')->first() ?? Product::first();
        $susu = Product::where('name', 'Susu Sapi Segar 1L')->first() ?? Product::first();

        // 3. Create Orders / Transactions
        
        // --- ORDER 1: Mardana (Completed & Reviewed) ---
        $userMardana = $getCust('Mardana');
        $cart1 = Cart::create([
            'user_id' => $userMardana->id,
            'no_invoice' => 'INV/' . Carbon::now()->subDays(7)->format('Ymd') . '/0001',
            'status_cart' => 'checkout',
            'status_pembayaran' => 'paid',
            'no_resi' => 'RESI123456789',
            'subtotal' => 39000.00,
            'total' => 39000.00,
            'created_at' => Carbon::now()->subDays(7),
            'updated_at' => Carbon::now()->subDays(7),
        ]);

        CartDetail::create([
            'produk_id' => $bayam->id,
            'cart_id' => $cart1->id,
            'qty' => 3,
            'harga' => $bayam->harga,
            'subtotal' => 3 * $bayam->harga,
        ]);

        CartDetail::create([
            'produk_id' => $wortel->id,
            'cart_id' => $cart1->id,
            'qty' => 2,
            'harga' => $wortel->harga,
            'subtotal' => 2 * $wortel->harga,
        ]);

        $addrMardana = AlamatPengiriman::where('user_id', $userMardana->id)->first();
        $order1 = Order::create([
            'cart_id' => $cart1->id,
            'nama_penerima' => $addrMardana->nama_penerima,
            'no_tlp' => $addrMardana->no_tlp,
            'alamat' => $addrMardana->alamat . ' | Pengiriman: Diantar | Pembayaran: Cash',
            'provinsi' => $addrMardana->provinsi,
            'kota' => $addrMardana->kota,
            'kecamatan' => $addrMardana->kecamatan,
            'kelurahan' => $addrMardana->kelurahan,
            'kodepos' => $addrMardana->kodepos,
            'created_at' => Carbon::now()->subDays(7),
            'updated_at' => Carbon::now()->subDays(7),
        ]);

        $trans1 = Transaction::create([
            'user_id' => $userMardana->id,
            'order_id' => $order1->id,
            'status' => 'Completed',
            'total_price' => $cart1->total,
            'created_at' => Carbon::now()->subDays(7),
            'updated_at' => Carbon::now()->subDays(6),
        ]);

        // Review for Order 1
        Review::create([
            'user_id' => $userMardana->id,
            'product_id' => $bayam->id,
            'transaction_id' => $trans1->id,
            'rating' => 5,
            'comment' => 'Bayam sangat segar, dikemas rapi, dan cepat sampai! Recommended seller.',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);

        Review::create([
            'user_id' => $userMardana->id,
            'product_id' => $wortel->id,
            'transaction_id' => $trans1->id,
            'rating' => 4,
            'comment' => 'Wortelnya bersih dan manis. Hanya saja ada beberapa wortel yang berukuran agak kecil.',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);


        // --- ORDER 2: Dayuani (Pending) ---
        $userDayuani = $getCust('Dayuani');
        $cart2 = Cart::create([
            'user_id' => $userDayuani->id,
            'no_invoice' => 'INV/' . Carbon::now()->subDays(1)->format('Ymd') . '/0002',
            'status_cart' => 'checkout',
            'status_pembayaran' => 'belum',
            'no_resi' => null,
            'subtotal' => 111000.00,
            'total' => 111000.00,
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1),
        ]);

        CartDetail::create([
            'produk_id' => $cangkul->id,
            'cart_id' => $cart2->id,
            'qty' => 1,
            'harga' => $cangkul->harga,
            'subtotal' => $cangkul->harga,
        ]);

        CartDetail::create([
            'produk_id' => $npk->id,
            'cart_id' => $cart2->id,
            'qty' => 2,
            'harga' => $npk->harga,
            'subtotal' => 2 * $npk->harga,
        ]);

        $addrDayuani = AlamatPengiriman::where('user_id', $userDayuani->id)->first();
        $order2 = Order::create([
            'cart_id' => $cart2->id,
            'nama_penerima' => $addrDayuani->nama_penerima,
            'no_tlp' => $addrDayuani->no_tlp,
            'alamat' => $addrDayuani->alamat . ' | Pengiriman: Diantar | Pembayaran: Cash',
            'provinsi' => $addrDayuani->provinsi,
            'kota' => $addrDayuani->kota,
            'kecamatan' => $addrDayuani->kecamatan,
            'kelurahan' => $addrDayuani->kelurahan,
            'kodepos' => $addrDayuani->kodepos,
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1),
        ]);

        Transaction::create([
            'user_id' => $userDayuani->id,
            'order_id' => $order2->id,
            'status' => 'Pending',
            'total_price' => $cart2->total,
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1),
        ]);


        // --- ORDER 3: Nyoman Dharma (Completed & Reviewed) ---
        $userNyoman = $getCust('Nyoman Dharma');
        $cart3 = Cart::create([
            'user_id' => $userNyoman->id,
            'no_invoice' => 'INV/' . Carbon::now()->subDays(4)->format('Ymd') . '/0003',
            'status_cart' => 'checkout',
            'status_pembayaran' => 'paid',
            'no_resi' => 'RESI987654321',
            'subtotal' => 122000.00,
            'total' => 122000.00,
            'created_at' => Carbon::now()->subDays(4),
            'updated_at' => Carbon::now()->subDays(4),
        ]);

        CartDetail::create([
            'produk_id' => $mangga->id,
            'cart_id' => $cart3->id,
            'qty' => 2,
            'harga' => $mangga->harga,
            'subtotal' => 2 * $mangga->harga,
        ]);

        CartDetail::create([
            'produk_id' => $jeruk->id,
            'cart_id' => $cart3->id,
            'qty' => 3,
            'harga' => $jeruk->harga,
            'subtotal' => 3 * $jeruk->harga,
        ]);

        $addrNyoman = AlamatPengiriman::where('user_id', $userNyoman->id)->first();
        $order3 = Order::create([
            'cart_id' => $cart3->id,
            'nama_penerima' => $addrNyoman->nama_penerima,
            'no_tlp' => $addrNyoman->no_tlp,
            'alamat' => $addrNyoman->alamat . ' | Pengiriman: Diantar | Pembayaran: Cash',
            'provinsi' => $addrNyoman->provinsi,
            'kota' => $addrNyoman->kota,
            'kecamatan' => $addrNyoman->kecamatan,
            'kelurahan' => $addrNyoman->kelurahan,
            'kodepos' => $addrNyoman->kodepos,
            'created_at' => Carbon::now()->subDays(4),
            'updated_at' => Carbon::now()->subDays(4),
        ]);

        $trans3 = Transaction::create([
            'user_id' => $userNyoman->id,
            'order_id' => $order3->id,
            'status' => 'Completed',
            'total_price' => $cart3->total,
            'created_at' => Carbon::now()->subDays(4),
            'updated_at' => Carbon::now()->subDays(3),
        ]);

        // Review for Order 3
        Review::create([
            'user_id' => $userNyoman->id,
            'product_id' => $mangga->id,
            'transaction_id' => $trans3->id,
            'rating' => 5,
            'comment' => 'Mangganya manis legit, matang pohon dengan baik. Sangat puas belanja disini!',
            'created_at' => Carbon::now()->subDays(3),
            'updated_at' => Carbon::now()->subDays(3),
        ]);

        Review::create([
            'user_id' => $userNyoman->id,
            'product_id' => $jeruk->id,
            'transaction_id' => $trans3->id,
            'rating' => 5,
            'comment' => 'Jeruk kintamaninya segar sekali, juicy dan manis pas. Anak-anak sangat suka.',
            'created_at' => Carbon::now()->subDays(3),
            'updated_at' => Carbon::now()->subDays(3),
        ]);


        // --- ORDER 4: Gede Sukra (Cancelled) ---
        $userGede = $getCust('Gede Sukra');
        $cart4 = Cart::create([
            'user_id' => $userGede->id,
            'no_invoice' => 'INV/' . Carbon::now()->subDays(5)->format('Ymd') . '/0004',
            'status_cart' => 'checkout',
            'status_pembayaran' => 'belum',
            'no_resi' => null,
            'subtotal' => 150000.00,
            'total' => 150000.00,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);

        CartDetail::create([
            'produk_id' => $sapiPakan->id,
            'cart_id' => $cart4->id,
            'qty' => 1,
            'harga' => $sapiPakan->harga,
            'subtotal' => $sapiPakan->harga,
        ]);

        $addrGede = AlamatPengiriman::where('user_id', $userGede->id)->first();
        $order4 = Order::create([
            'cart_id' => $cart4->id,
            'nama_penerima' => $addrGede->nama_penerima,
            'no_tlp' => $addrGede->no_tlp,
            'alamat' => $addrGede->alamat . ' | Pengiriman: Diantar | Pembayaran: Cash',
            'provinsi' => $addrGede->provinsi,
            'kota' => $addrGede->kota,
            'kecamatan' => $addrGede->kecamatan,
            'kelurahan' => $addrGede->kelurahan,
            'kodepos' => $addrGede->kodepos,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);

        Transaction::create([
            'user_id' => $userGede->id,
            'order_id' => $order4->id,
            'status' => 'Cancelled',
            'total_price' => $cart4->total,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);


        // --- ORDER 5: Kadek Lestari (Active shopping cart, not checkout yet) ---
        $userKadek = $getCust('Kadek Lestari');
        $cart5 = Cart::create([
            'user_id' => $userKadek->id,
            'no_invoice' => 'INV/' . Carbon::now()->format('Ymd') . '/0005',
            'status_cart' => 'cart',
            'status_pembayaran' => 'belum',
            'no_resi' => null,
            'subtotal' => 176000.00,
            'total' => 176000.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        CartDetail::create([
            'produk_id' => $telur->id,
            'cart_id' => $cart5->id,
            'qty' => 2,
            'harga' => $telur->harga,
            'subtotal' => 2 * $telur->harga,
        ]);

        CartDetail::create([
            'produk_id' => $madu->id,
            'cart_id' => $cart5->id,
            'qty' => 1,
            'harga' => $madu->harga,
            'subtotal' => $madu->harga,
        ]);

        CartDetail::create([
            'produk_id' => $susu->id,
            'cart_id' => $cart5->id,
            'qty' => 3,
            'harga' => $susu->harga,
            'subtotal' => 3 * $susu->harga,
        ]);

        // 4. Generate random, realistic reviews and transactions for ALL products
        $allProducts = Product::all();
        $commentsPool = [
            5 => [
                'Kualitas produk sangat bagus, segar, dan pengiriman cepat.',
                'Sangat puas belanja di toko ini. Seller ramah dan fast response.',
                'Produk sesuai dengan deskripsi, masih fresh pas sampai rumah.',
                'Rekomendasi banget untuk para peternak/petani lain. Kualitas top!',
                'Barang original, pengemasan rapi dan aman sekali. Bintang 5!',
            ],
            4 => [
                'Produknya bagus dan segar. Sayang pengirimannya agak lambat dari biasanya.',
                'Kualitas barang baik, sesuai harga. Berfungsi dengan normal.',
                'Respon seller cepat, barang sampai dalam kondisi utuh.',
                'Bagus, tapi ukurannya agak bervariasi ada yang besar ada yang kecil.',
                'Secara keseluruhan puas belanja disini. Terima kasih!',
            ]
        ];

        foreach ($allProducts as $product) {
            // Check if product already has reviews
            if ($product->reviews()->count() >= 2) {
                continue;
            }

            // Pick 2 random customers to review this product
            $randomCustomers = $customers->random(min(2, $customers->count()));

            foreach ($randomCustomers as $customer) {
                // Generate a unique invoice number
                $invoiceNum = 'INV/' . Carbon::now()->subDays(rand(2, 30))->format('Ymd') . '/' . sprintf('%04d', rand(1000, 9999));
                
                // 1. Create Cart
                $cart = Cart::create([
                    'user_id' => $customer->id,
                    'no_invoice' => $invoiceNum,
                    'status_cart' => 'checkout',
                    'status_pembayaran' => 'paid',
                    'no_resi' => 'RESI' . rand(100000000, 999999999),
                    'subtotal' => $product->harga * rand(1, 2),
                    'total' => $product->harga * rand(1, 2),
                    'created_at' => Carbon::now()->subDays(rand(2, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(2, 30)),
                ]);

                // 2. Create Cart Detail
                CartDetail::create([
                    'produk_id' => $product->id,
                    'cart_id' => $cart->id,
                    'qty' => rand(1, 2),
                    'harga' => $product->harga,
                    'subtotal' => $cart->total,
                ]);

                // 3. Get customer address
                $addr = AlamatPengiriman::where('user_id', $customer->id)->first();
                if (!$addr) {
                    $addr = AlamatPengiriman::create([
                        'user_id' => $customer->id,
                        'nama_penerima' => $customer->name,
                        'no_tlp' => $customer->phone ?? '08123456789',
                        'alamat' => $customer->alamat ?? 'Bali',
                        'provinsi' => 'Bali',
                        'kota' => 'Tabanan',
                        'kecamatan' => 'Kediri',
                        'kelurahan' => 'Banjar Anyar',
                        'kodepos' => '82121',
                        'ongkir' => 15000,
                        'status' => 'utama'
                    ]);
                }

                // 4. Create Order
                $order = Order::create([
                    'cart_id' => $cart->id,
                    'nama_penerima' => $addr->nama_penerima,
                    'no_tlp' => $addr->no_tlp,
                    'alamat' => $addr->alamat . ' | Pengiriman: Diantar | Pembayaran: Cash',
                    'provinsi' => $addr->provinsi,
                    'kota' => $addr->kota,
                    'kecamatan' => $addr->kecamatan,
                    'kelurahan' => $addr->kelurahan,
                    'kodepos' => $addr->kodepos,
                    'created_at' => $cart->created_at,
                    'updated_at' => $cart->updated_at,
                ]);

                // 5. Create Transaction
                $trans = Transaction::create([
                    'user_id' => $customer->id,
                    'order_id' => $order->id,
                    'status' => 'Completed',
                    'total_price' => $cart->total,
                    'created_at' => $cart->created_at,
                    'updated_at' => $cart->updated_at,
                ]);

                // 6. Create Review
                $rating = rand(4, 5);
                $comment = $commentsPool[$rating][array_rand($commentsPool[$rating])];
                Review::create([
                    'user_id' => $customer->id,
                    'product_id' => $product->id,
                    'transaction_id' => $trans->id,
                    'rating' => $rating,
                    'comment' => $comment,
                    'created_at' => $trans->created_at->addHours(rand(12, 48)),
                    'updated_at' => $trans->created_at->addHours(rand(12, 48)),
                ]);
            }
        }
    }
}
