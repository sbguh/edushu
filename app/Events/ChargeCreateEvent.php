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

use App\Models\Charge;
use App\User;

class ChargeCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $usernovel;
    public function __construct(Charge $charge)
    {

        //
        $amount = $charge->amount;
        $balance = $charge->user->balance;

      //  \Log::info("充值 金额".$amount);
      //  \Log::info("充值 余额".$balance);

        $app = app('wechat.official_account');
        $user = $charge->user;
        $openid = $user->openid;
        if(strpos("wechat",$charge->charge_number)==false){
          $title_send = "人工充值";
        }else{
          $title_send =  "微信在线自动充值";
        }

        if($openid&&env('WE_CHAT_DISPLAY', true)){
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => 'yj6GOxOq_UDvRkrJPpKizddW69XU3kxS2Xb4JcM4Pbw',
                'url' => 'https://book.edushu.co',
                'data' => [
                    'first' => $user->name.'您好！本次充值成功',
                    'keyword1' => $title_send,
                    'keyword2' => $charge->charge_number,
                    'keyword3' =>  $charge->amount,
                    'keyword4' => $charge->created_at,
                    'remark' => "隆回共读书房感谢您的使用，您当前账户余额: ".$balance

                ],
            ]);
        }

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
