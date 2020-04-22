<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;


class CardsController extends Controller
{
    //

    public function show(Request $request)
    {


        $user   = $request->user();

        session(['return_wechat' =>['url'=>route('users.show'),'name'=> $user->name] ]);

        if($user->phone_number==false){
          return redirect(route('wechat.add.phone'));
        }


        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象

        return view('cards.show', ['user'=>$user]);

    }


}
