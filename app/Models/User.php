<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'status', 'violation_count', 'bio', 'profile_picture', 'visits'])]
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

    // Relasi ke Links dan ViolationLogs tetap aman
    public function links() {
        return $this->hasMany(Link::class);
    }

    public function violationLogs() {
        return $this->hasMany(ViolationLog::class);
    }

    // TAMBAHKAN INI: Relasi 1-to-1 ke PageSetting
    public function pageSetting() {
        return $this->hasOne(PageSetting::class);
    }
}