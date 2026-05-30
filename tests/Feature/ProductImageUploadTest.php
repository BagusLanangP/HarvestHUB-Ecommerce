<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Toko;
use App\Models\ProductCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_image_upload_and_resize()
    {
        Storage::fake('public');

        $roleId = \Illuminate\Support\Facades\DB::table('roles')->insertGetId(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $roleId]);
        $toko = Toko::create([
            'user_id' => $user->id,
            'nama' => 'Toko Test',
            'deskripsi' => 'Deskripsi Toko',
            'email' => 'toko@test.com',
            'phone' => '08123456789',
            'alamat' => 'Alamat Toko'
        ]);

        $categoryId = \Illuminate\Support\Facades\DB::table('product_categories')->insertGetId([
            'productName' => 'Sayuran',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('test-product.jpg', 1200, 1000);

        $response = $this->post('/dashboard/product', [
            'name' => 'Produk Sayur',
            'slug' => 'produk-sayur',
            'category_id' => $categoryId,
            'harga' => 10000,
            'jumlah_produk' => 10,
            'description' => 'Sayur segar',
            'foto' => $file,
        ]);

        $response->assertRedirect('/dashboard/product');
        $this->assertDatabaseHas('products', [
            'name' => 'Produk Sayur'
        ]);

        $product = \App\Models\Product::where('slug', 'produk-sayur')->first();
        $this->assertNotNull($product->foto);
        
        Storage::disk('public')->assertExists($product->foto);
        
        // Assert the accessor works correctly
        $this->assertStringContainsString('storage/product-images/', $product->image_url);
    }
}
