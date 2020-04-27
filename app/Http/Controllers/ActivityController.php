<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\User;
use App\Models\UserClassRoom;

class ActivityController extends Controller
{
    //

    public function index(Request $request)
    {
      $user   = $request->user();

      $reports = Report::whereIn('userclassroom_id',$user->classrooms()->pluck('id'))->orderBy('id','DESC')->paginate(8);

      session(['return_wechat' =>['url'=>route('reports.index'),'name'=> $user->name] ]);

      return view('reports.index', ['user'=>$user,'reports'=>$reports]);


    }
    public function show(Activity $activity, Request $request)
    {



        session(['return_wechat' =>['url'=>route('activities.show',$activity->id),'name'=> $activity->name] ]);

        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象

        return view('activities.show', ['activity'=>$activity]);

    }



}
