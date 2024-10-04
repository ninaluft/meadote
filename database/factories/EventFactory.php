<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Ong;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'ong_id' => Ong::factory()->create()->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'event_date' => $this->faker->date(),
            'event_time' => $this->faker->time(),
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'cep' => $this->faker->postcode,
            'location' => $this->faker->address,
        ];
    }
}
