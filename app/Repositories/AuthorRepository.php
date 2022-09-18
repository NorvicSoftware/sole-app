<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository
{
    public function getAuthorsRatings(){
        $authors = Author::orderBy('full_name', 'asc')->get();
        $count = 0;
        foreach ($authors as $author) {
            $authors[$count]->ratings = $author->users()->select('userables.*')->get();
            $count++;
        }
        return $authors;
    }

    public function getAuthorNotes($author_id){
        $author = Author::findOrFail($author_id);
        $data = [
            'author' => $author,
            'notes' => $author->note()->where('user_id', '=', auth()->user()->id)->get()
        ];
        return $data;
    }
}
