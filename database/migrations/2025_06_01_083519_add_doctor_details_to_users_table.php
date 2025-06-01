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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom setelah kolom 'is_active' atau kolom terakhir yang Anda tambahkan sebelumnya
            $table->string('gender')->nullable()->after('is_active'); // Contoh: 'Laki-laki', 'Perempuan'
            $table->string('specialization')->nullable()->after('gender'); // Contoh: 'Dokter Umum', 'Dokter Gigi'
            $table->string('room')->nullable()->after('specialization'); // Contoh: 'Poli Gigi - R.101', 'Klinik Umum A'
            $table->text('availability_schedule')->nullable()->after('room'); // Contoh: "Senin-Jumat: 08:00-16:00"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'specialization', 'room', 'availability_schedule']);
        });
    }
};