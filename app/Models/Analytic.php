<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    use HasFactory;

    
    public $timestamps = false;

   protected $fillable = [
    'link_id', 'clicked_at'
];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}