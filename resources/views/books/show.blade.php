@extends('layouts.wechat_default')
@section('title', $book->name)

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
    <div class="page__bd page__bd_spacing">

        <div class="weui-flex">
            <div class="weui-flex__item"><div class="placeholder"><img class="cover" src="{{env('APP_URL')}}/{{ $book->image }}" alt="" width="80px"></div></div>
            <div class="weui-flex__item"><div class="placeholder">{{ $book->name }}</div></div>
        </div>

        <div class="weui-flex">
            <div class="weui-flex__item"><div class="placeholder">
              @if($book->chapters()->count())
              <a href="{{route('book.read',$book->id)}}" class="weui-btn_cell weui-btn_cell-default">阅读</a>
              @endif
            </div></div>
            <div class="weui-flex__item"><div class="placeholder"><a href="javascript:" class="weui-btn_cell weui-btn_cell-default">购书</a></div></div>
            <div class="weui-flex__item"><div class="placeholder"><a href="javascript:" class="weui-btn_cell weui-btn_cell-primary">借书</a></div></div>
        </div>
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

                @if($book->audio)
              <h2 class="title"><audio src="{{env('APP_URL')}}/uploads/{{$book->audio}}" controls="controls" autoplay id="weaudio" width="100%" style="width:100%"></audio></h2>

              <p v-if="loading">正在加载音频， 请稍后...</p>
              @endif
                <section>


                    {!! $book->description !!}
                </section>

            </section>
        </article>
    </div>
</div>
@endsection
