<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class PagesController extends Controller
{
    //
    public function root()
    {

      $book = Book::where('state',1)->get();

      
        return view('pages.root');
    }
}
