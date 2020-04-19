<?php

namespace App\Policies;

use App\Models\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Order $order)
    {

    //  dd($user);
        return $order->user_id == $user->id;
    }

    public function update(User $user, Order $order)
    {
        //return false;
        return true;
    }



    public function view(User $user, Order $order)
    {
        //
        if($order->paid_at){
          return true;
        }else{
          return false;
        }

    }

}
