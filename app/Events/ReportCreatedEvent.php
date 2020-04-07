<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Report;

use App\Models\ClassRoom;
use App\User;
class ReportCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $novelUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
  //  public $usernovel;
    public function __construct(Report $report)
    {

        //
        $classroom =$report->userclassroom->classroom;
        $user =$report->userclassroom->user;

        \Log::info("create ReportCreatedEvent user".$user->name);
        \Log::info("create ReportCreatedEvent classroom".$classroom->name);

        $app = app('wechat.official_account');

        $openid = $user->openid;

          \Log::info("create classroom".$user->name);

        if($openid&&env('WE_CHAT_DISPLAY', true)){
              $app->template_message->send([
                'touser' => $openid,
                'template_id' => '5s88CJ8PJQMbgUjlIezPkFZuL2q-J2ceg92G2R9qASc',
                'url' => 'https://book.edushu.co',
                'data' => [
                    'first' => $user->name.'本周学习报告已生成',
                    'keyword1' => $user->real_name?$user->real_name:$user->name,
                    'keyword2' => $classroom->name ,
                    'keyword3' => $report->teacher?$report->teacher:$classroom->teacher,
                    'keyword4' => $report->date_time,
                    'keyword5' => $report->title,
                    'remark' => $report->detail
                ],
            ]);
        }


        //$usernovel->note = 'liyuping';
        //$usernovel->save();
      //  $this->usernovel = $usernovel;

    }

}
