<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\Storage;

class AuthorObserver
{
    /**
     * Handle the Author "created" event.
     *
     * @param  \App\Models\Author  $author
     * @return void
     */
    public function created(Author $author)
    {
        //
    }

    /**
     * Handle the Author "updated" event.
     *
     * @param  \App\Models\Author  $author
     * @return void
     */
    public function updated(Author $author)
    {
        //
    }

    /**
     * Handle the Author "deleted" event.
     *
     * @param  \App\Models\Author  $author
     * @return void
     */
    public function deleted(Author $author)
    {
        //
    }

    /**
     * Handle the Author "restored" event.
     *
     * @param  \App\Models\Author  $author
     * @return void
     */
    public function restored(Author $author)
    {
        //
    }

    /**
     * Handle the Author "force deleted" event.
     *
     * @param  \App\Models\Author  $author
     * @return void
     */
    public function forceDeleted(Author $author)
    {
        //
    }

    /**
     * Handle the Author "deleted" event.
     *
     * @param  \App\Models\Author  $author
     * @return void
     */
    public function deleting(Author $author)
    {
        if($author->image != null){
            Storage::delete('public/'. $author->image->url);
        }
    }
}
