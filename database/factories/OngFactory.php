<?php

namespace Database\Factories;

use App\Models\Ong;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OngFactory extends Factory
{
    protected $model = Ong::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['user_type' => 'ong'])->id,
            'ong_name' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'responsible_name' => $this->faker->name,
            'responsible_cpf' => $this->faker->cpf,
            'cnpj' => $this->faker->cnpj,
            'about_ong' => $this->faker->paragraph,
        ];
    }
}
