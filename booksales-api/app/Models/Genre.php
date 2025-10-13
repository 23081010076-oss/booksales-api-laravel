<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Data array statis (tanpa database)
    public static function allGenres()
    {
        return [
            ['id' => 1, 'name' => 'Fiksi'],
            ['id' => 2, 'name' => 'Non-Fiksi'],
            ['id' => 3, 'name' => 'Fantasi'],
            ['id' => 4, 'name' => 'Romansa'],
            ['id' => 5, 'name' => 'Horor'],
        ];
    }
}
