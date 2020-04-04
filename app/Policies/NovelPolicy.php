<?php

namespace App\Policies;

use App\Models\Novel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NovelPolicy
{
    use HandlesAuthorization;



    public function attachUser(User $user, Novel $novel)
     {
         return true;
     }

     public function attachUserHistory(User $user, Novel $novel)
      {
          return false;
      }


    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user, Novel $novel)
    {
        //
        return true;
    }

    public function update(User $user, Novel $novel)
    {
        //return false;
        return true;
    }

    public function create(User $user)
    {
        //return false;
        return true;
    }


    public function delete(User $user)
    {
        //
        //return false;
        return true;
    }


    public function restore(User $user, Novel $novel)
    {
        //
        return true;
    }


    public function forceDelete(User $user, Novel $novel)
    {
        //
        return false;
    }

    public function trashed(User $user, Novel $novel)
    {
        //
        return true;
    }
}
