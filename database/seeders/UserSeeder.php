<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Individual;
use App\Models\TaxAdvisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のユーザーを確認し、存在する場合は削除
        $this->cleanExistingData();

        // 1. 管理者ユーザー作成
        $admin = User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. 税理士ユーザー作成
        $taxAdvisor = User::create([
            'name' => '税理士 太郎',
            'email' => 'tax@example.com',
            'password' => Hash::make('password'),
            'role' => 'tax_advisor',
            'email_verified_at' => now(),
        ]);

        // 税理士プロフィール作成
        TaxAdvisor::create([
            'user_id' => $taxAdvisor->id,
            'office_name' => '税理士太郎事務所',
            'postal_code' => '123-4567',
            'prefecture' => '東京都',
            'address' => '千代田区1-1-1',
            'office_phone' => '03-1234-5678',
            'mobile_phone' => '090-1234-5678',
            'specialty' => '法人税,所得税,相続税',
            'profile_info' => '10年以上の経験を持つ税理士です。法人・個人問わず税務のご相談に対応いたします。',
            'is_tax_accountant' => true,
            'terms_agreed' => true,
        ]);

        // 3. 企業ユーザー作成
        $company = User::create([
            'name' => '株式会社サンプル',
            'email' => 'company@example.com',
            'password' => Hash::make('password'),
            'role' => 'company',
            'email_verified_at' => now(),
        ]);

        // 企業プロフィール作成
        Company::create([
            'user_id' => $company->id,
            'company_name' => '株式会社サンプル',
            'registration_number' => '0123456789012',
            'address' => '東京都渋谷区1-2-3',
            'contact_info' => '03-9876-5432',
            'terms_agreed' => true,
        ]);

        // 4. 個人ユーザー作成
        $individual = User::create([
            'name' => '個人 花子',
            'email' => 'individual@example.com',
            'password' => Hash::make('password'),
            'role' => 'individual',
            'email_verified_at' => now(),
        ]);

        // 個人プロフィール作成
        Individual::create([
            'user_id' => $individual->id,
            'date_of_birth' => '1990-01-01',
            'gender' => 'female',
            'address' => '東京都新宿区4-5-6',
            'contact_info' => '090-9876-5432',
            'terms_agreed' => true,
        ]);

        $this->command->info('ユーザーデータが正常に作成されました！');
    }

    /**
     * 既存のユーザーデータをクリーンアップする
     */
    private function cleanExistingData(): void
    {
        // 外部キー制約を一時的に無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 既存のユーザー関連データを削除
        // シード用メールアドレスのみを対象にすることで、他のユーザーデータは維持
        $emails = [
            'admin@example.com',
            'tax@example.com',
            'company@example.com',
            'individual@example.com',
        ];

        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                // 関連プロフィールをDB::tableを使用して直接削除
                DB::table('tax_advisors')->where('user_id', $user->id)->delete();
                DB::table('companies')->where('user_id', $user->id)->delete();
                DB::table('individual_profiles')->where('user_id', $user->id)->delete();

                // ユーザー自体を削除
                $user->delete();

                $this->command->info("既存のユーザー {$email} を削除しました。");
            }
        }

        // 外部キー制約を再有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
