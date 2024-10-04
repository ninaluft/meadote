<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'user_type' => $this->faker->randomElement(['tutor', 'ong', 'admin']),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'cep' => $this->faker->postcode,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
