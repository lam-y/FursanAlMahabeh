<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->insert([
            ['name' => 'رابع'],
            ['name' => 'خامس'],
            ['name' => 'سادس'],
            ['name' => 'سابع'],
            ['name' => 'ثامن'],
            ['name' => 'تاسع'],
            ['name' => 'عاشر'],
            ['name' => 'حادي عشر'],
            ['name' => 'بكالوريا'],
            ['name' => 'جامعي'],
        ]);
    }
}
