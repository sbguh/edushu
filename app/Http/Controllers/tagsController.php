<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class tagsController extends Controller
{
    //
    public function show(Tag $tag, Request $request)
    {

        $books = $tag->books()->orderBy('id','DESC')->paginate(8);;
        $app = app('wechat.official_account');

        return view('tags.show', ['tag' => $tag,'app'=>$app,'books'=>$books]);
    }
}
