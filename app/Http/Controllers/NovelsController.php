<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Novel;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Rent;
use Illuminate\Support\Facades\DB;
use App\Models\Favorite;
use Symfony\Component\HttpFoundation\Response;


class NovelsController extends Controller
{
    //

    public function index(Request $request)
    {

        $novels = Novel::orderBy('rent_count','DESC')->paginate(12);
        $novelsLatest = Novel::orderBy('id','DESC')->paginate(12);

        $app = app('wechat.official_account');

        return view('novels.index', ['novels' => $novels,'novelsLatest'=>$novelsLatest,'app'=>$app]);
    }

    public function show(Novel $novel, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。


        $app = app('wechat.official_account');
                $favored = false;
        $novel->count = $novel->count +1;
        $novel->save();
        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favorites()->where('favoriteable_type','App\Models\Novel')->where('favoriteable_id',$novel->id)->first());

        }


        $rent_book = $novel->rents()->where('state','借阅中')->orderBy('id','DESC')->paginate(50);

        $return_book =$novel->rents()->onlyTrashed()->where('state','已还书')->orderBy('id','DESC')->paginate(50);

        $return_book= $return_book->unique('user_id');

        $category= Category::where('name','适读年龄')->select('id')->first();

        $categories = $novel->categories()->where('parent_id',$category->id)->get();
        //$categories = $book->categories()->where('parent_id',)

        $tags = $novel->tags()->get();





        $bookhistory = "";
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象

        return view('novels.show', ['novel' => $novel,'favored'=>$favored,'app'=>$app,'tags'=>$tags,'categories'=>$categories,'user'=>$user,'rent_book'=>$rent_book,'return_book'=>$return_book]);
    }

    public function read(Book $book, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        $chapters = $book->chapters()->get();
        $app = app('wechat.official_account');
        $chapter = Chapter::where('book_id',$book->id)->first();
        return redirect(route('book.read.chapter',[$book->id,$chapter->id]), 301);
        //return view('books.read', ['book' => $book,'chapters'=>$chapters,'app'=>$app]);
    }

    public function chapter(Book $book, Chapter $chapter, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        if($chapter->id ==false){
          $chapter = Chapter::where('book_id',$book->id)->first();
        }
        if($book->id != $chapter->book_id){
          $chapter = Chapter::where('book_id',$book->id)->first();
          return redirect(route('book.read.chapter',[$book->id,$chapter->id]), 301);

        }
        $app = app('wechat.official_account');
        $user = $request->user();

        if($chapter->check_subscribe){
          session(['return_wechat' =>['url'=>route('book.read.chapter',[$book->id,$chapter->id]),'name'=> $chapter->title." - ".$book->name] ]);
          if(!Auth::check()) {
              return redirect(route('wechatoauth'));
          }
          if($user->check_subscribe==false){
            return redirect(route('wechat.subscribe'));
          }

          //return redirect(route('wechat.subscribe'));
        }

        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $bookhistory = UserBookHistory::where('user_id',$user->id)->where('book_id',$book->id)->first();
            if($bookhistory=== null){
              $bookhistory = new UserBookHistory(['user_id'=>$user->id,'book_id'=>$book->id,'chapter_id'=>$chapter->id]);
              $bookhistory->save();
            }else{
              $bookhistory->user_id =$user->id;
              $bookhistory->book_id = $book->id;
              $bookhistory->chapter_id = $chapter->id;
              $bookhistory->save();

            }

            if($user->lasturl=== null){
              $lasturl = new UserLastUrl(['url'=>route("book.read.chapter",[$book->id, $chapter->id]),'title'=>$chapter->title." - ".$book->name]);
              $user->lasturl()->save($lasturl);
            }else{
              $user->lasturl->update(['url'=>route("book.read.chapter",[$book->id, $chapter->id]),'title'=>$chapter->title." - ".$book->name]);
            }
        }




        $chapters = Chapter::where('book_id',$book->id)->get();

        $prev = Chapter::where('book_id',$book->id)->where('id', '<', $chapter->id)->orderBy('id', 'desc')->first();

        $next = Chapter::where('book_id',$book->id)->where('id', '>', $chapter->id)->orderBy('id', 'asc')->first();

        $favored = false;
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象
        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favoriteBooks()->find($book->id));
        }


        return view('books.chapter', ['book' => $book,'chapter'=>$chapter,'prev'=>$prev,'next'=>$next,'chapters'=>$chapters,'app'=>$app,'favored' => $favored]);
    }



    public function favor(Novel $novel, Request $request)
    {
        $user = $request->user();
        $favorite = new Favorite(['user_id' => $user->id]);

        $novel->favorites()->save($favorite);


        return [];
    }


    public function disfavor(Novel $novel, Request $request)
     {
         $user = $request->user();

         $user->favorites()->where('favoriteable_type','App\Models\Novel')->where('favoriteable_id',$novel->id)->first()->delete();

         return [];
     }

     public function favorites(Request $request)
    {
        $books = $request->user()->favoriteBooks()->paginate(16);

        return view('books.favorites', ['books' => $books]);
    }


    public function search($keyword, Request $request)
     {
         //$keyword  = $request->get('keyword');
         //dd( $keyword);
         $result = Book::where('name','like','%'.$keyword.'%')->where('state',1)->select('id','name','image')->get()->toJson();
         return $result;
         //return view('books.favorites', ['books' => $books]);
     }

     public function bookaudio(Book $book, Request $request)
     {
       $audio = public_path()."/uploads/".$book->audio;

       $byteOffset = 0;
      $byteLength = $fileSize = strlen($audio);
       $byteRange = $byteLength - $byteOffset;

        ob_start();
       header("Content-Type: audio/mpeg");
       header('X-Pad: avoid browser bug');
       header('Content-length: ' . filesize($audio));
       //header("Content-Transfer-Encoding: binary");
       header('Content-Disposition: filename="' . $audio);
       header('Accept-Ranges: bytes', true);
       header(sprintf('Content-Range: bytes %d-%d/%d', $byteOffset, $byteLength, $fileSize));
    //   header('Cache-Control: no-cache');
       echo $book->audios->audio;
       //header("Content-Disposition: attachment; filename='Death_Valley.mp3'");
       echo ob_get_clean();

     }

     public function chapteraudio(Chapter $chapter, Request $request)
     {

       $audio = public_path()."/uploads/".$chapter->audio;

       $byteOffset = 0;
	     $byteLength = $fileSize = filesize($audio);
       $byteRange = $byteLength - $byteOffset;

        ob_start();
       header("Content-Type: audio/mpeg");
       header('X-Pad: avoid browser bug');
       header('Content-length: ' . filesize($audio));
       //header("Content-Transfer-Encoding: binary");
       header('Content-Disposition: filename="' . $audio);
       header('Accept-Ranges: bytes', true);
       header(sprintf('Content-Range: bytes %d-%d/%d', $byteOffset, $byteLength, $fileSize));
    //   header('Cache-Control: no-cache');
       echo $chapter->audios->audio;
       //header("Content-Disposition: attachment; filename='Death_Valley.mp3'");
       echo ob_get_clean();
     }




}