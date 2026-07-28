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

        // Nomor invoice
        $table->string('invoice')->unique();

        // Nama pelanggan (boleh kosong)
        $table->string('customer_name')->nullable();

        // Total seluruh transaksi
        $table->decimal('total', 15, 2);

        // Status pembayaran
        $table->enum('payment_status', ['Lunas', 'Belum Lunas'])
              ->default('Belum Lunas');

        // Tanggal transaksi
        $table->date('transaction_date');

        // Catatan tambahan
        $table->text('notes')->nullable();

        // Soft Delete
        $table->softDeletes();

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
