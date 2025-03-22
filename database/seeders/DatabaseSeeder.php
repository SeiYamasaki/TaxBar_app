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
        DB::table('themes')->truncate();

        // 外部キー制約を再有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // サブスクリプションプランを作成（新しいSeederを使用）
        $this->call(SubscriptionPlanSeeder::class);

        // 新しいUserSeederを実行
        $this->call(UserSeeder::class);

        $this->call(FaqSeeder::class);

        // テーマを追加
        $this->call(ThemeSeeder::class);

        // ユーザーとテーマの関連付けを追加
        $this->call(UserThemeSeeder::class);

        // // ✅ 動画を20件生成（税理士が投稿する）
        // Video::factory()->count(20)->create([
        //     'user_id' => 2, // 税理士ユーザーのIDを指定（UserSeederで作成したユーザーの順序に対応）
        // ]);

        // ✅ `tax_advisors` テーブルにデータを追加
        // $this->call(TaxAdvisorSeeder::class); // UserSeederで税理士情報も作成するため、こちらはコメントアウト
    }
}
