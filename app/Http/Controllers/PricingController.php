<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class PricingController extends Controller
{
    public function index()
    {
        // 法人向けプラン
        $corporatePlans = [
            [
                'name'                   => 'ゴールドプラン',
                'monthlyFee'             => 50000,   // 月額
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
            [
                'name'                   => 'プラチナプラン',
                'monthlyFee'             => 70000,
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
            [
                'name'                   => 'VIPプラン',
                'monthlyFee'             => 100000,
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
        ];

        // 個人/法人/団体向けプラン（既存のまま例示）
        $individualPlans = [
            [
                'name' => '個 人',
                'price' => 0,
                'features' => ['一切無料', '投銭機能有', "議事録自動生成有", "動画見放題"]
            ],
            [
                'name' => '法 人',
                'price' => 0,
                'features' => ['一切無料', '投銭機能有', "議事録自動生成有", "動画見放題"]
            ],
            [
                'name' => '団 体',
                'price' => 0,
                'features' => ['一切無料', '投銭機能有', "議事録自動生成有", "動画見放題"]
            ]
        ];

        // プランをデータベースに保存
        $this->syncPlansWithDatabase($corporatePlans);

        // Blade に渡す
        return view('pricing.index', compact('corporatePlans', 'individualPlans'));
    }

    /**
     * プラン情報をデータベースに同期する
     */
    private function syncPlansWithDatabase($plans)
    {
        foreach ($plans as $index => $plan) {
            $features = [
                'contractDuration' => $plan['contractDuration'],
                'openTime' => $plan['openTime'],
                'openCountPerMonth' => $plan['openCountPerMonth'],
                'tipping' => $plan['tipping'],
                'specialGuest' => $plan['specialGuest'],
                'taxMinutesPost' => $plan['taxMinutesPost'],
                'videoPostingPerMonth' => $plan['videoPostingPerMonth'],
                'marketingSupport' => $plan['marketingSupport'],
                'aiTaxBarSupport' => $plan['aiTaxBarSupport'],
                'taxQASupport' => $plan['taxQASupport'],
                'pastHistoryReference' => $plan['pastHistoryReference'],
                'taxAdviceSupport' => $plan['taxAdviceSupport'],
                'taxRevisionNotification' => $plan['taxRevisionNotification'],
            ];

            // プランがなければ作成、あれば更新
            SubscriptionPlan::updateOrCreate(
                ['id' => $index + 1],
                [
                    'name' => $plan['name'],
                    'price' => $plan['monthlyFee'],
                    'description' => $plan['name'] . ' - 月額' . number_format($plan['monthlyFee']) . '円',
                    'features' => $features,
                    'duration_days' => 365, // 1年間の契約
                ]
            );
        }
    }
}
