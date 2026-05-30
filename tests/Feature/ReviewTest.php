<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Toko;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    private function createTransaction($user, $status) {
        $cart = Cart::create([
            'user_id' => $user->id,
            'status_cart' => 'checkout',
            'no_invoice' => 'INV-123',
            'status_pembayaran' => 'unpaid',
            'total' => 10000
        ]);

        $order = Order::create([
            'cart_id' => $cart->id,
            'nama_penerima' => 'John',
            'no_tlp' => '123',
            'alamat' => 'Address',
            'provinsi' => 'Prov',
            'kota' => 'Kota',
            'kecamatan' => 'Kec',
            'kelurahan' => 'Kel',
            'kodepos' => '12345'
        ]);

        return Transaction::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'status' => $status,
            'total_price' => 10000
        ]);
    }

    private function createProduct($user) {
        $toko = Toko::create([
            'user_id' => $user->id,
            'nama' => 'Test Toko ' . uniqid(),
            'email' => uniqid() . '@example.com',
            'phone' => '1234' . uniqid(),
            'alamat' => 'Alamat',
            'deskripsi' => 'Deskripsi'
        ]);
        
        $kategori = new ProductCategory();
        $kategori->productName = 'Buah';
        $kategori->save();
        
        $product = new Product();
        $product->user_id = $user->id;
        $product->toko_id = $toko->id;
        $product->category_id = $kategori->id;
        $product->name = 'Test Product';
        $product->slug = uniqid('test-product-');
        $product->harga = 50000;
        $product->description = 'Test';
        $product->save();
        
        return $product;
    }

    public function test_user_can_submit_review_for_completed_transaction()
    {
        $user = User::factory()->create();
        $product = $this->createProduct($user);
        $transaction = $this->createTransaction($user, 'Completed');

        $response = $this->actingAs($user)->post(route('review.store'), [
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great product!'
        ]);

        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('reviews', [
            'transaction_id' => $transaction->id,
            'rating' => 5
        ]);

        $this->assertEquals(5, $product->fresh()->average_rating);
    }

    public function test_user_cannot_submit_review_for_pending_transaction()
    {
        $user = User::factory()->create();
        $product = $this->createProduct($user);
        $transaction = $this->createTransaction($user, 'Pending');

        $response = $this->actingAs($user)->post(route('review.store'), [
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great product!'
        ]);

        $response->assertStatus(403);
    }
}
