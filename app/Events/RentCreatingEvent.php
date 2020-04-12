<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Observers\NoveUserObserver;

use App\Models\Novel;
use App\User;
use App\Models\Rent;

class RentCreatingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $novelUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
  //  public $usernovel;
    public function __construct(Rent $rent)
    {

        //

          $novel =Novel::find($rent->novel_id);
          $novel->rent_count =$novel->rent_count + 1;
          if($novel->rent_count > $novel->stock){
            \Log::info("正在创建，库存不足".$novel->rent_count);
            //Novel::unsetEventDispatcher();
            //die();
            //return false;
          }



        //  $userclassroom->save();

        //$usernovel->note = 'liyuping';
        //$usernovel->save();
      //  $this->usernovel = $usernovel;

    }

}
