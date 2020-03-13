<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Category;

class BooksController extends Controller
{
    //

    public function index(Request $request)
    {

        $books = Book::where('state',1)->paginate();
        $app = app('wechat.official_account');

        return view('books.index', ['books' => $books,'app'=>$app]);
    }

    public function show(Book $book, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        if (!$book->state) {
            throw new \Exception('商品未上架');
        }
        $app = app('wechat.official_account');
        $category= Category::where('name','适读年龄')->select('id')->first();

        $categories = $book->categories()->where('parent_id',$category->id)->get();
        //$categories = $book->categories()->where('parent_id',)

        $tags = $book->tags()->get();
        $user = session('wechat.oauth_user.default');

        $favored = false;
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象
        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favoriteBooks()->find($book->id));
        }


        return view('books.show', ['book' => $book,'app'=>$app,'favored' => $favored,'tags'=>$tags,'categories'=>$categories,'user'=>$user]);
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



    public function favor(Book $book, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteBooks()->find($book->id)) {
            return [];
        }

        $user->favoriteBooks()->attach($book);

        return [];
    }


    public function disfavor(Book $book, Request $request)
     {
         $user = $request->user();
         $user->favoriteBooks()->detach($book);

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




}
