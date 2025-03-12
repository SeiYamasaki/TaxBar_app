<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class PricingController extends Controller
{
    public function index()
    {
        // データベースからサブスクリプションプランを取得
        $plans = SubscriptionPlan::all();

        // 法人向けプラン（データベースから取得したプランを変換）
        $corporatePlans = [];

        foreach ($plans as $plan) {
            $features = $plan->features;

            $corporatePlans[] = [
                'name' => $plan->name,
                'monthlyFee' => $plan->price,
                'contractDuration' => $features['contractDuration'] ?? '1年',
                'openTime' => $features['openTime'] ?? '',
                'openCountPerMonth' => $features['openCountPerMonth'] ?? '',
                'tipping' => $features['tipping'] ?? '有',
                'specialGuest' => $features['specialGuest'] ?? '無',
                'taxMinutesPost' => $features['taxMinutesPost'] ?? '',
                'videoPostingPerMonth' => $features['videoPostingPerMonth'] ?? '',
                'marketingSupport' => $features['marketingSupport'] ?? '',
                'aiTaxBarSupport' => $features['aiTaxBarSupport'] ?? '有',
                'taxQASupport' => $features['taxQASupport'] ?? '有',
                'pastHistoryReference' => $features['pastHistoryReference'] ?? '',
                'taxAdviceSupport' => $features['taxAdviceSupport'] ?? '',
                'taxRevisionNotification' => $features['taxRevisionNotification'] ?? '',
            ];
        }

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
