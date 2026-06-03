<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();
            
        
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
          
            $table->enum('button_corner_style', ['square', 'rounded', 'capsule'])->default('rounded');
            $table->enum('button_display_style', ['fill', 'outline', 'shadow'])->default('fill');
            $table->string('button_color')->default('#8129D9');
            $table->string('text_color')->default('#FFFFFF');
            $table->enum('social_position', ['top', 'bottom'])->default('bottom');

            $table->enum('bg_type', ['solid', 'gradient', 'image'])->default('solid');
            $table->string('bg_color')->default('#F3F4F6');
            $table->string('background_image')->nullable(); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_settings');
    }
};