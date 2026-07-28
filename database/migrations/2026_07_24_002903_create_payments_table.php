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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('transaction_id')
              ->constrained()
              ->cascadeOnDelete();

        // Nominal pembayaran
        $table->decimal('amount', 15, 2);

        // Metode pembayaran
        $table->enum('payment_method', [
            'Tunai',
            'Transfer',
            'QRIS'
        ]);

        // Tanggal pembayaran
        $table->date('payment_date');

        // Catatan
        $table->text('notes')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
