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
        // Drop order_items — no longer needed
        Schema::dropIfExists('order_items');
    
        // Add direct item fields to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            // total_amount already exists
        });
    }
    
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['item_name', 'quantity', 'price']);
        });
    }
};
