@extends('layouts.wechat_default')
@section('title', '中小学生必读书目')


@section('jssdk')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData'), false) !!});

  wx.ready(function () {
        wx.updateAppMessageShareData({
            title: "中小学生必读书目", // 分享标题
            desc: "免费在线阅读中小学生必读书目, 免费借阅!", // 分享描述
            link: {{route('books.index')}}, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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
<div class="col-sm-12 col-xs-12 col-lg-12 ">
<div class="card">
  <div class="card-body">
    <div class="row products-list" >
      @foreach($books as $book)
        <div class="col-xs-2 col-sm-4 col-lg-3 product-item">
          <div class="product-content">
            <div class="top">
              <div class="img"><a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" alt="" width="120px"></a></div>
              <div class="price"><b>￥</b>{{ $book->price }}</div>
              <div class="title">{{ $book->name }}</div>
            </div>
            <div class="bottom">
              <div>@if($book->chapters()->count())
              <a href="{{route('book.read',$book->id)}}"><button class="btn btn-success btn-favor">在线阅读</button></a>
              @endif</div>
              <div class="sold_count">
              <a href="{{route('books.show',$book->id)}}"><button class="btn btn-primary btn-add-to-cart">新书订购</button></a>
              <a href="{{route('books.show',$book->id)}}"><button class="btn btn-primary btn-add-to-cart">免费借</button> </a></div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
</div>
</div>
@endsection
