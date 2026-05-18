<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Addresses Table
        $this->safeRename('addresses', 'address', 'Zone_Street_HouseNumber', "VARCHAR(255) NOT NULL");
        $this->safeRename('addresses', 'barangay', 'Barangay', "VARCHAR(255) NULL");
        $this->safeRename('addresses', 'city', 'City', "VARCHAR(255) NULL");
        $this->safeRename('addresses', 'province', 'Province', "VARCHAR(255) NULL");
        $this->safeRename('addresses', 'type', 'address_type', "ENUM('Home', 'Work') DEFAULT 'Home'");

        // Orders Table
        $this->safeRename('orders', 'status', 'order_status', "ENUM('ordered', 'delivered', 'canceled') DEFAULT 'ordered'");
        $this->safeRename('orders', 'delivered_date', 'date_delivery', "DATE NULL");
        $this->safeRename('orders', 'canceled_date', 'date_cancelled', "DATE NULL");

        // Transactions Table
        $this->safeRename('transactions', 'mode', 'payment_mode', "ENUM('cod', 'card', 'paypal') DEFAULT 'cod'");
    }

    private function safeRename($table, $oldColumn, $newColumn, $definition)
    {
        $columns = Schema::getColumnListing($table);
        
        // If old exists and new does NOT exist
        if (in_array($oldColumn, $columns) && !in_array($newColumn, $columns)) {
            DB::statement("ALTER TABLE `{$table}` CHANGE COLUMN `{$oldColumn}` `{$newColumn}` {$definition}");
        } 
        // If old exists but new ALSO exists (maybe partial rename or case diff)
        // This is a special case for case-only renames on some FS, but here we change strings too
        elseif (in_array($oldColumn, $columns) && in_array($newColumn, $columns)) {
             // Do nothing or handle if needed
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse renames if needed, but for "fix" migrations it's often okay to keep down simple
        $this->safeRename('addresses', 'Zone_Street_HouseNumber', 'address', "VARCHAR(255) NOT NULL");
        $this->safeRename('addresses', 'Barangay', 'barangay', "VARCHAR(255) NULL");
        $this->safeRename('addresses', 'City', 'city', "VARCHAR(255) NULL");
        $this->safeRename('addresses', 'Province', 'province', "VARCHAR(255) NULL");
        $this->safeRename('addresses', 'address_type', 'type', "ENUM('Home', 'Work') DEFAULT 'Home'");

        $this->safeRename('orders', 'order_status', 'status', "ENUM('ordered', 'delivered', 'canceled') DEFAULT 'ordered'");
        $this->safeRename('orders', 'date_delivery', 'delivered_date', "DATE NULL");
        $this->safeRename('orders', 'date_cancelled', 'canceled_date', "DATE NULL");

        $this->safeRename('transactions', 'payment_mode', 'mode', "ENUM('cod', 'card', 'paypal') DEFAULT 'cod'");
    }
};
