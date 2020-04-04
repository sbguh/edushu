<?php

namespace App\Policies;

use App\Models\NovelUserHistory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NovelUserHistoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user, NovelUserHistory $novel)
    {
        //
        return true;
    }

    public function update(User $user, NovelUserHistory $novel)
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


    public function restore(User $user, NovelUserHistory $novel)
    {
        //
        return false;
    }


    public function forceDelete(User $user, NovelUserHistory $novel)
    {
        //
        return false;
    }

    public function trashed(User $user, NovelUserHistory $novel)
    {
        //
        return false;
    }
}
