<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // TABEL USERS & DESIGN
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique(); // Akan jadi Judul Halaman juga
            $table->string('email')->unique();
            $table->string('password');
            
            // Atribut Profil
            $table->string('bio')->nullable(); 
            $table->string('profile_picture')->nullable();

            // Desain Tombol (Sesuai UI dashboard kamu)
            $table->enum('button_corner_style', ['square', 'rounded', 'capsule'])->default('rounded');
            $table->enum('button_display_style', ['fill', 'outline', 'shadow'])->default('fill');
            $table->string('button_color')->default('#6366F1');
            $table->string('text_color')->default('#FFFFFF');

            // Desain Background
            $table->enum('bg_type', ['solid', 'gradient', 'image'])->default('solid');
            $table->string('bg_color')->default('#F3F4F6');
            $table->string('background_image')->nullable(); 

            // Sistem Akun
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('status', ['active', 'banned'])->default('active');
            $table->integer('violation_count')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // TABEL SESSIONS (Biar gak error lagi)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // TABEL PASSWORD RESET
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
    }
};