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

class RentDeletingEvent
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

        //  $classroom =ClassRoom::find($userclassroom->classroom_id);
        //  $userclassroom->hours = $classroom->hours;
        //  $userclassroom->save();

        //$usernovel->note = 'liyuping';
        //$usernovel->save();
      //  $this->usernovel = $usernovel;

    }

}
