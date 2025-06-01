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
        Schema::table('patients', function (Blueprint $table) {
            // user_id harus unik karena satu user hanya punya satu profil pasien
            // nullable karena mungkin ada data pasien lama yang diinput manual sebelum ada akun user
            // atau jika admin input pasien tanpa membuatkan akun user dulu
            // onDelete('cascade') berarti jika user dihapus, profil pasien terkait juga ikut terhapus
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('cascade')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Hati-hati saat rollback, pastikan nama constraint benar jika ada error
            // Nama constraint default biasanya: patients_user_id_foreign
            $table->dropForeign(['user_id']); 
            $table->dropColumn('user_id');
        });
    }
};