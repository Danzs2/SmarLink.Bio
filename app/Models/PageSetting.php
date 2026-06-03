<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id', 'button_corner_style', 'button_display_style', 'button_color', 
    'text_color', 'social_position', 'bg_type', 'bg_color', 'background_image'
])]
class PageSetting extends Model
{
    // Relasi balik ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}