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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('Address_ID')->nullable()->after('User_ID');
            $table->foreign('Address_ID')->references('Address_ID')->on('addresses')->onDelete('cascade');
            $table->dropColumn(['name', 'phone', 'locality', 'address', 'city', 'state', 'country', 'landmark', 'zip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['Address_ID']);
            $table->dropColumn('Address_ID');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('locality')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('landmark')->nullable();
            $table->string('zip')->nullable();
        });
    }
};
