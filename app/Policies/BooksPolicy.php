<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Chapter;
use App\Models\Book;

class BooksPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function checkown(Book $book, Chapter $chapter)
    {

        return $book->id == $chapter->book_id;
    }
}
