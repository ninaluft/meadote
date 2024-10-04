<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tutor;

class TutorSeeder extends Seeder
{
    public function run()
    {
        Tutor::factory(50)->create(); // Cria 10 tutores fictícios
    }
}
