<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function getBooksRatings(){
        $books = Book::orderBy('title', 'asc')->get();
        $count = 0;
        foreach ($books as $book) {
            $books[$count]->ratings = $book->users()->select('userables.*')->get();
            $count++;
        }
        return $books;
    }

    public function getBookNotes($book_id){
        $book = Book::findOrFail($book_id);
        $data = [
            'book' => $book,
            'notes' => $book->note()->where('user_id', '=', auth()->user()->id)->get()
        ];
        return $data;
    }
}
