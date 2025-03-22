<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            // 確定申告系
            '副業確定申告Bar',
            'フリーランスのための確定申告Bar',
            '駆け出し個⼈事業主Bar',
            '海外収⼊確定申告Bar',
            '医療費控除徹底解説Bar',
            'ふるさと納税申告Bar',
            '住宅ローン控除申告Bar',
            '配当収⼊・株式確定申告Bar',
            '初めての⻘⾊申告Bar',
            '副業YouTuberの税務申告Bar',

            // 起業・法⼈化系
            '起業準備Bar',
            '法⼈成りシミュレーションBar',
            '1円起業Bar',
            '合同会社 vs 株式会社Bar',
            '法⼈設⽴届出書の作り⽅Bar',
            '飲⾷店開業税務Bar',
            'ECサイト起業税務Bar',
            '美容室・サロン開業Bar',
            'クリニック開業税務Bar',
            'ベンチャーキャピタル税務Bar',

            // 節税・資産運⽤系
            '副業者向け節税Bar',
            '個⼈事業主の節税Bar',
            '不動産オーナー節税Bar',
            '仮想通貨節税Bar',
            '株式運⽤節税Bar',
            'NISA・iDeCo攻略Bar',
            '社⻑の役員報酬節税Bar',
            '経営者のための節税Bar',
            '相続税対策Bar',
            '教育資⾦贈与Bar',

            // 副業・個⼈事業主系
            'SNS運⽤者の税務Bar',
            'ライター・ブロガー税務Bar',
            'クリエイターの税務Bar',
            'イラストレーターBar',
            'ハンドメイド作家税務Bar',
            'コンサルタントの税務Bar',
            'カメラマン・映像制作Bar',
            'エンジニア副業税務Bar',
            'クラウドワーカーの税務Bar',
            '翻訳者・通訳者税務Bar',

            // 不動産・投資系
            '不動産売買税務Bar',
            '不動産オーナー向け税務Bar',
            '賃貸経営税務Bar',
            '不動産転売の税務Bar',
            'リノベーション投資Bar',
            'マンション投資Bar',
            '⼟地活⽤税務Bar',
            '空き家活⽤税務Bar',
            'REIT（不動産投資信託）Bar',
            '海外不動産投資税務Bar',

            // 海外・インバウンド系
            '海外移住税務Bar',
            '海外送⾦税務Bar',
            'デジタルノマド税務Bar',
            'インバウンド事業税務Bar',
            '外国⼈雇⽤税務Bar',
            '国際取引税務Bar',
            '海外在住者確定申告Bar',
            '輸出⼊ビジネス税務Bar',
            '海外法⼈設⽴Bar',
            '外貨運⽤税務Bar',

            // 相続・贈与・保険系
            '親族への⽣前贈与Bar',
            '保険活⽤節税Bar',
            '相続対策ナイトBar',
            '不動産相続Bar',
            '家族信託税務Bar',
            '遺産分割税務Bar',
            '法⼈保険節税Bar',
            '事業承継税務Bar',
            '⽣命保険控除Bar',
            '退職⾦と税務Bar',

            // 業種別特化系
            '美容サロン税務Bar',
            '飲⾷店経営者税務Bar',
            'スポーツトレーナー税務Bar',
            '農業経営者税務Bar',
            '建設業・職⼈税務Bar',
            'アートギャラリー税務Bar',
            '福祉施設経営者Bar',
            'カフェオーナー税務Bar',
            '教育系ビジネス税務Bar',
            '観光業経営者Bar',
        ];

        // 税理士ユーザーID（適切なIDに変更してください）
        $taxAccountantUserId = 1;

        foreach ($themes as $title) {
            Theme::create([
                'user_id' => $taxAccountantUserId,
                'title' => $title,
                'description' => $title . 'の詳細説明。このテーマでは税務に関する様々な情報を提供します。',
                'is_active' => true,
                'views' => rand(0, 100),
            ]);
        }
    }
}
