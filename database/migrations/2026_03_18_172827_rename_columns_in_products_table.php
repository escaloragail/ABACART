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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('id', 'Product_ID');
            $table->renameColumn('category_id', 'Category_ID');
            $table->renameColumn('name', 'product_name');
            $table->renameColumn('slug', 'product_slug');
            $table->renameColumn('description', 'product_description');
            $table->renameColumn('image', 'main_product_image');
            $table->renameColumn('images', 'sub_product_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('Product_ID', 'id');
            $table->renameColumn('Category_ID', 'category_id');
            $table->renameColumn('product_name', 'name');
            $table->renameColumn('product_slug', 'slug');
            $table->renameColumn('product_description', 'description');
            $table->renameColumn('main_product_image', 'image');
            $table->renameColumn('sub_product_images', 'images');
        });
    }
};
