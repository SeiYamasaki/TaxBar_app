<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_tax_accountant', 
        'tax_registration_number', 'office_name', 'profile_image', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_tax_accountant' => 'boolean',
        'is_admin' => 'boolean', // 管理者フラグを追加
    ];

    public function isTaxAccountant(): bool
    {
        return $this->is_tax_accountant;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
