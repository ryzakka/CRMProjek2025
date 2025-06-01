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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('points_required'); // Poin tidak mungkin negatif
            $table->string('type'); // Contoh: 'DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT', 'FREE_SERVICE', 'MERCHANDISE'
            $table->decimal('value', 15, 2)->nullable(); // Untuk nilai moneter atau persentase, 15 digit total, 2 digit di belakang koma
            $table->integer('quantity_available')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};