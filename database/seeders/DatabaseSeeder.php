<?php

namespace Database\Seeders;

use Database\Seeders\UserSeed;
use Illuminate\Database\Seeder;
use Database\Seeders\CollectionSeed;

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
        $this->call([
            UserSeed::class,
            CollectionSeed::class
        ]);
    }
}
