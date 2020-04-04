<?php

namespace App\Policies;

use App\Models\Charge;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargePolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }


    public function view(User $user, Charge $charge)
    {
        //
        return true;
    }

    public function update(User $user, Charge $charge)
    {
        //return false;
        return false;
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


    public function restore(User $user, Charge $charge)
    {
        //
        return false;
    }


    public function forceDelete(User $user, Charge $charge)
    {
        //
        return false;
    }

    public function trashed(User $user, Charge $charge)
    {
        //
        return true;
    }
}
