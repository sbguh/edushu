<?php

namespace App\Policies;

use App\Models\OrderProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderProductPolicy
{
    use HandlesAuthorization;

    public function own(User $user, OrderProduct $orderproduct)
    {

    //  dd($user);
        return $order->user_id == $user->id;
    }

    public function update(User $user, OrderProduct $orderproduct)
    {
        //return false;
        return false;
    }

    public function viewAny(User $user)
    {
        //
      //  return true;
      return true;
    }

    public function view(User $user, OrderProduct $orderproduct)
    {
        //
        return false;
    }

}
