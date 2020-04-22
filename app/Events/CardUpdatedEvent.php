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

class CardUpdatedEvent
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
        \Log::info("card duration".$card->duration);
        if($card->active&&$card->duration){
          $card->start_date = date("Y-m-d");

          if($card->end_date && strtotime($card->end_date)>strtotime("now")){
            $card->end_date = date("Y-m-d",strtotime($card->end_date." ".sprintf("+%u days",$card->duration)));
          }else{
              $card->end_date = date("Y-m-d", strtotime(sprintf("+%u days",$card->duration)));
          }
          $card->duration = 0;

          \Log::info("card end date".$card->end_date);

          $card->save();

        $user = User::find($card->user_id);
        $app = app('wechat.official_account');
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
                'url' => route('cards.show'),
                'data' => [
                    'first' => $user->name.'您好！您的会员卡激活成功',
                    'keyword1' => $card->card_number,
                    'keyword2' => $card->end_date,
                    'keyword3' =>$card_type,
                    'remark' => "您的会员卡已经可以正常使用，详情请点击查看！".$addition_information

                ],
            ]);
        }
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
