<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'photo_path' => $this->faker->imageUrl(),
            'species' => $this->faker->randomElement(['dog', 'cat', 'other']),
            'specify_other' => $this->faker->randomElement(['hamster', 'rabbit']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'age' => $this->faker->randomElement(['puppy', 'adult', 'senior']),
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'is_neutered' => $this->faker->boolean,
            'special_conditions' => $this->faker->boolean,
            'special_conditions_description' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['available', 'adopted']),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
