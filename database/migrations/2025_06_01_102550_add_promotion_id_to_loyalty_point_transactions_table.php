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
        Schema::table('loyalty_point_transactions', function (Blueprint $table) {
            // Tambahkan kolom setelah kolom yang sudah ada, misalnya 'appointment_id'
            $table->foreignId('promotion_id')->nullable()->after('appointment_id')
                  ->constrained('promotions')->onDelete('set null');
            // onDelete('set null') berarti jika promosi dihapus, promotion_id di transaksi ini jadi NULL
            // Alternatifnya onDelete('cascade') jika ingin transaksi terkait ikut terhapus,
            // tapi 'set null' biasanya lebih aman untuk data transaksi.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loyalty_point_transactions', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->dropColumn('promotion_id');
        });
    }
};