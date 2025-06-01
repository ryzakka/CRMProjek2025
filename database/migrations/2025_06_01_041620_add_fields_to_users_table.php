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
            // Menambahkan kolom setelah kolom 'email' (atau kolom lain yang sudah ada)
            $table->string('role')->default('staff_front_office')->after('email'); // 'admin', 'doctor', 'staff_front_office'
            $table->string('phone_number')->nullable()->unique()->after('role');
            $table->boolean('is_active')->default(true)->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('phone_number');
            $table->dropColumn('is_active');
        });
    }
};