@extends('layouts.wechat_default')
@section('title', $chapter->title." - ".$book->title)


@section('jssdk')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
    document.getElementById('weaudio').play();
        wx.updateAppMessageShareData({
            title: "{{$chapter->title}} - {{$book->name}}", // 分享标题
            desc: "免费在线阅读中小学生必读书目, 免费借阅!{{$chapter->title}} - {{$book->name}}", // 分享描述
            link: "{{route('book.read.chapter',[$book->id,$chapter->id])}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('APP_URL')}}/{{ $book->image }}", // 分享图标
            success: function () {
            }
          })

          wx.updateTimelineShareData({
            title: "{{$chapter->title}} - {{$book->name}}", // 分享标题
            desc: "免费在线阅读中小学生必读书目, 免费借阅!{{$chapter->title}} - {{$book->name}}", // 分享描述
            link: "{{route('book.read.chapter',[$book->id,$chapter->id])}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('APP_URL')}}/{{ $book->image }}", // 分享图标
              success: function () {
                // 设置成功
              }
            })

            wx.error(function(res){
            });


var audio = document.getElementById("weaudio");
audio.load();
audio.play();
document.addEventListener("WeixinJSBridgeReady", function () {
        audio.play();
}, false);
audioAutoPlay();

}


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
