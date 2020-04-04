<?php

namespace App\Policies;

use App\Models\Novel;
use App\Models\NovelHistory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;



    public function attachNovel(User $user)
     {
         return true;
     }

     public function attachUserHistory(User $user)
      {
          return false;
      }


    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user)
    {
        //
        return true;
    }

    public function update(User $user)
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
        return false;
    }


    public function restore(User $user)
    {
        //
        return true;
    }


    public function forceDelete(User $user)
    {
        //
        return false;
    }

    public function trashed(User $user)
    {
        //
        return true;
    }
}
