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
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // Primary Key, Auto Increment (BigInt unsigned)
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('email')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable(); // Bisa juga enum jika pilihannya terbatas
            $table->text('address')->nullable();
            $table->date('registration_date');
            $table->integer('total_loyalty_points')->default(0);
            $table->text('preferences_notes')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};