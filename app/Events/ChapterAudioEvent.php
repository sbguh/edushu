<?php

namespace App\Events;
use App\Models\Chapter;
use App\Models\ChapterAudio;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChapterAudioEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $chapter;
    public function __construct(Chapter $chapter)
    {
        //

        $this->chapter = $chapter;
        $file_path =public_path()."/uploads/".$chapter->audio;
        //die($file_path);

        if(file_exists($file_path)){
          $fp = fopen($file_path,"r");
          $str = "";
          $buffer = 1024;//每次读取 1024 字节
          while(!feof($fp)){//循环读取，直至读取完整个文件
          $str .= fread($fp,$buffer);
          }
          $str = str_replace("\r\n","<br />",$str);
          //echo $str;
          fclose($fp);
        //die("11");
        //$book->audios()->updateOrCreate(['audio'=>base64_encode($str)]);

        if ($chapter->audios === null)
        {
          $chapteraudiocount = ChapterAudio::where('chapter_id',$chapter->id)->count();
          if($chapter->id&&$chapteraudiocount==0){
            $audio = new ChapterAudio(['audio'=>$str]);
            $chapter->audios()->save($audio);
          }


        }
        else
        {
        //  die("test");
            if($chapter->id){
              $chapter->audios->update(['audio'=>$str]);
            }

        }


        }
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
