<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::all();

        foreach ($authors as $author) {
            Book::factory()->count(1)->create([
                'author_id' => $author->id
            ]);
        }
    }
}
