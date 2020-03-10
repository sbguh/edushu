@extends('layouts.wechat_default')
@section('title', $book->name)

@section('jssdk')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
        document.getElementById('weaudio').play();
        wx.updateAppMessageShareData({
            title: "{{$book->name}}", // 分享标题
            desc: "免费借阅{{$book->name}}", // 分享描述
            link: "{{route('books.show',$book->id)}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('APP_URL')}}/{{ $book->image }}", // 分享图标
            success: function () {
              // 设置成功
            }
          })

          wx.updateTimelineShareData({
            title: "{{$book->name}}", // 分享标题
            desc: "免费借阅{{$book->name}}", // 分享描述
            link: "{{route('books.show',$book->id)}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('APP_URL')}}/{{ $book->image }}", // 分享图标
              success: function () {
                // 设置成功
              }
            })

            wx.error(function(res){

});

      });
      $(function() {


        function audioAutoPlay(){
            var audio = document.getElementById("weaudio");
            audio.play();
            document.addEventListener("WeixinJSBridgeReady", function () {
                    audio.play();
            }, false);



        }
        audioAutoPlay();


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
                <section>
                  @if($book->audio)
                  试听: <audio src="{{env('APP_URL')}}/uploads/{{$book->audio}}" controls="controls" autoplay id="weaudio" style="width:100%; height:100%;object-fit:fill"></audio>
                  @endif

                    {!! $book->description !!}
                </section>

            </section>
        </article>
    </div>
</div>
@endsection
