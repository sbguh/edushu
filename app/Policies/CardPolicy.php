<?php

namespace App\Policies;

use App\Models\Card;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CardPolicy
{
    use HandlesAuthorization;



    public function attachUser(User $user, Card $card)
     {
         return true;
     }

     public function attachUserHistory(User $user, Card $card)
      {
          return false;
      }


    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user, Card $card)
    {
        //
        return true;
    }

    public function update(User $user, Card $card)
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


    public function restore(User $user, Card $card)
    {
        //
        return true;
    }


    public function forceDelete(User $user, Card $card)
    {
        //
        return false;
    }

    public function trashed(User $user, Card $card)
    {
        //
        return true;
    }
}
