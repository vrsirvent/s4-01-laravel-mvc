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
        Schema::create('jukebox_tokens', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['moto_1', 'moto_3', 'moto_5', 'car']);
            $table->integer('song_quantity');
            $table->float('price', 8, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jukebox_tokens');
    }
};

