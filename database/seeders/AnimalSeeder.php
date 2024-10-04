<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    public function run()
    {
        Animal::factory(10)->create(); // Cria 10 animais fictícios
    }
}
