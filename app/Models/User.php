<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 99;
    const ROLE_WORKER = 55;

    const ROLES = [
        self::ROLE_ADMIN => 'Админ',
        self::ROLE_WORKER => 'Ходим'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'login',
        'role',
        'telegram_chat_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return (int) $this->role === self::ROLE_ADMIN;
    }

    public function isWorker(): bool
    {
        return $this->isAdmin() || ((int) $this->role === self::ROLE_WORKER);
    }

    public function getRoleName(): string
    {
        return array_key_exists($this->role, self::ROLES)
            ? self::ROLES[$this->role]
            : 'Мансаб берилмаган';
    }
}
