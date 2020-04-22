<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class UsersController extends Controller
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

        return view('users.show', ['user'=>$user]);

    }



    public function store(Request $request)
    {


        $user   = $request->user();

        $birthday  = $request->input('birthday');
        $real_name  = $request->input('real_name');

        \Log::info("log birthday".$birthday);

        $user->birthday= $birthday;
        $user->real_name= $real_name;
        $user->save();



        return [];

    }

}
