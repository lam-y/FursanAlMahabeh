<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(HobbyBadgesSeeder::class);
        $this->call(BranchBadgesSeeder::class);
        $this->call(PublicBadgesSeeder::class);
        $this->call(BranchesSeeder::class);
        $this->call(MemberTypesSeeder::class);
        $this->call(GradesSeeder::class);
        $this->call(AdminUserSeeder::class);
    }
}
