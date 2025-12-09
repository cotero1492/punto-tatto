<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('openpay_subscription_id')->nullable();
            $table->enum('status', ['active', 'cancelled', 'expired', 'pending'])->default('pending');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_memberships');
    }
};

