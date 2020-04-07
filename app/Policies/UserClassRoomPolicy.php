<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\UserClassRoom;

class UserClassRoomPolicy
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


    public function attachUser(User $user, UserClassRoom $userclassroom)
     {
         return true;
     }

     public function attachUserHistory(User $user, UserClassRoom $userclassroom)
      {
          return false;
      }


    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user, UserClassRoom $userclassroom)
    {
        //
        \Log::info("UserClassRoomPolicy view");
        return true;
    }

    public function update(User $user, UserClassRoom $userclassroom)
    {
        //return false;
        \Log::info("UserClassRoomPolicy update");
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


    public function restore(User $user, UserClassRoom $userclassroom)
    {
        //
        return true;
    }


    public function forceDelete(User $user, UserClassRoom $userclassroom)
    {
        //
        return false;
    }

    public function trashed(User $user, UserClassRoom $userclassroom)
    {
        //
        return true;
    }


}
