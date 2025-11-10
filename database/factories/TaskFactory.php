<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->text(100),
            'status' => fake()->randomElement(['pending', 'progress', 'completed']),
            'priority' => fake()->randomElement(['low','medium','high']),
            'assigned_to' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
