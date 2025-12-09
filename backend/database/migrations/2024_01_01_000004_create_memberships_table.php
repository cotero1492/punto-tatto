<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Básico, Premium, VIP
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('duration_days')->default(30); // Duración en días
            $table->integer('max_photos')->nullable(); // null = ilimitado
            $table->boolean('featured')->default(false); // Aparece destacado
            $table->boolean('priority_ranking')->default(false); // Prioridad en ranking
            $table->integer('ranking_bonus')->default(0); // Bonificación de puntos de ranking
            $table->boolean('advanced_stats')->default(false);
            $table->boolean('support_priority')->default(false);
            $table->json('features')->nullable(); // Características adicionales
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};

