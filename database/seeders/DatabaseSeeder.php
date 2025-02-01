<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 管理者アカウントを作成
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'), // パスワードをハッシュ化
            'is_tax_accountant' => true, // 税理士フラグを有効
            'tax_registration_number' => 'TAX123456',
            'office_name' => 'Admin Tax Office',
            'profile_image' => null,
        ]);

        // 一般税理士アカウントを作成
        User::create([
            'name' => 'Test Tax Accountant',
            'email' => 'tax@example.com',
            'password' => Hash::make('taxpassword'),
            'is_tax_accountant' => true, // 税理士フラグを有効
            'tax_registration_number' => 'TAX654321',
            'office_name' => 'Test Tax Office',
            'profile_image' => null,
        ]);

        // 一般ユーザー（税理士でない人）を作成
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('userpassword'),
            'is_tax_accountant' => false, // 一般ユーザー（税理士ではない）
            'tax_registration_number' => null,
            'office_name' => null,
            'profile_image' => null,
        ]);
    }
}
