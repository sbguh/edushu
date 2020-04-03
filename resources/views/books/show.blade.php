@extends('layouts.wechat_book_app')
@section('title', $book->name)

@section('jssdk')

@endsection


@section('content')

<div class="page">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-navbar">
                <div class="weui-navbar__item check_1 weui-bar__item_on ">
                    图书
                </div>
                <div class="weui-navbar__item check_2">
                    详情
                </div>
                <div class="weui-navbar__item check_3">
                    评价
                </div>
            </div>
            <div class="weui-navbar-panel">
              <div class="weui-tab__panel1" style="display:block">
                <div class="page">
                    <div class="page__bd page__bd_spacing">

                        <div class="weui-flex">
                            <div class="weui-flex__item"><div class="placeholder"><img class="cover" src="{{ Storage::disk('edushu')->url($book->image) }}" alt="" width="260px"></div></div>
                        </div>


                    </div>
                </div>

                <div class="row page">
                    <div class="page__hd text-center">
                        <h2 class="page__title center"></h2>
                        <p class="weui-tabbar__label" style="width:280px;text-align:center;">

                          @if($favored)
         <button class="btn btn-danger btn-disfavor">取消收藏</button>
       @else
         <button class="btn btn-success btn-favor">❤ 收藏</button>
       @endif
       @if($book->chapters()->count())

                   @endif
                   @if($book->chapters()->count())
                   @if($bookhistory)
                   <a href="{{route('book.read.chapter',[$book->id,$bookhistory->chapter_id])}}"><button class="btn btn-primary btn-read-online">继续阅读</button></a>
                   @else
                   <a href="{{route('book.read',$book->id)}}"><button class="btn btn-primary btn-read-online">在线阅读</button></a>
                   @endif

                   @endif
     </p>
     @if($book->categories()->count())
     <div class="tags">
       <div class="clearfix">
         <div class="float-left title">适合:</div>
         @foreach($book->categories()->where('parent_id',1)->get() as $category)
            <p><a href="{{route('category.show',$category->id)}}">{{$category->name}}</a></p>
         @endforeach
       </div>
       <div class="clearfix">
         <div class="float-left title">标签:</div>
         @foreach($book->tags()->get() as $tag)
            <p><a href="{{route('tags.show',$tag->id)}}">{{$tag->name}}</a></p>
         @endforeach
       </div>
     </div>
     @endif
                    </div>
                    <div class="page__bd">
                        <article class="weui-article">
                          <section>
                              {!! $book->description !!}
                          </section>
                        </article>
                    </div>
                </div>
              </div>
              <div class="weui-tab__panel2" style="display:none">
                  <p>暂无.</p>
              </div>
              <div class="weui-tab__panel3" style="display:none">
                  暂无.
              </div>
            </div>

        </div>
    </div>
</div>


@endsection



@section('scriptsAfterJs')

<script type="text/javascript" charset="utf-8">


$(function(){


//  alert(blob);

//  var audio = document.getElementById("weaudio");
//  audio.load();
//  audio.play();
//alert(player);
  var loading;
const player = new Plyr('#player', {autoplay:true,clickToPlay: true,playsinline: true});
player.play();
document.addEventListener("WeixinJSBridgeReady", function () {
        player.play();
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




@section('footerBar')
<div class="col-xs-12">
  <footer class="footer">
    <nav>

@if($book->audio)





  <div class="container" >
    <footer class="footer" >
      <div class="row" >

        <div class="col-xs-12 col-md-12 col-lg-12  navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-light bg-light navbar-static-bottom" >
          <div class="row"  >
            <div class="col-10" >
              <audio id="player" playsinline autobuffer  src="{{ Storage::disk('edushu')->url($book->audio) }}">
                </audio>

            </div>
            <div class="col-xs-12 col-md-12 col-lg-12">
              <div class="dropup row">
                @if($book->chapters()->count())
                <div class="col-6">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      目录
                    </button>

                    <ul class="dropdown-menu pre-scrollable ">

                         @foreach($book->chapters()->get() as $chapterItem)
                          <li class="list-group-item "><a href="{{route('book.read.chapter',[$book->id,$chapterItem->id])}}">{{$chapterItem->title}}</a></li>
                         @endforeach
                    </ul>
                </div>
                @endif
                <div class="col-6">
                  @if($favored)
                    <button class="btn btn-success btn-disfavor">已收藏</button>
                    @else
                    <button class="btn btn-success btn-favor">❤ 收藏</button>
                    @endif
                </div>
              </div>
          </div>
        </div>
      </div>
      </div>
  </footer>

  </div>


@else

      <div class="page" class="navbar navbar-default navbar-fixed-bottom">
          <div class="page__bd" style="height: 100%;">
              <div class="weui-tab">
                  <div class="weui-tab__panel">

                  </div>
                  <div class="weui-tabbar">
                      <div class="weui-tabbar__item weui-bar__item_on">
                          <div style="display: inline-block; position: relative;">
                              <a href="{{route('root')}}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu01.png" alt="" class="weui-tabbar__icon"></a>
                          </div>
                          <p class="weui-tabbar__label"><a href="{{route('root')}}">首页</a></p>
                      </div>
                      <div class="weui-tabbar__item">
                          <a href="{{route('books.favorites')}}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu02.png" alt="" class="weui-tabbar__icon"></a>
                          <p class="weui-tabbar__label"><a href="{{route('books.favorites')}}">收藏</a></p>
                      </div>
                      <div class="weui-tabbar__item">
                          <div style="display: inline-block; position: relative;">
                              <a href="{{route('category.index')}}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu03.png" alt="" class="weui-tabbar__icon"></a>
                              <span class="weui-badge weui-badge_dot" style="position: absolute; top: 0; right: -6px;"></span>
                          </div>
                          <p class="weui-tabbar__label"><a href="{{route('category.index')}}">分类筛选</a></p>
                      </div>
                      <div class="weui-tabbar__item">
                          <a href="{{ route('wechatoauth') }}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu04.png" alt="" class="weui-tabbar__icon"></a>
                          <p class="weui-tabbar__label"><a href="{{ route('wechatoauth') }}">我的账号</a></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>


@endif

  </nav>
  </footer>
</div>
@endsection
