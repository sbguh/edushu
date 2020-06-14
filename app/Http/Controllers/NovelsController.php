<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Novel;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Rent;
use App\Models\Comment;
use App\Models\UserLastUrl;
use App\Models\CommentFile;
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

    public function comment(Novel $novel, Request $request){
      $user = $request->user();
      session(['return_wechat' =>['url'=>route('novel.show',$novel->id),'name'=> $novel->title] ]);
      if($user  == false){
        return response()->json([
            'success' => false,
            'message' => '需要先登录',
        ])->setStatusCode(401);
      }
      $after_read = $request->get('after_read');
      $fileList = $request->get('fileList');
      $title = $request->get('comment_title');
      $type = $request->get('type')?$request->get('type'):0;

      $comment =  new Comment(['content' => $after_read,'type'=>$type,'user_id'=>$user->id,'title'=>$title]);
      //$user->
      //$comment->user()->associate($user);
      $novel->comments()->save($comment);
        if(count($fileList)){
          $image_list = array();
          foreach($fileList as $image){
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image['content'], $result)){

              $type = $result[2];




              $new_file_name = time().".".$type;
              $url_file = env('APP_URL')."/uploads/shufang/".$new_file_name;
              $new_file = public_path()."/uploads/shufang/".$new_file_name;

              $image_list[] = $new_file.$new_file_name;
              $is_successful=file_put_contents($new_file, base64_decode(str_replace($result[1], '', $image['content'])));
              if($is_successful){
                $comment_file = new CommentFile(['type'=>$type,'file'=>$url_file]);
                $comment->files()->save($comment_file);
              }
          }
        }
        //return $fileList;
      }

      return response()->json([
          'success' => true,
          'message' => '发布成功',
          'comment' => $comment,
      ])->setStatusCode(200);


    }

    public function show(Novel $novel, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。


        $app = app('wechat.official_account');
                $favored = false;
        $novel->count = $novel->count +1;
        $novel->save();
        session(['return_wechat' =>['url'=>route('novel.show',$novel->id),'name'=> $novel->title] ]);
        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favorites()->where('favoriteable_type','App\Models\Novel')->where('favoriteable_id',$novel->id)->first());

            if($user->lasturl=== null){

              $lasturl = new UserLastUrl(['url'=>$request->url(),'title'=>$novel->title]);
              $user->lasturl()->save($lasturl);
            }else{
              $user->lasturl->update(['url'=>$request->url(),'title'=>$novel->name]);
            }


        }


        $rent_book = $novel->rents()->where('state','借阅中')->orderBy('id','DESC')->paginate(50);

        $return_book =$novel->rents()->onlyTrashed()->where('state','已还书')->orderBy('id','DESC')->paginate(50);


        $book_after_reads = $novel->comments()->with('user','files')->where('type',0)->orderBy('id','DESC')->get()->toJson();

        $book_tips = $novel->comments()->with('user','files')->where('type',1)->orderBy('id','DESC')->get()->toJson();

        $return_book= $return_book->unique('user_id');

        $category= Category::where('name','适读年龄')->select('id')->first();

        $categories = $novel->categories()->where('parent_id',$category->id)->get();
        //$categories = $book->categories()->where('parent_id',)

        $tags = $novel->tags()->get();





        $bookhistory = "";
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象

        return view('novels.show', ['novel' => $novel,'book_after_reads'=>$book_after_reads,'book_tips'=>$book_tips,'favored'=>$favored,'app'=>$app,'tags'=>$tags,'categories'=>$categories,'user'=>$user,'rent_book'=>$rent_book,'return_book'=>$return_book]);
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
         $result = Novel::where('title','like','%'.$keyword.'%')->where('on_sale',1)->select('id','title','image')->get()->take(3)->toJson();
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
