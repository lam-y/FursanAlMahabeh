<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            ['name' => 'فرعي أشبال-زهرات'],
            ['name' => 'فرعي ثالث-رابع'],
            ['name' => 'فرعي أول-ثاني'],
            ['name' => 'فرع المتقدمين'],
            ['name' => 'فرع الرواد'],
            ['name' => 'فرع القدامى'],
            ['name' => 'قسم التدريب'],
            ['name' => 'قسم الأعداد'],
        ]);
    }
}
