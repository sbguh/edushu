@extends('layouts.wechat_default')
@section('title', $chapter->title." - ".$book->title)


@section('jssdk')

<script type="text/javascript" charset="utf-8">
$(function(){

  const app = new Vue({
      el: '#app',
      data: {
        loading: true
      }
  });

  var loading;
  var audio = document.getElementById("weaudio");
  audio.load();
  audio.play();
  document.addEventListener("WeixinJSBridgeReady", function () {
          audio.play();
  }, false);


  audio.addEventListener("canplay", function(){//监听audio是否加载完毕，如果加载完毕，则读取audio播放时间
       //console.log('mp3加载完成............')
       app.loading = false;
   });

});

</script>
@endsection


@section('content')

<div class="page">
  <div class="weui-flex">

    @if($prev)
    <div class="weui-flex__item"><div class="placeholder">上一章: <a href="{{route('book.read.chapter',[$book->id,$prev->id])}}">{{$prev->title}}</a></div></div>
    @endif
    @if($next)

    <div class="weui-flex__item"><div class="placeholder">下一章: <a href="{{route('book.read.chapter',[$book->id,$next->id])}}">{{$next->title}}</a></div></div>
    @endif

  </div>
</div>
<div class="row page">


    <div class="page__hd">
        <h1 class="page__title"></h1>
        <p class="page__desc">{{$book->title}}</p>
    </div>
    <div class="page__bd">
        <article class="weui-article">
            <section>
                <h2 class="title">{{$chapter->title}}</h2>
                <p>@if($chapter->audio)
                听书: <audio src="{{env('APP_URL')}}/uploads/{{$chapter->audio}}" controls="controls" autoplay id="weaudio" width="100%" style="width:100%"></audio>
                @endif</p>
                <section>

                    {!!$chapter->content!!}
                </section>

            </section>
        </article>
    </div>

    <div class="weui-flex">

      @if($prev)
      <div class="weui-flex__item"><div class="placeholder">上一章: <a href="{{route('book.read.chapter',[$book->id,$prev->id])}}">{{$prev->title}}</a></div></div>
      @endif
      @if($next)

      <div class="weui-flex__item"><div class="placeholder">下一章: <a href="{{route('book.read.chapter',[$book->id,$next->id])}}">{{$next->title}}</a></div></div>
      @endif

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

  @foreach($chapters as $chapterItem)

        <div class="weui-cell  weui-cell_example">
             <div class="weui-cell__ft"><a href="{{route('book.read.chapter',[$book->id,$chapterItem->id])}}">{{$chapterItem->title}}</a></div>
         </div>


  @endforeach


</div>
</li>
</ul>

@endsection
