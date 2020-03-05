<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Chapter;

class BooksController extends Controller
{
    //

    public function index(Request $request)
    {

        $books = Book::where('state',1)->paginate();

        return view('books.index', ['books' => $books]);
    }

    public function show(Book $book, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        if (!$book->state) {
            throw new \Exception('商品未上架');
        }

        return view('books.show', ['book' => $book]);
    }

    public function read(Book $book, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        $chapters = $book->chapters()->get();
        return view('books.read', ['book' => $book,'chapters'=>$chapters]);
    }

    public function chapter(Book $book, Chapter $chapter, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        if($chapter->id ==false){
          $chapter = Chapter::where('book_id',$book->id)->first();
        }
        if($book->id != $chapter->book_id){
          $chapter = Chapter::where('book_id',$book->id)->first();
          return redirect(route('book.read',$book->id), 301);

        }

        $prev = Chapter::where('book_id',$book->id)->where('id', '<', $chapter->id)->orderBy('id', 'desc')->first();

        $next = Chapter::where('book_id',$book->id)->where('id', '>', $chapter->id)->orderBy('id', 'asc')->first();

        return view('books.chapter', ['book' => $book,'chapter'=>$chapter,'prev'=>$prev,'next'=>$next]);
    }


}
