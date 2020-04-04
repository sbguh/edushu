<?php

namespace App\Policies;

use App\Models\NovelHistory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NovelHistoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user, NovelHistory $novel)
    {
        //
        return true;
    }

    public function update(User $user, NovelHistory $novel)
    {
        //return false;
        return false;
    }

    public function create(User $user)
    {
        //return false;
        return false;
    }


    public function delete(User $user)
    {
        //
        //return false;
        return false;
    }


    public function restore(User $user, NovelHistory $novel)
    {
        //
        return false;
    }


    public function forceDelete(User $user, NovelHistory $novel)
    {
        //
        return false;
    }

    public function trashed(User $user, NovelHistory $novel)
    {
        //
        return false;
    }
}
