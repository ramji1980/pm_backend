<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['planning','active','completed','archived','on-hold']),
          //  'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
             'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
