<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{

    protected $model = Author::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'biography' => $this->faker->paragraph,
            'birth_date' => $this->faker->date('Y-m-d', '2000-01-01'),
            'death_date' => $this->faker->optional(0.3)->date('Y-m-d'),
        ];
    }
}
