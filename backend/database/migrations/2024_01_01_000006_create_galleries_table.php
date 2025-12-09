<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url'); // URL de la imagen
            $table->string('image_type')->default('image'); // image, video
            $table->string('style')->nullable(); // Estilo del tatuaje
            $table->string('body_part')->nullable(); // Parte del cuerpo
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};

