<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Fiction',
                'Non-Fiction',
                'Mystery',
                'Science Fiction',
                'Fantasy',
                'Romance',
                'Thriller',
                'Horror',
                'Biography',
                'History',
                'Science',
                'Technology',
                'Business',
                'Self-Help',
                'Poetry'
            ])
        ];
    }
}