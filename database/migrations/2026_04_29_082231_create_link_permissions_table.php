<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // TABEL BARU: Penjaga Pintu Akses Email
        Schema::create('link_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->string('allowed_email'); // Email yang dikasih izin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_permissions');
    }
};