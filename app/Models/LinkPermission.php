<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkPermission extends Model
{
    use HasFactory;


    protected $fillable = ['link_id', 'allowed_email'];

   
    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}