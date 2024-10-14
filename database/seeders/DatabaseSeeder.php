<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PetSeeder::class,
            OngEventSeeder::class,
            PostSeeder::class,
            SupportRequestSeeder::class,  // Executar antes das mensagens
            FavoriteSeeder::class,
            MessageSeeder::class,
        ]);
    }

}
