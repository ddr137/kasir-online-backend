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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->restrictOnDelete();
            $table->string('trx_number')->unique();
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('pending');
            $table->decimal('total_price', 10, 2)->unsigned();
            $table->decimal('paid_amount', 10, 2)->unsigned();
            $table->decimal('change_amount', 10, 2); // Removed ->unsigned()
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
