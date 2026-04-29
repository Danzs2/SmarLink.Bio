<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'invalid_url', 'threat_type', 'detected_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}