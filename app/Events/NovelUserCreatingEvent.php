<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Novel;
use App\Observers\NoveUserObserver;
use App\Models\NovelUser;
use Laravel\Nova\Actions\Action;

class NovelUserCreatingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $novelUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $usernovel;
    public function __construct(NovelUser $usernovel)
    {

        //


        //\Log::info("creating".$usernovel);
        //$usernovel->note = 'liyuping';
        //$usernovel->save();
        $novel =Novel::find($usernovel->novel_id);
        $novel->rent_count =$novel->rent_count + 1;
        if($novel->rent_count > $novel->stock){
          \Log::info("库存不足".$novel->rent_count);
          //Novel::unsetEventDispatcher();
          die();
          return false;
        }

        $this->usernovel = $usernovel;

    }

    public function getNovelUser()
    {
        return $this->novelUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
