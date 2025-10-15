<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 unique genres
        Genre::factory()
            ->count(10)
            ->create();
    }
}
