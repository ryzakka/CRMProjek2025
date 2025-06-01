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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary Key

            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            // 'constrained' akan otomatis merujuk ke tabel 'patients' kolom 'id'
            // 'onDelete('cascade')' berarti jika pasien dihapus, janji temunya juga ikut terhapus

            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null');
            // Merujuk ke tabel 'users' (asumsi dokter ada di tabel users)
            // nullable() karena mungkin ada janji temu umum atau dokter belum ditentukan
            // onDelete('set null') berarti jika dokter (user) dihapus, doctor_id di janji temu ini akan jadi NULL

            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('service_description')->nullable();
            $table->string('status')->default('Dijadwalkan'); // Contoh: Dijadwalkan, Dikonfirmasi, Selesai, Dibatalkan, Tidak Hadir
            $table->text('notes')->nullable();
            $table->timestamp('survey_sent_at')->nullable(); // Untuk menandai kapan survei dikirim

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};