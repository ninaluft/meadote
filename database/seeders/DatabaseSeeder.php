<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chamando os seeders criados
        $this->call([
            UserSeeder::class,
            PetSeeder::class,
            OngEventSeeder::class,
            PostSeeder::class,
        ]);
    }
}
