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
        Schema::create('loyalty_point_transactions', function (Blueprint $table) {
            $table->id(); // Primary Key

            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            // Jika pasien dihapus, histori poinnya juga terhapus

            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            // Jika appointment dihapus, appointment_id di transaksi ini jadi NULL

            $table->string('description');
            $table->integer('points'); // Bisa positif atau negatif
            $table->timestamp('transaction_date')->useCurrent(); // Default waktu saat ini

            $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('set null');
            // Jika staf (user) yang melakukan transaksi dihapus, staff_id jadi NULL

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_point_transactions');
    }
};