<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleRequest;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminControlPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    private function getAdmin()
    {
        return User::factory()->create(['role_id' => Role::where('name', 'Admin')->first()->id]);
    }

    private function getUser()
    {
        return User::factory()->create(['role_id' => Role::where('name', 'user')->first()->id, 'status' => 'aktif']);
    }

    public function test_user_can_submit_role_request()
    {
        Storage::fake('public');
        $user = $this->getUser();
        $targetRole = Role::where('name', 'Penjual')->first();

        $response = $this->actingAs($user)->post(route('role_requests.store'), [
            'requested_role_id' => $targetRole->id,
            'identity_id' => '1234567890123456',
            'whatsapp' => '08123456789',
            'email' => 'user_test@gmail.com',
            'gender' => 'Laki-laki',
            'birth_date' => '1995-05-15',
            'domicile' => 'Bandung, Jawa Barat',
            'meta' => [
                'shop_name' => 'Toko Tani Jaya',
                'shop_address' => 'Jl. Sawah Hijau No. 10',
            ],
            'reason' => 'Saya ingin berjualan',
            'document' => UploadedFile::fake()->create('document.pdf', 100),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('role_requests', [
            'user_id' => $user->id,
            'requested_role_id' => $targetRole->id,
            'identity_id' => '1234567890123456',
            'whatsapp' => '08123456789',
            'email' => 'user_test@gmail.com',
            'status' => 'pending'
        ]);
    }

    public function test_admin_can_approve_role_request()
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();
        $targetRole = Role::where('name', 'Penjual')->first();

        $request = RoleRequest::create([
            'user_id' => $user->id,
            'requested_role_id' => $targetRole->id,
            'identity_id' => '1234567890123456',
            'whatsapp' => '08123456789',
            'email' => 'user_test@gmail.com',
            'gender' => 'Laki-laki',
            'birth_date' => '1995-05-15',
            'domicile' => 'Bandung, Jawa Barat',
            'metadata' => [
                'shop_name' => 'Toko Tani Jaya',
                'shop_address' => 'Jl. Sawah Hijau No. 10',
            ],
            'reason' => 'Test reason',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)->put(route('dashboard.role_requests.update', $request->id), [
            'status' => 'approved'
        ]);

        $response->assertRedirect();
        $this->assertEquals('approved', $request->fresh()->status);
        $this->assertEquals($targetRole->id, $user->fresh()->role_id);
    }

    public function test_admin_can_ban_user()
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();

        $this->assertEquals('aktif', $user->status);

        $response = $this->actingAs($admin)->patch(route('user.ban', $user->slug));

        $response->assertRedirect();
        $this->assertEquals('banned', $user->fresh()->status);

        // Test toggle back to aktif
        $this->actingAs($admin)->patch(route('user.ban', $user->slug));
        $this->assertEquals('aktif', $user->fresh()->status);
    }

    public function test_banned_user_cannot_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'status' => 'banned'
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'failed');
        $this->assertGuest();
    }

    public function test_admin_analytics_aggregates_data()
    {
        $admin = $this->getAdmin();
        
        // Create 2 new users today
        User::factory()->count(2)->create(['created_at' => Carbon::today()]);

        // Create 1 completed transaction today for 50000
        $buyer = $this->getUser();
        $cart = \App\Models\Cart::create([
            'user_id' => $buyer->id,
            'status_cart' => 'checkout',
            'no_invoice' => 'INV-TEST',
            'status_pembayaran' => 'paid',
            'total' => 50000
        ]);
        $order = \App\Models\Order::create([
            'cart_id' => $cart->id,
            'nama_penerima' => 'Test',
            'no_tlp' => '123',
            'alamat' => 'Alamat',
            'provinsi' => 'Prov',
            'kota' => 'Kota',
            'kecamatan' => 'Kec',
            'kelurahan' => 'Kel',
            'kodepos' => '12345'
        ]);
        Transaction::create([
            'user_id' => $buyer->id,
            'order_id' => $order->id,
            'status' => 'Completed',
            'total_price' => 50000,
            'created_at' => Carbon::today()
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard.analytics.index', ['period' => 'daily']));
        
        $response->assertStatus(200);
        $response->assertSee('50.000'); // Check formatted volume
        $response->assertViewHas('newRegistrations', function($count) {
            return $count >= 2; // Including $buyer and the 2 new users
        });
    }

    public function test_admin_can_update_user()
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();
        $targetRole = Role::where('name', 'Penjual')->first();

        $response = $this->actingAs($admin)->put(route('user.update', $user->slug), [
            'name' => 'Updated Name',
            'email' => 'updated_email@gmail.com',
            'phone' => '081234567890',
            'role_id' => $targetRole->id,
            'status' => 'aktif'
        ]);

        $response->assertRedirect(route('user.index'));
        $this->assertEquals('Updated Name', $user->fresh()->name);
        $this->assertEquals('updated_email@gmail.com', $user->fresh()->email);
        $this->assertEquals($targetRole->id, $user->fresh()->role_id);
    }
}
