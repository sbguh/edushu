<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\UserClassRoom;

use App\Models\ClassRoom;
use App\User;
class UserClassRoomCreatedEvent
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
        $classroom =ClassRoom::find($userclassroom->classroom_id);




        $app = app('wechat.official_account');
        $user = User::find($userclassroom->user_id);
        $openid = $user->openid;

          \Log::info("create classroom".$user->name);

        if($openid&&env('WE_CHAT_DISPLAY', true)){
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => 'tylpwbzLdGnC7TG4BEGCFFnbNXlExy0NCA2PeGazMbA',
                'url' => 'https://book.edushu.co',
                'data' => [
                    'first' => $user->name.'报班办理已成功，详情如下',
                    'keyword1' => $user->real_name?$user->real_name:$user->name,
                    'keyword2' => $classroom->name ,
                    'keyword3' => $classroom->begain_time,
                    'keyword4' => $classroom->start_time,
                    'keyword5' => $classroom->address,
                    'remark' => "隆回共读书房感谢您!祝学员学习进步！。"

                ],
            ]);
        }


        //$usernovel->note = 'liyuping';
        //$usernovel->save();
      //  $this->usernovel = $usernovel;

    }

}
