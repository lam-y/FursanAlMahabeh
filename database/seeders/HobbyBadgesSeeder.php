<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HobbyBadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hobby_badges')->insert([
            ['name' => 'وسام طباخ'],
            ['name' => 'وسام مسعف'],
            ['name' => 'وسام كشفي'],
            ['name' => 'وسام مبدع'],
            ['name' => 'وسام الرياضي'],
            ['name' => 'وسام المعلوماتية'],
            ['name' => 'وسام الماهر'],
        ]);
    }
}
