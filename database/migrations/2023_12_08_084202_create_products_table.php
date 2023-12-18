<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->unsignedBigInteger('category_id');
            $table->decimal('harga', 10, 2);
            $table->text('description');
            $table->unsignedInteger('jumlah_produk')->default(0);
            $table->string('foto')->nullable();
            $table->string('slug', 255);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('toko_id');
            $table->timestamps();

            // Tambahkan foreign key pada category_id
            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('toko_id')->references('id')->on('tokos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('products');
    }
};
