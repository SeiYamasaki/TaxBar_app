<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\SubscriptionPlan;
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
        DB::table('tax_advisors')->truncate();
        DB::table('subscription_plans')->truncate();
        DB::table('users')->truncate();

        // 外部キー制約を再有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // サブスクリプションプランを作成
        SubscriptionPlan::create([
            'name' => 'ベーシック',
            'description' => '基本機能のみのプラン',
            'price' => 5000,
            'duration_days' => 30,
            'features' => ['基本機能'],
        ]);

        SubscriptionPlan::create([
            'name' => 'プロフェッショナル',
            'description' => '高度な機能を含むプラン',
            'price' => 10000,
            'duration_days' => 30,
            'features' => ['基本機能', '詳細な分析', '優先サポート'],
        ]);

        // 管理者アカウントを作成
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('adminpassword'),
                'role' => 'admin',
            ]
        );

        // 一般税理士アカウントを作成
        $taxAccountant = User::firstOrCreate(
            ['email' => 'tax@example.com'],
            [
                'name' => 'Test Tax Accountant',
                'password' => Hash::make('taxpassword'),
                'role' => 'tax_advisor',
            ]
        );

        // 一般ユーザー（税理士でない人）を作成
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('userpassword'),
                'role' => 'individual',
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
