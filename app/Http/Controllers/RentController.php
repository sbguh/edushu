<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Category;

class RentController extends Controller
{
    //

    public function index(Request $request)
    {
      $user   = $request->user();
      $rent_book = $user->rents()->where('state','借阅中')->orderBy('id','DESC')->paginate(50);
      $return_book =$user->rents()->onlyTrashed()->where('state','已还书')->orderBy('id','DESC')->paginate(50);

      return view('rent.index', ['user'=>$user,'rent_book'=>$rent_book,'return_book'=>$return_book]);


    }
    public function show($rent_number, Request $request)
    {

        $rent = Rent::withTrashed()->where('rent_number',$rent_number)->first();
        $app = app('wechat.official_account');
        $novel = $rent->novel;
        $user =  $rent->user;

        $rent_book = $novel->rents()->where('state','借阅中')->orderBy('id','DESC')->paginate(50);

        $return_book =$novel->rents()->onlyTrashed()->where('state','已还书')->orderBy('id','DESC')->paginate(50);

        $return_book= $return_book->unique('user_id');

        $category= Category::where('name','适读年龄')->select('id')->first();

        $categories = $novel->categories()->where('parent_id',$category->id)->get();
        //$categories = $book->categories()->where('parent_id',)

        $tags = $novel->tags()->get();


        $favored = false;
        $bookhistory = "";
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象

        return view('rent.show', ['rent'=>$rent,'novel' => $novel,'app'=>$app,'tags'=>$tags,'categories'=>$categories,'user'=>$user,'rent_book'=>$rent_book,'return_book'=>$return_book]);

    }


    public function novel(Tag $tag, Request $request)
    {

        $novels = $tag->novels()->orderBy('id','DESC')->paginate(8);;
        $app = app('wechat.official_account');

        return view('tags.novel', ['tag' => $tag,'app'=>$app,'novels'=>$novels]);
    }

}
