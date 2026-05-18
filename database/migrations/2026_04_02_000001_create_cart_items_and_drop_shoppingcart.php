<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('Cart_Item_ID');
            $table->unsignedBigInteger('User_ID');
            $table->unsignedBigInteger('Product_ID');
            $table->integer('quantity')->default(1);
            $table->enum('instance', ['cart', 'wishlist'])->default('cart');
            $table->timestamps();

            $table->foreign('User_ID')->references('User_ID')->on('users')->onDelete('cascade');
            $table->foreign('Product_ID')->references('Product_ID')->on('products')->onDelete('cascade');
            $table->unique(['User_ID', 'Product_ID', 'instance']);
        });

        Schema::dropIfExists('shoppingcart');
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');

        Schema::create('shoppingcart', function (Blueprint $table) {
            $table->string('identifier');
            $table->string('instance');
            $table->longText('content');
            $table->nullableTimestamps();
            $table->primary(['identifier', 'instance']);
        });
    }
};
