@extends('layouts.wechat_default')
@section('title', $chapter->title." - ".$book->title)


@section('jssdk')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
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
                <audio controls autoplay id="weaudio" preload="auto">
                    <source src="{{env('APP_URL')}}/uploads/{{$chapter->audio}}" type="audio/mp3" />
                </audio>

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


@section('scriptsAfterJs')

<script type="text/javascript" charset="utf-8">
$(function(){
  var loading;
  var audio = document.getElementById("weaudio");
  audio.load();
  audio.play();


  //const player = new Plyr('#player', {autoplay:true,clickToPlay: true,playsinline: true, fullscreen:{enabled: true, fallback: true, iosNative: true}});
  //player.play();
  document.addEventListener("WeixinJSBridgeReady", function () {
          //player.play();
          audio.play();
  }, false);



});

</script>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
    $('.sku-btn').click(function () {
      $('.product-info .price span').text($(this).data('price'));
      $('.product-info .stock').text('库存：' + $(this).data('stock') + '件');
    });

    // 监听收藏按钮的点击事件
    $('.btn-favor').click(function () {
      // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
      axios.post('{{ route('books.favor', ['book' => $book->id]) }}')
        .then(function () { // 请求成功会执行这个回调
          swal('操作成功', '', 'success');
        }, function(error) { // 请求失败会执行这个回调
          // 如果返回码是 401 代表没登录
          if (error.response && error.response.status === 401) {
            swal('请先登录', '', 'error');
            $(window).attr('location','{{route("wechatoauth")}}');
          } else if (error.response && (error.response.data.msg || error.response.data.message)) {
            // 其他有 msg 或者 message 字段的情况，将 msg 提示给用户
            swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
          }  else {
            // 其他情况应该是系统挂了
            swal('系统错误', '', 'error');
          }
        });
    });

    $('.btn-disfavor').click(function () {
    axios.delete('{{ route('books.disfavor', ['book' => $book->id]) }}')
      .then(function () {
        swal('操作成功', '', 'success')
          .then(function () {
            location.reload();
          });
      });
  });


  $('.btn-add-to-cart').click(function () {
    swal({
        title: "请稍后！",
        text: "系统处理中...",
        timer: 1000,
        showConfirmButton: false
        });
        // 请求加入购物车接口
        axios.post('{{ route('cart.add') }}', {
          book_id: {{$book->id}},
          amount: 1,
        })
          .then(function () { // 请求成功执行此回调
            swal('加入购物车成功', '', 'success');
            $(window).attr('location','{{route("cart.index")}}');
          }, function (error) { // 请求失败执行此回调
            if (error.response.status === 401) {

              // http 状态码为 401 代表用户未登陆
              swal('请先登录', '', 'error');

            } else if (error.response.status === 422) {

              // http 状态码为 422 代表用户输入校验失败
              var html = '<div>';
              _.each(error.response.data.errors, function (errors) {
                _.each(errors, function (error) {
                  html += error+'<br>';
                })
              });
              html += '</div>';
              swal({content: $(html)[0], icon: 'error'})
            } else {
              alert(error);
              // 其他情况应该是系统挂了
              swal('系统错误', '', 'error');
            }
          })
      });


  });
</script>
@endsection
