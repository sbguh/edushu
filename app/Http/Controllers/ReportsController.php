<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\User;
use App\Models\UserClassRoom;

class ReportsController extends Controller
{
    //

    public function index(Request $request)
    {
      $user   = $request->user();

      $reports = Report::whereIn('userclassroom_id',$user->classrooms()->pluck('id'))->orderBy('id','DESC')->paginate(8);

      return view('reports.index', ['user'=>$user,'reports'=>$reports]);


    }
    public function show($report_number, Request $request)
    {


        $report = Report::where('report_number',$report_number)->first();

        $userclassroom = $report->userclassroom;

        $classroom = $userclassroom->classroom;


        $user =$userclassroom->user;

        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象

        return view('reports.show', ['report'=>$report,'classroom' => $classroom,'user'=>$user]);

    }


    public function novel(Tag $tag, Request $request)
    {

        $novels = $tag->novels()->orderBy('id','DESC')->paginate(8);;
        $app = app('wechat.official_account');

        return view('tags.novel', ['tag' => $tag,'app'=>$app,'novels'=>$novels]);
    }

}
