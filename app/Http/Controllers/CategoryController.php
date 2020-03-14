<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Book;

class CategoryController extends Controller
{
    //

    public function index(Request $request)
    {

        $categories = Category::where('enable',1)->whereNull('parent_id')->get();
        $books = Book::where('state',1)->paginate(8);
      //  dd($categories->hasManyChildren()->get());
        $app = app('wechat.official_account');

        return view('category.index', ['books' => $books,'app'=>$app,'categories'=>$categories]);
    }


    public function show(Category $category, Request $request)
    {

        $books = $category->books()->paginate(8);;
        $app = app('wechat.official_account');

        return view('category.show', ['books' => $books,'app'=>$app,'category'=>$category]);
    }


}
