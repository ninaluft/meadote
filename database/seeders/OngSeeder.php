<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ong;

class OngSeeder extends Seeder
{
    public function run()
    {
        Ong::factory(10)->create(); // Cria 10 ONGs fictícias
    }
}
