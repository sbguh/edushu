@extends('layouts.wechat_default')
@section('title', $chapter->title." - ".$book->title)


@section('jssdk')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData'), false) !!});

  wx.ready(function () {
        wx.updateAppMessageShareData({
            title: '"'+{{$chapter->title}}+" - "+{{$book->title}}+'"', // 分享标题
            desc: "免费在线阅读中小学生必读书目, 免费借阅!"+{{$chapter->title}}+" - "+{{$book->title}}, // 分享描述
            link: '"'+{{route('book.read.chapter',[$book->id,$chapter->id])}}+'"', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '', // 分享图标
            success: function () {
              // 设置成功
            }
          })
      });


</script>
@endsection


@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <h3>{{$chapter->title}}</h3>
<div>{!!$chapter->content!!}</div>
@if($prev)
<div>上一章: <a href="{{route('book.read.chapter',[$book->id,$prev->id])}}">{{$prev->title}}</a></div>
@endif


@if($next)
<div>下一章: <a href="{{route('book.read.chapter',[$book->id,$next->id])}}">{{$next->title}}</a></div>
@endif

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
