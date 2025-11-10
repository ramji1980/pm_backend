<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id' => Task::inRandomOrder()->first()?->id ?? Task::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'body' => fake()->sentence(10),
        ];
    }
}
