<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::all();
        $genres = Genre::all();

        foreach ($authors as $author) {
            // Create 2 books for each author
            Book::factory()->count(2)->create([
                'author_id' => $author->id
            ])->each(function ($book) use ($genres) {
                // Attach 1-3 random genres to each book
                $book->genres()->attach(
                    $genres->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
        }
    }
}
