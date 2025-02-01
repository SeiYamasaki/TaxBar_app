<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $corporatePlans = [
            [
                'name' => 'ゴールドプラン',
                'price' => 30000,
                'features' => ['Bar開店', '月5回まで', "投銭機能有", "予約機能有", "スペシャルゲスト制度の適用無", "動画配信機能無"]
            ],
            [
                'name' => 'プラチナプラン',
                'price' => 50000,
                'features' => ['Bar開店', '月9回まで', "投銭機能有", "予約機能有", "スペシャルゲスト制度の適用有", "動画配信機能無"]
            ],
            [
                'name' => 'VIPプラン',
                'price' => 100000,
                'features' => ['Bar開店', '無制限', "投銭機能有", "予約機能有", "スペシャルゲスト制度の適用有", "動画配信機能無制限"]
            ],
        ];

        $individualPlans = [
            [
                'name' => '個 人',
                'price' => 0,
                'features' => ['一切無料','投銭機能有',"議事録自動生成有","動画見放題"]
            ],
            [
                'name' => '法 人',
                'price' => 0,
                'features' => ['一切無料','投銭機能有',"議事録自動生成有","動画見放題"]
            ],
            [
                'name' => '団 体',
                'price' => 0,
                'features' => ['一切無料','投銭機能有',"議事録自動生成有","動画見放題"]
            ]
        ];


        return view('pricing.index', compact('corporatePlans', 'individualPlans')); // 変数を Blade に渡す
    }
}
