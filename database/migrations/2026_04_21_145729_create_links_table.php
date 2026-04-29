<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable(); 
            $table->string('url');
            $table->string('link_password')->nullable();
            

            $table->enum('type', ['custom', 'social'])->default('custom'); 
            $table->string('platform')->nullable(); 
            
         
            $table->integer('position')->default(0); 
            $table->boolean('is_active')->default(true);
            

            $table->boolean('is_private')->default(false); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};