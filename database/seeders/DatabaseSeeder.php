<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // テーブルをトランケート（データ削除＆IDリセット）
        DB::table('videos')->truncate();
        DB::table('users')->truncate();
        DB::table('tax_advisors')->truncate();

        // 外部キー制約を再有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 管理者アカウントを作成
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('adminpassword'),
                'is_tax_accountant' => true,
                'tax_registration_number' => 'TAX123456',
                'office_name' => 'Admin Tax Office',
                'profile_image' => null,
            ]
        );

        // 一般税理士アカウントを作成
        $taxAccountant = User::firstOrCreate(
            ['email' => 'tax@example.com'],
            [
                'name' => 'Test Tax Accountant',
                'password' => Hash::make('taxpassword'),
                'is_tax_accountant' => true,
                'tax_registration_number' => 'TAX654321',
                'office_name' => 'Test Tax Office',
                'profile_image' => null,
            ]
        );

        // 一般ユーザー（税理士でない人）を作成
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('userpassword'),
                'is_tax_accountant' => false,
                'tax_registration_number' => null,
                'office_name' => null,
                'profile_image' => null,
            ]
        );

        // ✅ 動画を20件生成（税理士が投稿する）
        Video::factory()->count(20)->create([
            'user_id' => $taxAccountant->id,
        ]);

        // ✅ `tax_advisors` テーブルにデータを追加
        $this->call(TaxAdvisorSeeder::class);
    }
}
