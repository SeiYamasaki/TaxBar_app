<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_tax_accountant', // 追加
    ];

    protected $casts = [
        'is_tax_accountant' => 'boolean', // 型を boolean にキャスト
    ];
}
