<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_reference_number')->nullable()->after('payment_status');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY payment_mode ENUM('cod', 'card', 'paypal', 'greenpay') NOT NULL DEFAULT 'cod'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY payment_mode ENUM('cod', 'card', 'paypal') NOT NULL DEFAULT 'cod'");
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_reference_number');
        });
    }
};
