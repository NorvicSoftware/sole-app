<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Book;

class NewBookNotification extends Mailable
{
    use Queueable, SerializesModels;
    private $book;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('books.emails.newAuthorNotification')->with([
            'title' => $this->book->title,
            'subtitle' => $this->book->subtitle,
        ]);
    }
}
