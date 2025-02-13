<?php

namespace Database\Seeders;

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
        DB::table('tax_advisors')->insert([
            [
                'name' => '山田 太郎',
                'office_name' => '山田税理士事務所',
                'email' => 'yamada@example.com',
                'postal_code' => '100-0001',
                'prefecture' => '東京都',
                'address' => '千代田区1-1-1',
                'office_phone' => '03-1234-5678',
                'mobile_phone' => '090-1234-5678',
                'tax_accountant_photo' => null,
                'additional_photos' => json_encode([]),
                'password' => Hash::make('password123'), // ハッシュ化
                'plan' => 'basic',
                'is_tax_accountant' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
