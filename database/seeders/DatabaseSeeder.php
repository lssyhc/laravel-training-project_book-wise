<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $states = ['good', 'average', 'bad'];

        Book::factory()->count(33)->create()->each(function ($book) use ($states) {
            $numReviews = random_int(5, 30);


            $randomState = fake()->randomElement($states);
            Review::factory()->count($numReviews)
                ->for($book)
                ->{$randomState}()
                ->create();
        });
    }
}
