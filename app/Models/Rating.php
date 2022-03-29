<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = ['number_star'];

    public function authors(){
        return $this->morphedByMany(Author::class, 'ratingable');
    }

    public function books(){
        return $this->morphedByMany(Book::class, 'ratingable');
    }
}
