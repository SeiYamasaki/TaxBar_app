<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaxAdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // まず対応するユーザーが存在するか確認し、必要なら作成
        $user = User::firstOrCreate(
            ['email' => 'yamada@example.com'],
            [
                'name' => '山田 太郎',
                'password' => Hash::make('password123'),
                'role' => 'tax_advisor',
            ]
        );

        // 基本プランを取得
        $plan = SubscriptionPlan::where('name', 'ベーシック')->first();

        if (!$plan) {
            $plan = SubscriptionPlan::create([
                'name' => 'ベーシック',
                'description' => '基本プラン',
                'price' => 5000,
                'duration_days' => 30,
                'features' => ['基本機能'],
            ]);
        }

        // 税理士プロフィールを登録
        DB::table('tax_advisors')->insert([
            [
                'user_id' => $user->id,
                'office_name' => '山田税理士事務所',
                'postal_code' => '100-0001',
                'prefecture' => '東京都',
                'address' => '千代田区1-1-1',
                'office_phone' => '03-1234-5678',
                'mobile_phone' => '090-1234-5678',
                'tax_accountant_photo' => null,
                'additional_photos' => json_encode([]),
                'subscription_plan_id' => $plan->id,
                'subscription_start_date' => now(),
                'subscription_end_date' => now()->addDays(30),
                'specialty' => '個人所得税',
                'profile_info' => '10年以上の経験を持つ税理士です。所得税を専門としています。',
                'is_tax_accountant' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
