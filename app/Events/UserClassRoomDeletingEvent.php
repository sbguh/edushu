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

use App\Models\UserClassRoom;

use App\Models\ClassRoom;
use App\User;
class UserClassRoomDeletingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $novelUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
  //  public $usernovel;
    public function __construct(UserClassRoom $userclassroom)
    {

        //
        \Log::info("UserClassRoomDeletingEvent hours".$userclassroom->hours);
          if($userclassroom->hours > 0){
          //  return false;
          \Log::info("UserClassRoomDeletingEvent action");
          }

        //  $userclassroom->save();

        //$usernovel->note = 'liyuping';
        //$usernovel->save();
      //  $this->usernovel = $usernovel;

    }

}
