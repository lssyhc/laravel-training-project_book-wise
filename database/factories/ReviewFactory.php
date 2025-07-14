<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review' => $this->faker->paragraph,
            'rating' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => function ($attributes) {
                $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            }
        ];
    }

    public function good(): ReviewFactory
    {
        return $this->state(fn () => ['rating' => $this->faker->numberBetween(4, 5)]);
    }

    public function average(): ReviewFactory
    {
        return $this->state(fn () => ['rating' => 3]);
    }

    public function bad(): ReviewFactory
    {
        return $this->state(fn () => ['rating' => $this->faker->numberBetween(1, 2)]);
    }
}
