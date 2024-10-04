<?php

namespace Database\Factories;

use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorFactory extends Factory
{
    protected $model = Tutor::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['user_type' => 'tutor'])->id,
            'full_name' => $this->faker->name,
            'date_of_birth' => $this->faker->date(),
            'temporary_housing' => $this->faker->boolean,
            'cpf' => $this->faker->cpf,
            'about_me' => $this->faker->sentence,
        ];
    }
}
