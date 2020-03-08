@extends('layouts.wechat_default')
@section('title', $book->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <h3><a href="{{route('book.read',$book->id)}}">{{$book->name}}</a></h3>
  <ul>
  @foreach($chapters as $chapter)
    <li><a href="{{route('book.read.chapter',[$book->id,$chapter->id])}}">{{$chapter->title}}</a></li>
  @endforeach
  </ul>
</div>
</div>

</div>
@endsection


@section('Navbar')
<ul class="navbar-nav navbar-right">
  <!-- 登录注册链接开始 -->
  <li class="nav-item dropdown">

      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{env('APP_URL')}}/{{ $book->image }}" class="img-responsive img-circle" width="30px" height="30px">
        目录
      </a>
<div class="dropdown-menu" aria-labelledby="navbarDropdown">
  <ul>
  @foreach($chapters as $chapterItem)
  <li><a href="{{route('book.read.chapter',[$book->id,$chapterItem->id])}}">{{$chapterItem->title}}</a></li>

  @endforeach
  </ul>
</div>
</li>
</ul>

@endsection
