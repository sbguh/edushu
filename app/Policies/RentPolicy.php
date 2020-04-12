<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Rent;

class RentPolicy
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
         //
       //  return true;
       return true;
     }


     public function view(User $user, Rent $rent)
     {
         //
         return true;
     }

     public function update(User $user, Rent $rent)
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


     public function restore(User $user, Rent $rent)
     {
         //
         return true;
     }


     public function forceDelete(User $user, Rent $rent)
     {
         //
         return true;
     }

     public function trashed(User $user, Rent $rent)
     {
         //
         return true;

     }

}
