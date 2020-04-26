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
use App\Models\Rent;
use App\User;

class RentCreatedEvent
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
        $novel =Novel::find($rent->novel_id);
        $novel->rent_count =$novel->rent_count + 1;
        //$novel->current_rent =$novel->current_rent + 1;
        //$novel->stock = $novel->stock -1;
        $novel->save();
        $rent->state = "借阅中";
        $rent->save();
        $app = app('wechat.official_account');
        $user = $rent->card->user;
        $openid = isset($user->openid)?$user->openid:"";
        $read_count = isset($user->read_count)?$user->read_count/10000:0;
        $read_count = "当前累计阅读:".$read_count."万字";
        $level = isset($user->level)?$user->level:0;
        $words = isset($novel->words)?$novel->words/10000:0;
        if($openid&&env('WE_CHAT_DISPLAY', true)){
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => 'gM1Es9cIrduu1A_Lxhfz0LiplfLHlV5C5hQKVnOve60',
                'url' => route('rent.show',$rent->rent_number),
                'data' => [
                    'first' => $user->name.'此次线下借书成功',
                    'keyword1' => $novel->title,
                    'keyword2' => date('Y-m-d H:i:s',strtotime('+7 day')),
                    'keyword3' => "您当前的阅读等级为".$level."级,  ".$read_count,
                    'remark' => "本书共计".$words."万字, 参与读书打卡赢取更多积分奖励，更快提升您的阅读等级，详情请点击"

                ],
            ]);
        }


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
