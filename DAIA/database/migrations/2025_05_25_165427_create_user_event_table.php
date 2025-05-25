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
        Schema::create('user_event', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('event_id')->constrained();
            $table->unique(['user_id', 'event_id'], 'subs_keys');
            $table->boolean('subs_notice')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_event');
    }
};
