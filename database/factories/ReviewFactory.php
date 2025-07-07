<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => \App\Models\User::factory(),
            'comment' => $this->faker->paragraph,
            'rating' => $this->faker->numberBetween(1, 5),           
        ];
    }
}
