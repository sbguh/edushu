<?php

namespace App\Policies;

use App\User;
use App\Models\Book;
use App\Models\Tag;
use App\Models\Chapter;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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

    public function viewAny(User $user)
    {
        return in_array('view-posts', $user->permissions);
    }
}
