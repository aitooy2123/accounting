<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Account::insert([
            ['code' => '1000', 'name' => 'เงินสด', 'type' => 'asset'],
            ['code' => '1100', 'name' => 'ลูกหนี้การค้า', 'type' => 'asset'],
            ['code' => '2000', 'name' => 'เจ้าหนี้การค้า', 'type' => 'liability'],
            ['code' => '3000', 'name' => 'ทุน', 'type' => 'equity'],
            ['code' => '4000', 'name' => 'รายได้', 'type' => 'income'],
            ['code' => '5000', 'name' => 'ค่าใช้จ่าย', 'type' => 'expense'],
            ['code' => '2100', 'name' => 'ภาษีขาย', 'type' => 'liability'],
            ['code' => '1200', 'name' => 'ภาษีซื้อ', 'type' => 'asset'],
        ]);
    }
}
