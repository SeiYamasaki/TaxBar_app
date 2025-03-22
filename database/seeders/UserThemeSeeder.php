<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルをクリア
        DB::table('user_theme')->truncate();

        // ユーザーとテーマを取得
        $users = User::all();
        $themes = Theme::all();

        // 専門家（税理士）は専門分野としてテーマを選択
        foreach ($users as $user) {
            if ($user->isTaxAdvisor()) {
                // 各税理士に対して5〜10個のテーマをランダムに選択
                $randomThemeCount = rand(5, 10);
                $randomThemes = $themes->random($randomThemeCount);

                foreach ($randomThemes as $theme) {
                    $user->interestedThemes()->attach($theme->id);
                }
            } elseif ($user->isCompany()) {
                // 企業ユーザーは3〜8個のテーマに関心がある
                $randomThemeCount = rand(3, 8);
                $randomThemes = $themes->random($randomThemeCount);

                foreach ($randomThemes as $theme) {
                    $user->interestedThemes()->attach($theme->id);
                }
            } elseif ($user->isIndividual()) {
                // 個人ユーザーは1〜5個のテーマに関心がある
                $randomThemeCount = rand(1, 5);
                $randomThemes = $themes->random($randomThemeCount);

                foreach ($randomThemes as $theme) {
                    $user->interestedThemes()->attach($theme->id);
                }
            }
        }
    }
}
