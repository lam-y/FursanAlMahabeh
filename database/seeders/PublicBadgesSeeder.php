<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicBadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('public_badges')->insert([
            ['name' => 'وسام فرع المتقدمين'],
            ['name' => 'وسام السنبلة'],
            ['name' => 'وسام الشمعة'],
            ['name' => 'وسام الصليب'],
        ]);
    }
}
