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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id(); // Primary Key

            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            // Jika pasien dihapus, patient_id jadi NULL (jika feedback ingin disimpan)
            // Atau onDelete('cascade') jika feedback terkait pasien harus ikut hilang

            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            // Jika appointment dihapus, appointment_id jadi NULL

            $table->string('type'); // 'SURVEY_POST_VISIT', 'GENERAL_FEEDBACK', 'COMPLAINT', 'SUGGESTION'

            $table->unsignedTinyInteger('rating_overall_experience')->nullable(); // Skala 1-5
            $table->unsignedTinyInteger('rating_doctor_performance')->nullable(); // Skala 1-5
            $table->unsignedTinyInteger('rating_staff_friendliness')->nullable(); // Skala 1-5
            $table->unsignedTinyInteger('rating_facility_cleanliness')->nullable(); // Skala 1-5

            $table->text('comment')->nullable();
            $table->timestamp('submitted_at')->useCurrent();

            $table->string('status_penanganan')->nullable(); // 'BARU', 'DIPROSES', 'SELESAI'
            $table->text('catatan_tindak_lanjut')->nullable();

            $table->foreignId('staff_id_penanggung_jawab')->nullable()->constrained('users')->onDelete('set null');
            // Staf yang menangani feedback

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};