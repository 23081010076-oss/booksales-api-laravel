<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Fiksi', 'Non-Fiksi', 'Romance', 'Fantasi', 'Biografi'];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
