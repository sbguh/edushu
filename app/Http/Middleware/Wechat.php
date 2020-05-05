<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class Wechat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    //  $wechatuser = session('wechatuser');

    $app = app('wechat.official_account');



    $user = session('wechat.oauth_user.default');

    //$user = $app->user->get($user->id);
if($user){
$openid =  $user->id;
$email = $user->email;
if($email==false){
  $email = $openid."@edushu.co";
}

$nickname = $user->nickname;
$name = $user->name;
$avatar = $user->avatar;
$subscribe = 0;

$user_wechat = $app->user->get($openid);

$subscribe= $user_wechat['subscribe'];
if($subscribe==false){
  $subscribe = 0;
}else{
  $subscribe= 1;
}

}else{
  Auth::attempt(['email' => 'liyuping1984@gmail.com','password' => 'sbguh123']);
  return $next($request);
}



$password = 'Edushuco2020!@';

    if(User::where('openid',$openid)->count()){

      if ( Auth::attempt(['openid' => $openid,'password' => $password]) ){
        $user_info = User::where('openid',$openid)->first();
        if($subscribe !=$user_info->check_subscribe){
          $user_info->check_subscribe = $subscribe;
          $user_info->save();
        }
        $user_info->extras = $user->toArray();
        $user_info->save();

        if($user_info->name != $name){
          $user_info->name = $nickname;
          $user_info->save();
        }

        if($user_info->name != $name){
          $user_info->name = $name;
          $user_info->save();
        }

        session(['wechatuser' => $openid]);
        return $next($request);
    }else{
      $data =[
          'name' => $name,
          'email' => $email,
          'openid' => $openid,
          'check_subscribe'=>$subscribe,
          'extras' => $user->toArray() ,
          'check_subscribe' => $subscribe,
          'password' => bcrypt($password),
      ];

    //  dd($data);
      User::create($data);
      session(['wechatuser' => $openid]);

      if ( Auth::attempt(['openid' => $openid,'password' => $password]) ){
          return $next($request);
      }

    }


    }
    return $next($request);
}
}
