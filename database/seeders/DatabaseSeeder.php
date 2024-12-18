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
        //\App\Models\User::factory(10)->create();
        \App\Models\Movies::factory(30)->create();
        \App\Models\Books::factory(30)->create();
        \App\Models\Rentals::factory(10)->create();
    }
}
