<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price', 'author_id', 'stock', 'cover_photo'];

    protected $appends = ['cover_url'];

    public function getCoverUrlAttribute()
    {
        if ($this->cover_photo) {
            return asset('storage/' . $this->cover_photo);
        }
        return null;
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
