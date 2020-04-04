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
use App\Models\NovelUserHistory;
use App\User;

class NovelUserDeletedEvent
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

        //\Log::info("del".$usernovel->novel_id);

        $novel =Novel::find($usernovel->novel_id);
        $novel->rent_count =$novel->rent_count - 1;
        $novel->save();

        NovelUserHistory::create([
          'user_id'=>$usernovel->user_id,
          'novel_id'=>$usernovel->novel_id,
          'type'=>"还书"

        ]);

        $app = app('wechat.official_account');
        $user = User::find($usernovel->user_id);
        $openid = $user->openid;
        if($openid&&env('WE_CHAT_DISPLAY', true)){
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => 'tDZ7alD3KSR6CD0QvzVxGZXrtMaZOW41QkGd72atu7A',
                'url' => 'https://book.edushu.co',
                'data' => [
                    'first' => $user->name.'您好！您本次还书成功！',
                    'keyword1' => $novel->title,
                    'keyword2' => date('Y-m-d H:i:s'),
                    'remark' => "隆回共读书房感谢您的使用。"

                ],
            ]);
        }


        //$usernovel->note = 'liyuping';
        //$usernovel->save();
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
