<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
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
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
            'is_tax_accountant' => true,
            'tax_registration_number' => 'TAX123456',
            'office_name' => 'Admin Tax Office',
            'profile_image' => null,
        ]);

        // 一般税理士アカウントを作成
        $taxAccountant = User::create([
            'name' => 'Test Tax Accountant',
            'email' => 'tax@example.com',
            'password' => Hash::make('taxpassword'),
            'is_tax_accountant' => true,
            'tax_registration_number' => 'TAX654321',
            'office_name' => 'Test Tax Office',
            'profile_image' => null,
        ]);

        // 一般ユーザー（税理士でない人）を作成
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('userpassword'),
            'is_tax_accountant' => false,
            'tax_registration_number' => null,
            'office_name' => null,
            'profile_image' => null,
        ]);

        // ✅ 動画を20件生成（税理士が投稿する）
        Video::factory()->count(20)->create([
            'user_id' => $taxAccountant->id, // 税理士アカウントが投稿者
        ]);
    }
}
