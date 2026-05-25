<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add payment columns to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_mode', ['cod', 'card', 'paypal', 'greenpay'])->default('cod')->after('is_shipping_different');
            $table->enum('payment_status', ['pending', 'approved', 'declined', 'refunded'])->default('pending')->after('payment_mode');
        });

        // Migrate existing transaction data into orders
        if (Schema::hasTable('transactions')) {
            $transactions = DB::table('transactions')->get();
            foreach ($transactions as $txn) {
                DB::table('orders')->where('Order_ID', $txn->Order_ID)->update([
                    'payment_mode' => $txn->payment_mode ?? 'cod',
                    'payment_status' => $txn->status ?? 'pending',
                ]);
            }

            Schema::dropIfExists('transactions');
        }
    }

    public function down(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('Transaction_ID');
            $table->unsignedBigInteger('Order_ID');
            $table->enum('payment_mode', ['cod', 'card', 'paypal', 'greenpay'])->default('cod');
            $table->enum('status', ['pending', 'approved', 'declined', 'refunded'])->default('pending');
            $table->timestamps();
            $table->foreign('Order_ID')->references('Order_ID')->on('orders')->onDelete('cascade');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_mode', 'payment_status']);
        });
    }
};
