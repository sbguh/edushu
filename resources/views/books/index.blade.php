@extends('layouts.wechat_default')
@section('title', '中小学生必读书目')


@section('jssdk')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
        wx.updateAppMessageShareData({
            title: "中小学生必读书目", // 分享标题
            desc: "免费在线阅读中小学生必读书目, 免费借阅!", // 分享描述
            link: "{{route('books.index')}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "https://book.edushu.co/uploads/images/logo1.png", // 分享图标
            success: function () {
            }
          })


          wx.updateTimelineShareData({
              title: "中小学生必读书目", // 分享标题
              desc: "免费在线阅读中小学生必读书目, 免费借阅!", // 分享描述
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

    @foreach($books as $book)
    <div class="weui-flex">
      <div class="weui-flex__item">
        <div class="placeholder">
          <a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" alt="" width="240px"></a>
          <div class="title">{{ $book->name }}</div>
        </div>
      </div>
    </div>
    @endforeach

</div>
@endsection
