<?php

namespace App\Events;
use App\Models\Book;
use App\Models\BookAudio as BookAudioModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookAudio
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $book;
    public function __construct(Book $book)
    {
        //
        $this->book = $book;
        $file_path =public_path()."/uploads/".$book->audio;
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

        if ($book->audios === null)
        {
          $bookaudiocount = BookAudioModel::where('book_id',$book->id)->count();
          if($book->id&&$bookaudiocount==0){
            $audio = new BookAudioModel(['audio'=>base64_encode($str)]);
            $book->audios()->save($audio);
          }


        }
        else
        {
        //  die("test");
            if($book->id){
              $book->audios->update(['audio'=>base64_encode($str)]);
            }

        }


        }

        //$content = file_get_contents($audiofile);
      //  dd($this->book->audio);
        //$book->audios->audio;

        //BookAudioModel::updateOrCreate(['book_id'=>$this->book->id,'audio'=>$content]);
        //dd($book->id);
        //dd("test");
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
