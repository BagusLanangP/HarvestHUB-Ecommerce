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
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id')->unsigned();
            $table->unsignedBigInteger('cart_id')->unsigned();
            $table->unsignedBigInteger('qty')->default(0);
            $table->decimal('harga', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('produk_id')->references('id')->on('products');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_details');
    }
};
