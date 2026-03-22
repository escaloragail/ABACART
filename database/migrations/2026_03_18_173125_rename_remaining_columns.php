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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'User_ID');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('id', 'Category_ID');
            $table->renameColumn('name', 'category_name');
            $table->renameColumn('slug', 'category_slug');
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->renameColumn('id', 'Coupon_ID');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('id', 'Order_ID');
            $table->renameColumn('user_id', 'User_ID');
            $table->renameColumn('coupon_id', 'Coupon_ID');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('id', 'Order_Item_ID');
            $table->renameColumn('order_id', 'Order_ID');
            $table->renameColumn('product_id', 'Product_ID');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->renameColumn('id', 'Address_ID');
            $table->renameColumn('user_id', 'User_ID');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('id', 'Transaction_ID');
            $table->renameColumn('order_id', 'Order_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('User_ID', 'id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('Category_ID', 'id');
            $table->renameColumn('category_name', 'name');
            $table->renameColumn('category_slug', 'slug');
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->renameColumn('Coupon_ID', 'id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('Order_ID', 'id');
            $table->renameColumn('User_ID', 'user_id');
            $table->renameColumn('Coupon_ID', 'coupon_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('Order_Item_ID', 'id');
            $table->renameColumn('Order_ID', 'order_id');
            $table->renameColumn('Product_ID', 'product_id');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->renameColumn('Address_ID', 'id');
            $table->renameColumn('User_ID', 'user_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('Transaction_ID', 'id');
            $table->renameColumn('Order_ID', 'order_id');
        });
    }
};
