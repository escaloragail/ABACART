<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('greenpay_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('User_ID');
            $table->string('fullname');
            $table->string('mobile_number', 20);
            $table->string('email');
            $table->timestamps();

            $table->foreign('User_ID')->references('User_ID')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('greenpay_accounts');
    }
};
