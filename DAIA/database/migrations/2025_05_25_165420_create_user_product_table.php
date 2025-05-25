<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_product', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->unique(['user_id', 'product_id'], 'order_keys');
            $table->string('order_address');
            $table->enum('order_status', ['reserved', 'ongoing', 'delivered'])->default('reserved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_product');
    }
};
