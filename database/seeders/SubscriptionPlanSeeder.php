<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 既存のプランを削除
        SubscriptionPlan::truncate();

        // 外部キー制約を再有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 法人向けプラン
        $corporatePlans = [
            [
                'name'                   => 'ゴールドプラン',
                'price'                  => 50000,   // 月額
                'zoom_meeting_duration'  => 40,      // ミーティング時間
                'description'            => 'ゴールドプラン - 月額50,000円',
                'duration_days'          => 365,     // 1年
                'features'               => [
                    'contractDuration'       => '1年',    // 契約期間
                    'openTime'               => '40分',   // 開店時間/1回
                    'openCountPerMonth'      => '5回',    // 開店回数/月
                    'tipping'                => '有',     // 投銭機能
                    'specialGuest'           => '無',     // スペシャルゲスト適用
                    'taxMinutesPost'         => '通常投稿OK',                          // TaxMinutes投稿
                    'videoPostingPerMonth'   => '無',                                // 動画投稿/月
                    'marketingSupport'       => '無',                                // マーケティング支援
                    'aiTaxBarSupport'        => '有',                                // ※AI_TaxBar支援
                    'taxQASupport'           => '有',                                // ※税務Q&Aサポート
                    'pastHistoryReference'   => '最新1件のみ',                         // ※過去相談履歴の参照
                    'taxAdviceSupport'       => '簡易アドバイス',                       // ※税務アドバイス補助
                    'taxRevisionNotification' => '無',                                // ※税制改正の自動通知
                ],
            ],
            [
                'name'                   => 'プラチナプラン',
                'price'                  => 70000,
                'zoom_meeting_duration'  => 60,      // ミーティング時間
                'description'            => 'プラチナプラン - 月額70,000円',
                'duration_days'          => 365,
                'features'               => [
                    'contractDuration'       => '1年',
                    'openTime'               => '60分',
                    'openCountPerMonth'      => '10回',
                    'tipping'                => '有',
                    'specialGuest'           => '有',
                    'taxMinutesPost'         => 'おすすめ枠（検索上位に表示）',
                    'videoPostingPerMonth'   => '5本まで',
                    'marketingSupport'       => '特集ページで紹介(期間限定)orSNS露出サポート',
                    'aiTaxBarSupport'        => '有',
                    'taxQASupport'           => '有',
                    'pastHistoryReference'   => '最新5件のみ',
                    'taxAdviceSupport'       => '簡易アドバイス',
                    'taxRevisionNotification' => '標準通知',
                ],
            ],
            [
                'name'                   => 'VIPプラン',
                'price'                  => 100000,
                'zoom_meeting_duration'  => null,      // ミーティング時間
                'description'            => 'VIPプラン - 月額100,000円',
                'duration_days'          => 365,
                'features'               => [
                    'contractDuration'       => '1年',
                    'openTime'               => '無制限',
                    'openCountPerMonth'      => '無制限',
                    'tipping'                => '有',
                    'specialGuest'           => '有',
                    'taxMinutesPost'         => 'ピン留め（トップページ固定）＋SNS拡散（X・Facebook・LINEで告知）',
                    'videoPostingPerMonth'   => '無制限＋プロモーションサポート付き',
                    'marketingSupport'       => '特集ページ(常掲載)で紹介＋SNS露出サポート',
                    'aiTaxBarSupport'        => '有',
                    'taxQASupport'           => '有',
                    'pastHistoryReference'   => '全履歴',
                    'taxAdviceSupport'       => '高度アドバイス',
                    'taxRevisionNotification' => '「税理士の業務分野」に応じたカスタマイズ通知',
                ],
            ],
        ];

        // プランをデータベースに登録
        foreach ($corporatePlans as $index => $plan) {
            SubscriptionPlan::create([
                'id' => $index + 1,
                'name' => $plan['name'],
                'price' => $plan['price'],
                'zoom_meeting_duration' => $plan['zoom_meeting_duration'],
                'description' => $plan['description'],
                'features' => $plan['features'],
                'duration_days' => $plan['duration_days'],
            ]);
        }
    }
}
