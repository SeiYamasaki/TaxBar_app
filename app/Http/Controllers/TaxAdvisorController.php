<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxAdvisor;
use App\Models\User;

class TaxAdvisorController extends Controller
{
    /**
     * 都道府県ごとの税理士一覧を取得
     */
    public function getByPrefecture()
    {
        // 都道府県ごとに税理士を取得
        $advisorsByPrefecture = TaxAdvisor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'tax_advisor');
            })
            ->get()
            ->groupBy('prefecture');

        return $advisorsByPrefecture;
    }

    /**
     * 特定の都道府県の税理士一覧を表示
     */
    public function byPrefecture($prefecture)
    {
        // 特定の都道府県の税理士を取得
        $advisors = TaxAdvisor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'tax_advisor');
            })
            ->where('prefecture', $prefecture)
            ->paginate(20);

        return view('tax_advisor.prefecture', [
            'prefecture' => $prefecture,
            'advisors' => $advisors
        ]);
    }

    /**
     * 都道府県ごとの税理士一覧をビューコンポーザーとして登録
     */
    public static function registerViewComposer()
    {
        \Illuminate\Support\Facades\View::composer('components.footer', function ($view) {
            // 都道府県ごとに税理士を取得（各都道府県最大3名まで）
            $prefectures = [
                '北海道',
                '青森県',
                '岩手県',
                '宮城県',
                '秋田県',
                '山形県',
                '福島県',
                '茨城県',
                '栃木県',
                '群馬県',
                '埼玉県',
                '千葉県',
                '東京都',
                '神奈川県',
                '新潟県',
                '富山県',
                '石川県',
                '福井県',
                '山梨県',
                '長野県',
                '岐阜県',
                '静岡県',
                '愛知県',
                '三重県',
                '滋賀県',
                '京都府',
                '大阪府',
                '兵庫県',
                '奈良県',
                '和歌山県',
                '鳥取県',
                '島根県',
                '岡山県',
                '広島県',
                '山口県',
                '徳島県',
                '香川県',
                '愛媛県',
                '高知県',
                '福岡県',
                '佐賀県',
                '長崎県',
                '熊本県',
                '大分県',
                '宮崎県',
                '鹿児島県',
                '沖縄県'
            ];

            $advisorsByPrefecture = [];

            foreach ($prefectures as $prefecture) {
                $advisorsByPrefecture[$prefecture] = TaxAdvisor::with('user')
                    ->whereHas('user', function ($query) {
                        $query->where('role', 'tax_advisor');
                    })
                    ->where('prefecture', $prefecture)
                    ->take(3)
                    ->get();
            }

            $view->with('advisorsByPrefecture', $advisorsByPrefecture);
        });
    }
}
