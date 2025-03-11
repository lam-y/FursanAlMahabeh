<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchBadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branch_badges')->insert([
            ['name' => 'وسام فرعي أشبال-زهرات'],
            ['name' => 'وسام فرعي ثالث-رابع'],
            ['name' => 'وسام أول-ثاني'],
        ]);
    }
}
