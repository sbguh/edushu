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
use App\Models\Rent;
use App\User;

class RentDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $novelUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $usernovel;
    public function __construct(Rent $rent)
    {

        //

        //\Log::info("del".$usernovel->novel_id);

        $novel =Novel::find($rent->novel_id);
        //$novel->rent_count =$novel->rent_count - 1;
        //$novel->save();

        $app = app('wechat.official_account');
        $user = User::find($rent->user_id);
        $openid = $user->openid;
        $score = 0;
        $user->rent_count = $user->rent_count +1;
        $novel->stock = $novel->stock +1;
        $user->level_upgrade = $user->level_upgrade+10;
        $user->scores =  $user->scores + 10;
        $score +=10;
        $user->read_count = $user->read_count +$novel->words;
        if($novel->words){
          $user->level_upgrade = $user->level_upgrade + $novel->words/10000;

          $user->scores = $user->scores + $novel->words/10000;

          $score +=round($novel->words/10000);

        }
        if($user->level_upgrade>=30){
          $user->level= $user->level + intval($user->level_upgrade/30);
          $user->level_upgrade = $user->level_upgrade - 30*intval($user->level_upgrade/30);

        }


        $user->save();

        if($openid&&env('WE_CHAT_DISPLAY', true)){
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => 'tDZ7alD3KSR6CD0QvzVxGZXrtMaZOW41QkGd72atu7A',
                'url' => route('rent.show',$rent->rent_number),
                'data' => [
                    'first' => $user->name.'您好！您本次还书成功！',
                    'keyword1' => $novel->title,
                    'keyword2' => date('Y-m-d H:i:s'),
                    'remark' => "您当前的积分已更新, 本次获得积分".$score.", 邀请您撰写读后感赢取更多积分, 详情请点击查看."

                ],
            ]);
        }

        $rent->return_at=date(time());
        $rent->state ="已还书";
        $rent->save();

        //$usernovel->note = 'liyuping';
        //$usernovel->save();

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
