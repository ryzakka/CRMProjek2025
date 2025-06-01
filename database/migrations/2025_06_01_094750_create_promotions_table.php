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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Promosi
            $table->text('description')->nullable(); // Deskripsi Promosi
            $table->integer('points_awarded'); // Poin yang diberikan
            $table->date('start_date')->nullable(); // Tanggal mulai promo
            $table->date('end_date')->nullable(); // Tanggal selesai promo
            $table->string('promo_code')->nullable()->unique(); // Kode promo jika ada, harus unik
            $table->boolean('is_active')->default(true); // Status aktif promo

            // Opsional: siapa staf yang membuat promo ini
            $table->foreignId('created_by_staff_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};