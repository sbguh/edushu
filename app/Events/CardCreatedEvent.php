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

use App\Models\Card;

use App\User;

class CardCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $novelUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $usernovel;
    public function __construct(Card $card)
    {

        //
        \Log::info("card active".strtotime(sprintf("+\d days",$card->duration)));

        $user = User::find($card->user_id);
        $openid = $user->openid;
        $check_subscribe = $user->check_subscribe;
        $addition_information ="";
        if($check_subscribe==false){
          $addition_information ="系统检测到您尚未关注公众号，请搜索中小学生阅读推广，关注公众号获取更多服务!";
        }
        \Log::info("card create".$card->id);
        if($openid&&env('WE_CHAT_DISPLAY', true)){
          \Log::info("card wechat send".$card->id);
          switch ($card->type_id) {
            case '1':
              // code...
              $card_type = "白银会员";
              break;
            case '2':
                // code...
              $card_type = "白金会员";
              break;

            default:
              // code...
              $card_type = "钻石会员";
              break;
          }
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => 'LFs-fHCwqLgzoKe5VW3_qqUMKFpIfaboRDLwGw3aJ5A',
              //  'url' => route('rent.show',$card->card_number),
                'data' => [
                    'first' => $user->name.'您好！共读书房借阅卡开通成功',
                    'keyword1' => "图书借阅卡",
                    'keyword2' => $card_type,
                    'keyword3' => "查看订单",
                    'keyword4' => "需要激活后使用",
                    'remark' => "您的会员卡已经开通，但尚未激活，请联系管理员激活账号！".$addition_information

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
