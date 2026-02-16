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
        Schema::create('music_songs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->decimal('length', 8, 2)->comment('Duration in seconds');
            $table->string('url_file', 255)->nullable();
            $table->integer('play_count')->default(0);
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->foreignId('musical_style_id')->constrained('musical_styles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_songs');
    }
};

