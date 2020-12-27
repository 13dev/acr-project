<?php

namespace Database\Seeders;

use App\Domain\Song\Song;
use App\Domain\Artist\Artist;
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

        // \App\Models\User::factory(10)->create();
        Song::factory(2)->create();

    }
}
