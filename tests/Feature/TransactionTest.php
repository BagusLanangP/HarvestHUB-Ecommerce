<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_user_can_view_transaction_history()
    {
        $user = User::factory()->create();
        
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

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'status' => 'Pending',
            'total_price' => 10000
        ]);

        $response = $this->actingAs($user)->get('/transaksi');
        $response->assertStatus(200);
        $response->assertSee('Riwayat Transaksi');
        $response->assertSee('Pending');
    }

    public function test_user_can_complete_transaction()
    {
        $user = User::factory()->create();
        
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

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'status' => 'Pending',
            'total_price' => 10000
        ]);

        $response = $this->actingAs($user)->patch(route('transaksi.complete', $transaction->id));
        $response->assertRedirect();
        
        $this->assertEquals('Completed', $transaction->fresh()->status);
    }
}
