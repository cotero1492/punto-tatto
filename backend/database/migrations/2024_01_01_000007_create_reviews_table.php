<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->json('photos')->nullable(); // Fotos del trabajo realizado
            $table->boolean('is_approved')->default(false); // Moderación admin
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['artist_id', 'client_id']); // Un cliente solo puede reseñar una vez a un artista
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

