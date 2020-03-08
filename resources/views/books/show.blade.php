@extends('layouts.wechat_default')
@section('title', $book->name)

@section('jssdk')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
        wx.updateAppMessageShareData({
            title: "{{$book->name}}", // 分享标题
            desc: "免费借阅{{$book->name}}", // 分享描述
            link: "{{route('books.show',$book->id)}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('APP_URL')}}/{{ $book->image }}", // 分享图标
            success: function () {
              // 设置成功
              alert("test ok");
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


</script>
@endsection


@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body product-info">
    <div class="row">
      <div class="col-12">
        <div class="row">
            <div class="col-sm-4 col-xs-12"><img class="cover" src="{{env('APP_URL')}}/{{ $book->image }}" alt="" width="120px">
              <div>@if($book->chapters()->count())
              <a href="{{route('book.read',$book->id)}}"><button class="btn btn-success btn-favor">在线阅读</button></a>
              @endif</div>
            </div>
            <div class="col-sm-8 col-xs-12">
              <button class="btn btn-success btn-favor">购买</button>
              <button class="btn btn-primary btn-add-to-cart">免费借此书</button>
            </div>
        </div>
        <div class="title">{{ $book->name }}</div>
        <div class="price"><label>价格</label><em>￥</em><span>{{ $book->price }}</span></div>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
          {!! $book->description !!}
        </div>
        <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
@endsection
