@extends('layouts.wechat_default')
@section('title', '中小学生必读书目')


@section('jssdk')
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

wx.ready(function () {
    wx.updateAppMessageShareData({
        title: "精选好书, 中小学生必读图书", // 分享标题
        desc: "在线听书，在线阅读电子书，精选中小学生必读好书", // 分享描述
        link: "{{route('books.index')}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: "https://book.edushu.co/uploads/images/logo1.png", // 分享图标
        success: function () {
        }
      })


      wx.updateTimelineShareData({
          title: "精选好书, 中小学生必读图书", // 分享标题
          desc: "在线听书，在线阅读电子书，精选中小学生必读好书", // 分享描述
          link: "{{route('books.index')}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: '', // 分享图标
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


<div class="page">
  <div class="page__hd">
    <h6 class="page__title">欢迎关注公众号获取更多免费资源！</h6>
      <p class="page__desc"><img src="https://book.edushu.co/uploads/images/wechat1.png" width="100%"/></p>
  </div>

  <div class="page__hd">
      <p class="page__desc page_header_title">猜你想要</p>
  </div>
  <div class="row">
    @foreach($books as $book)
    <div class="col-5" style="border:1px solid #ededed;margin:5px;padding:5px;">
      <div class="weui-flex__item ">
        <div class="placeholder ">
          <a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" alt="" width="110px"></a>
          <div class="title">{{ $book->name }}</div>
          @if($book->categories()->count())
          <div class="tags">
            <div class="clearfix">
              <div class="float-left title">适合:</div>
              @foreach($book->categories()->where('parent_id',1)->take(2)->get() as $category)
                 <p><a href="{{route('category.show',$category->id)}}">{{$category->name}}</a></p>
              @endforeach
            </div>
            <div class="clearfix">
              <div class="float-left title">标签:</div>
              @foreach($book->tags()->take(2)->get() as $tag)
                 <p><a href="{{route('tags.show',$tag->id)}}">{{$tag->name}}</a></p>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
</div>
<div style="margin-bottom:10px;">{{ $books->render() }}</div>  <!-- 只需要添加这一行 -->
</div>
@endsection
