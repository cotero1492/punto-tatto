<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('artist_membership_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('openpay_transaction_id')->nullable();
            $table->string('openpay_subscription_id')->nullable();
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');
            $table->enum('type', ['subscription', 'one_time'])->default('subscription');
            $table->string('payment_method')->nullable(); // card, bank_account, etc.
            $table->json('metadata')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['artist_id', 'status']);
            $table->index('openpay_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

