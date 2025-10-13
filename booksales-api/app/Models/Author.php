<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    // Data array statis (tanpa database)
    public static function allAuthors()
    {
        return [
            ['id' => 1, 'name' => 'Tere Liye'],
            ['id' => 2, 'name' => 'Andrea Hirata'],
            ['id' => 3, 'name' => 'Dewi Lestari'],
            ['id' => 4, 'name' => 'Ahmad Fuadi'],
            ['id' => 5, 'name' => 'Pramoedya Ananta Toer'],
        ];
    }
}
