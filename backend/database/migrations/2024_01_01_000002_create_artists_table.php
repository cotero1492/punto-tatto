<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('studio_name')->nullable();
            $table->text('bio')->nullable();
            $table->json('styles')->nullable(); // ['realista', 'tradicional', 'minimalista', etc.]
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->json('working_hours')->nullable(); // Horarios de trabajo
            $table->decimal('price_per_hour', 8, 2)->nullable();
            $table->decimal('min_price', 8, 2)->nullable();
            $table->string('portfolio_url')->nullable();
            $table->json('social_media')->nullable(); // Instagram, Facebook, etc.
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_suspended')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('contacts_count')->default(0);
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->integer('ranking_score')->default(0);
            $table->integer('ranking_position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};

