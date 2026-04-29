<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'status', 'violation_count', 'bio', 'profile_picture', 'background_image'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: Satu User punya banyak Link
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    // Relasi: Satu User punya banyak Log Pelanggaran
    public function violationLogs()
    {
        return $this->hasMany(ViolationLog::class);
    }
}