<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['title', 'subtitle', 'language', 'page', 'published', 'description', 'genre_id', 'publisher_id'];

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function note(){
        return $this->morphMany(Note::class, 'noteable');
    }

    public function users(){
        return $this->morphToMany(User::class, 'userable');
    }
}
