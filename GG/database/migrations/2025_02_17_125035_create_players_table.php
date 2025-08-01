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
        Schema::create('players', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name', 30)->unique();
            $table->string('twitter');
            $table->string('instagram');
            $table->string('twitch');
            $table->string('avatar')->nullable();
            $table->boolean('visible')->default(false);
            $table->string('position');
            $table->integer('age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
