<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\Toko;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    private function createTokoAndUser()
    {
        $user = User::factory()->create([
            'role_id' => 5 // Penjual
        ]);

        $toko = Toko::create([
            'user_id' => $user->id,
            'nama' => 'Harvest Shop',
            'email' => 'harvest@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Kebun Raya',
            'deskripsi' => 'Toko produk pertanian organik',
            'year_started' => 2024,
            'region' => 'Bandung',
            'link_tiktok' => 'https://tiktok.com/@harvest',
            'link_ig' => 'https://instagram.com/harvest',
            'link_fb' => 'https://facebook.com/harvest'
        ]);

        return [$user, $toko];
    }

    private function createProduct($user, $toko, $name = 'Organic Apple')
    {
        $kategori = new ProductCategory();
        $kategori->productName = 'Buah';
        $kategori->save();

        $product = new Product();
        $product->user_id = $user->id;
        $product->toko_id = $toko->id;
        $product->category_id = $kategori->id;
        $product->name = $name;
        $product->slug = uniqid('product-');
        $product->harga = 25000;
        $product->description = 'Segar dan organik';
        $product->jumlah_produk = 100;
        $product->save();

        return $product;
    }

    public function test_toko_profile_displays_product_count_and_best_seller_fallback()
    {
        list($user, $toko) = $this->createTokoAndUser();

        $response = $this->actingAs($user)->get('/Toko');

        $response->assertStatus(200);
        $response->assertSee('Harvest Shop');
        $response->assertSee('Jumlah Produk');
        $response->assertSee('0 produk');
        $response->assertSee('Produk Terlaris');
        $response->assertSee('Belum ada produk terjual');
    }

    public function test_toko_profile_displays_correct_product_count()
    {
        list($user, $toko) = $this->createTokoAndUser();

        $this->createProduct($user, $toko, 'Organic Apple');
        $this->createProduct($user, $toko, 'Organic Banana');

        $response = $this->actingAs($user)->get('/Toko');

        $response->assertStatus(200);
        $response->assertSee('2 produk');
    }

    public function test_toko_profile_displays_correct_best_selling_product()
    {
        list($user, $toko) = $this->createTokoAndUser();

        $apple = $this->createProduct($user, $toko, 'Organic Apple');
        $banana = $this->createProduct($user, $toko, 'Organic Banana');

        // Create completed transaction for Organic Banana (sold 5 qty)
        $buyer = User::factory()->create();
        $cart1 = Cart::create([
            'user_id' => $buyer->id,
            'status_cart' => 'checkout',
            'no_invoice' => 'INV-001',
            'status_pembayaran' => 'paid',
            'total' => 125000
        ]);

        CartDetail::create([
            'produk_id' => $banana->id,
            'cart_id' => $cart1->id,
            'qty' => 5,
            'harga' => 25000,
            'subtotal' => 125000
        ]);

        $order1 = Order::create([
            'cart_id' => $cart1->id,
            'nama_penerima' => 'Buyer One',
            'no_tlp' => '08122334455',
            'alamat' => 'Jl. Buah Batu No. 5',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Lengkong',
            'kelurahan' => 'Cijagra',
            'kodepos' => '40265'
        ]);

        Transaction::create([
            'user_id' => $buyer->id,
            'order_id' => $order1->id,
            'status' => 'Completed',
            'total_price' => 125000
        ]);

        // Create pending transaction for Organic Apple (sold 10 qty but pending)
        $cart2 = Cart::create([
            'user_id' => $buyer->id,
            'status_cart' => 'checkout',
            'no_invoice' => 'INV-002',
            'status_pembayaran' => 'unpaid',
            'total' => 250000
        ]);

        CartDetail::create([
            'produk_id' => $apple->id,
            'cart_id' => $cart2->id,
            'qty' => 10,
            'harga' => 25000,
            'subtotal' => 250000
        ]);

        $order2 = Order::create([
            'cart_id' => $cart2->id,
            'nama_penerima' => 'Buyer One',
            'no_tlp' => '08122334455',
            'alamat' => 'Jl. Buah Batu No. 5',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Lengkong',
            'kelurahan' => 'Cijagra',
            'kodepos' => '40265'
        ]);

        Transaction::create([
            'user_id' => $buyer->id,
            'order_id' => $order2->id,
            'status' => 'Pending',
            'total_price' => 250000
        ]);

        // Banana should be best seller (5 sold in Completed transaction)
        // Apple shouldn't be best seller because its transaction status is Pending.
        $response = $this->actingAs($user)->get('/Toko');

        $response->assertStatus(200);
        $response->assertSee('Organic Banana');
        $response->assertSee('5 terjual');
        $response->assertDontSee('Organic Apple (10 terjual)');
    }
}
