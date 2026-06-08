<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'date' => fake()->date(),
            'location' => fake()->city(),
        ];
    }
}