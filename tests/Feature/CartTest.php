<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Toko;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles required by database constraints
        Role::forceCreate(['id' => 1, 'name' => 'Admin']);
        Role::forceCreate(['id' => 2, 'name' => 'user']);
        Role::forceCreate(['id' => 3, 'name' => 'Tenaga Kerja']);
        Role::forceCreate(['id' => 4, 'name' => 'Ahli Pakar']);
        Role::forceCreate(['id' => 5, 'name' => 'Penjual']);

        // Seed product categories
        ProductCategory::forceCreate(['id' => 1, 'productName' => 'Sayur', 'foto' => 'sayur.png']);
    }

    public function test_user_can_add_product_to_cart(): void
    {
        // 1. Create a seller user and their Toko
        $seller = User::create([
            'name' => 'Steven Seller',
            'email' => 'steven@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+62858581581',
            'alamat' => 'Tabanan',
            'role_id' => 5,
        ]);

        $toko = Toko::create([
            'nama' => 'Toko Steven',
            'email' => 'toko_steven@gmail.com',
            'phone' => $seller->phone,
            'alamat' => $seller->alamat,
            'deskripsi' => 'Toko pertanian resmi Steven',
            'user_id' => $seller->id,
        ]);

        // 2. Create a product
        $product = Product::create([
            'name' => 'Bayam Segar Gianyar',
            'category_id' => 1,
            'harga' => 5000.00,
            'description' => 'Bayam segar organik berkualitas tinggi.',
            'jumlah_produk' => 100,
            'foto' => 'bayam.png',
            'slug' => 'bayam-segar-gianyar',
            'toko_id' => $toko->id,
            'user_id' => $seller->id,
        ]);

        // 3. Create a buyer user
        $buyer = User::create([
            'name' => 'Bagus Buyer',
            'email' => 'bagus@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+6281234567890',
            'alamat' => 'Gianyar',
            'role_id' => 2,
        ]);

        // 4. Send POST request to add product to cart
        $response = $this->actingAs($buyer)->post('/cartdetail', [
            'produk_id' => $product->id,
        ]);

        // 5. Assertions
        // Check that database records were created correctly
        $this->assertDatabaseHas('carts', [
            'user_id' => $buyer->id,
            'status_cart' => 'cart',
        ]);

        $cart = Cart::where('user_id', $buyer->id)->first();
        $this->assertNotNull($cart);

        $this->assertDatabaseHas('cart_details', [
            'cart_id' => $cart->id,
            'produk_id' => $product->id,
            'qty' => 1,
            'subtotal' => 5000.00,
        ]);
        
        // As per the code, it currently redirects back to the home page (/).
        // We expect it to redirect back to the home page.
        $response->assertRedirect('/');
    }

    public function test_user_can_access_checkout_page(): void
    {
        // 1. Create a seller user and their Toko
        $seller = User::create([
            'name' => 'Steven Seller',
            'email' => 'steven@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+62858581581',
            'alamat' => 'Tabanan',
            'role_id' => 5,
        ]);

        $toko = Toko::create([
            'nama' => 'Toko Steven',
            'email' => 'toko_steven@gmail.com',
            'phone' => $seller->phone,
            'alamat' => $seller->alamat,
            'deskripsi' => 'Toko pertanian resmi Steven',
            'user_id' => $seller->id,
        ]);

        // 2. Create a product
        $product = Product::create([
            'name' => 'Bayam Segar Gianyar',
            'category_id' => 1,
            'harga' => 5000.00,
            'description' => 'Bayam segar organik.',
            'jumlah_produk' => 100,
            'foto' => 'bayam.png',
            'slug' => 'bayam-segar-gianyar',
            'toko_id' => $toko->id,
            'user_id' => $seller->id,
        ]);

        // 3. Create a buyer user
        $buyer = User::create([
            'name' => 'Bagus Buyer',
            'email' => 'bagus@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+6281234567890',
            'alamat' => 'Gianyar',
            'role_id' => 2,
        ]);

        // 4. Create an active cart with an item for the buyer
        $cart = Cart::create([
            'user_id' => $buyer->id,
            'no_invoice' => 'HHUB001',
            'status_cart' => 'cart',
            'status_pembayaran' => 'belum',
            'status_pengiriman' => 'belum',
            'subtotal' => 5000.00,
            'total' => 5000.00,
        ]);

        CartDetail::create([
            'cart_id' => $cart->id,
            'produk_id' => $product->id,
            'qty' => 1,
            'harga' => 5000.00,
            'subtotal' => 5000.00,
        ]);

        // 5. Send GET request to /checkout as the buyer
        $response = $this->actingAs($buyer)->get('/checkout');

        // 6. Assertions
        $response->assertStatus(200);
    }

    public function test_user_can_submit_transaction_with_address(): void
    {
        // 1. Create a seller user and their Toko
        $seller = User::create([
            'name' => 'Steven Seller',
            'email' => 'steven@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+62858581581',
            'alamat' => 'Tabanan',
            'role_id' => 5,
        ]);

        $toko = Toko::create([
            'nama' => 'Toko Steven',
            'email' => 'toko_steven@gmail.com',
            'phone' => $seller->phone,
            'alamat' => $seller->alamat,
            'deskripsi' => 'Toko pertanian resmi Steven',
            'user_id' => $seller->id,
        ]);

        // 2. Create a product
        $product = Product::create([
            'name' => 'Bayam Segar Gianyar',
            'category_id' => 1,
            'harga' => 5000.00,
            'description' => 'Bayam segar organik.',
            'jumlah_produk' => 100,
            'foto' => 'bayam.png',
            'slug' => 'bayam-segar-gianyar',
            'toko_id' => $toko->id,
            'user_id' => $seller->id,
        ]);

        // 3. Create a buyer user
        $buyer = User::create([
            'name' => 'Bagus Buyer',
            'email' => 'bagus@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+6281234567890',
            'alamat' => 'Gianyar',
            'role_id' => 2,
        ]);

        // 4. Create an address for the buyer
        $address = new \App\Models\AlamatPengiriman();
        $address->user_id = $buyer->id;
        $address->status = 'utama';
        $address->nama_penerima = 'Bagus Penerima';
        $address->no_tlp = '081234567890';
        $address->alamat = 'Gianyar Raya';
        $address->provinsi = 'Bali';
        $address->kota = 'Gianyar';
        $address->kecamatan = 'Gianyar';
        $address->kelurahan = 'Gianyar';
        $address->kodepos = '80511';
        $address->save();

        // 5. Create an active cart with an item for the buyer
        $cart = Cart::create([
            'user_id' => $buyer->id,
            'no_invoice' => 'HHUB001',
            'status_cart' => 'cart',
            'status_pembayaran' => 'belum',
            'status_pengiriman' => 'belum',
            'subtotal' => 5000.00,
            'total' => 5000.00,
        ]);

        CartDetail::create([
            'cart_id' => $cart->id,
            'produk_id' => $product->id,
            'qty' => 1,
            'harga' => 5000.00,
            'subtotal' => 5000.00,
        ]);

        // 6. Send POST request to /transaksi as the buyer
        $response = $this->actingAs($buyer)->post('/transaksi');

        // 7. Assertions
        $this->assertDatabaseHas('orders', [
            'cart_id' => $cart->id,
            'nama_penerima' => 'Bagus Penerima',
        ]);

        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'status_cart' => 'checkout',
        ]);

        // We expect it to redirect to the transaction nota/receipt page
        $transaction = \App\Models\Transaction::latest()->first();
        $response->assertRedirect('/transaksi/' . $transaction->id . '/nota');
    }

    public function test_user_cannot_submit_transaction_without_address(): void
    {
        // 1. Setup the user, product, cart etc. (without address)
        $buyer = User::create([
            'name' => 'Bagus Buyer',
            'email' => 'bagus@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '+6281234567890',
            'alamat' => 'Gianyar',
            'role_id' => 2,
        ]);

        $cart = Cart::create([
            'user_id' => $buyer->id,
            'no_invoice' => 'HHUB001',
            'status_cart' => 'cart',
            'status_pembayaran' => 'belum',
            'status_pengiriman' => 'belum',
            'subtotal' => 5000.00,
            'total' => 5000.00,
        ]);

        // 2. Send POST request
        $response = $this->actingAs($buyer)->from('/checkout')->post('/transaksi');

        // 3. Should redirect back to checkout with error
        $response->assertRedirect('/checkout');
        $response->assertSessionHas('error', 'Alamat pengiriman belum diisi');
    }
}
