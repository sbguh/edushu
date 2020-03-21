<?php

namespace App\Http\Controllers;

use Log;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat\Kernel\Messages\Media;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Speech\SpeechClient;
use Illuminate\Http\Request;

use App\User;

use App\Models\UserLastUrl;

use Redirect;
use Auth;
use Storage;

class WeChatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
     public function serve()
     {
       //  Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

         $app = app('wechat.official_account');
         $app->server->push(function ($message) use ($app){
         $openId = $message['FromUserName'];

         if(isset($message['EventKey'])){
           if($message['EventKey']=="ContactUs"){
                       return "线下门店地址: 湖南省隆回县万和实验学校对面（共读书房），我们的官网https://edushu.co";
                     }

                     if($message['EventKey']=="AboutUs"){
                                 return "我们致力于在中小学生中推广阅读，培养学生良好的阅读和学习习惯。我们相信如果能改变孩子的阅读和读书习惯，就能改变孩子的一生甚至能影响整个家庭, 请关注我们并和您的孩子一起养成良好的阅读习惯. 我们的官网https://edushu.co";
                               }

                     if($message['EventKey']=="LatestEvents"){
                       $list = $app->material->list('news', 0, 1);
                       $mediaId = $list['item'][0]['media_id'];
                       $mediaId ="BnJNnKBv0KrqIn5VfkjTLgqTS1SkdQTNPVrWw0sdT6g";
                       $media = new Media($mediaId, 'mpnews');

                       $result = $app->customer_service->message($media)->to($openId)->send();
                       return;
           }
         }
           switch ($message['MsgType']) {

                 case 'event':

                 if($message['Event']=="unsubscribe"){

                   if(User::where('openid',$message['FromUserName'])->count()){
                     $user = User::where('openid',$message['FromUserName'])->first();
                     $user->check_subscribe =0;
                     $user->save();
                   }
                 }



                 if($message['Event']=="subscribe"){

                        if(User::where('openid',$message['FromUserName'])->count()){
                          $user = User::where('openid',$message['FromUserName'])->first();
                          $user->check_subscribe =true;
                          $user->save();
                          $user_wechat = $app->user->get($message['FromUserName']);
                          $nickname = $user_wechat['nickname'];

                          $lasturl =UserLastUrl::where('user_id',$user->id)->first();
                          if($lasturl===false){
                            return $nickname."欢迎您! 读经典好书.";
                            break;
                          }else{
                            return $nickname."欢迎继续阅读 <a href='".$lasturl->url."'>".$lasturl->title."</a>";
                            break;
                          }

                        }else{

                          $user_wechat = $app->user->get($message['FromUserName']);
                          $nickname = $user_wechat['nickname'];
                          $email = $message['FromUserName']."@edushu.co";

                          $password = 'Edushuco2020!@';

                          $data =[
                              'name' => $nickname,
                              'email' => $email,
                              'openid' => $message['FromUserName'],
                              'extras' => $user_wechat ,
                              'check_subscribe' => 1,
                              'password' => bcrypt($password),
                          ];

                        //  dd($data);
                        $user =  User::create($data);
                        //$user->check_subscribe =true;
                        //$user->save();

                        }
                        return $nickname."等你很久啦!";
                        break;
                      }



                      //return "11".$message['Event'];
                      break;

                 case 'voice':
                     $ToUserName = $message['ToUserName'];
                     $FromUserName = $message['FromUserName'];
                     $CreateTime = $message['CreateTime'];
                     $MsgId = $message['MsgId'];
                     $Format = $message['Format'];
                     $Media_Id = $message['MediaId'];




                   //  $Recognition = $message['Recognition'];
                   /*
                     $stream = $app->media->get($Media_Id); //这里好像不行
                     $save_path = public_path(). '/tmp/';
                     $stream->save($save_path,md5($Media_Id).".amr");

                     //google Speech

                     $projectId = 'speech-test@erudite-imprint-186800.iam.gserviceaccount.com';

                     # Instantiates a client
                     $speech = new SpeechClient([
                         'projectId' => $projectId,
                         'languageCode' => 'en-US',
                     ]);



                     # The name of the audio file to transcribe
                     $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

                     # The audio file's encoding and sample rate
                     $options = [
                         'encoding' => 'AMR',
                         'sampleRateHertz' => 8000,
                     ];

                     # Detects speech in the audio file
                     $results = $speech->recognize(fopen($fileName, 'r'), $options);
                     $tmp ="";
                     foreach ($results as $result) {
                         $tmp .= 'google: ' . $result->alternatives()[0]['transcript'] ;
                     }
                     echo $tmp ;


                     //end google speech
                     */

                     $stream = $app->media->get($Media_Id); //这里好像不行
                     $save_path = public_path(). '/tmp/';
                     $stream->save($save_path,md5($Media_Id).".amr");

                     $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

                     $userfilename = public_path(). '/voice/uservoice/'.md5($Media_Id).".mp3";

                   //  exec('sox '.$fileName.' '.$userfilename);
                 //  $command ='sox '.$fileName.' '.$userfilename;
                 //  exec($command);




                     $APP_ID=env('APP_ID') ;
                     $API_KEY=env('API_KEY') ;
                     $SECRET_KEY=env('SECRET_KEY');

                   //  const API_KEY = 'QsfgtEHUUrujYOGrSin8UQgy';
                     //const SECRET_KEY = 'bKyrt5qEUUlZvlTt0fch8pDFarTC5ZDt ';

                     $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);

                       $test = $client->asr(file_get_contents($fileName), 'amr', 8000, array(
                         'lan' => 'en',
                     ));

                     unlink($fileName);
                     //echo $test['result'][0];

                     return '你说的是：'.$test['result'][0];
                     break;
               default:
                   $media_list = $app->material->list('news', 0, 3);
                   $mediaId = $media_list['item'][0]['media_id'];

                   $items = array();
                   foreach($media_list['item'] as $media){
                     $item=array();


                     $item['title']=$media['content']['news_item'][0]['title'];
                     $item['url']=$media['content']['news_item'][0]['url'];
                     $item['description']=$media['content']['news_item'][0]['content'];
                     $item['image']=$media['content']['news_item'][0]['thumb_url'];
                     $items[]=new NewsItem($item);
                     //$items[]=
                   }

                   $media = new Media($mediaId, 'mpnews');
                   $news = new News($items);

                   //$result = $app->customer_service->message($news)->to($openId)->send();

                   $result = $app->customer_service->message($media)->to($openId)->send();

                   //return "欢迎您访问中小学生阅读推广公众号！ 我们致力于推广中小学生阅读，感谢您的关注！联系方式: 13590486819";
                   //return $media;
                  break;

             }

               //return "欢迎您访问中小学生阅读推广公众号！ 我们致力于推广中小学生阅读，感谢您的关注！";
         });

         return $app->server->serve();
     }

     public function usermenu(){

          //  $app = app('wechat.mini_program');
          //  $list = $app->menu->list(); //读取已设置菜单

            //$current = $app->menu->current();
            //dd($current);

            //设置个性菜单

          $app = app('wechat.official_account');
          //$app->menu->delete();
            $buttons = [
              [
                  "type" => "click",
                  "name" => "最新活动",
                  "key" =>"LatestEvents"
              ],

                [
                  "type" => "view",
                  "name" => "精选必读好书",
                  "url"  => "https://book.edushu.co"
              ]
          ];

            $matchRule = [
              "tag_id" => "100",
          ];

          //$app->menu->create($buttons, $matchRule);
          $app->menu->create($buttons);
          $current = $app->menu->current();

          $list = $app->menu->list();

          dd($list);
            //设置个性菜单 结束

          //  $list = $app->menu->list(); //读取已设置菜单

            //$current = $app->menu->current();
            //dd($list);
          }

    public function subscribe(){

      //var_dump(session('return_wechat'));

        return view('pages.subscribe');
    }

          // web outh 微信登录验证后保存数据到本地服务器数据库中
    public function wechatoauth(){

      $app = app('wechat.official_account');



      $user = session('wechat.oauth_user.default');

      //$user = $app->user->get($user->id);

$openid =  $user->id;
$email = $user->email;
if($email==false){
  $email = $openid."@edushu.co";
}

$nickname = $user->nickname;
$name = $user->name;
$avatar = $user->avatar;

$password = 'Edushuco2020!@';

      if(User::where('openid',$openid)->count()){

        if ( Auth::attempt(['openid' => $openid,'password' => $password]) ){
          $user_info = User::where('openid',$openid)->first();

          if($user_info->name != $name){
            $user_info->name = $nickname;
            $user_info->save();
          }

          if($user_info->name != $name){
            $user_info->name = $name;
            $user_info->save();
          }

          session(['wechatuser' => $openid]);
          //return redirect(route('books.index'));
          return redirect(route('books.index'));
        //  return redirect(session("return_web_url"));
          //Redirect::back();
          //$oauth->redirect()->send();
        }
      }else{
        $data =[
            'name' => $name,
            'email' => $email,
            'openid' => $openid,
            'extras' => $user->toArray() ,
          //  'check_subscribe' => $user->subscribe,
            'password' => bcrypt($password),
        ];

      //  dd($data);
        User::create($data);
        session(['wechatuser' => $openid]);

        if ( Auth::attempt(['openid' => $openid,'password' => $password]) ){
          //return redirect(session("return_web_url"));
          //return redirect(route('books.index'));
          //Redirect::back();
          return redirect(route('books.index'));
        }
        //Redirect::back();
        return redirect(route('books.index'));
//die("test2");
        //return redirect(route('books.index'));
      }


    }


}
