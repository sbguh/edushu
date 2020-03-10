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


$(function(){
        $('.weui-navbar__item').on('click', function () {
            $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
        });

        $('.check_1').on('click', function () {
            $('.weui-tab__panel1').css("display","block").siblings().css("display","none");
        });
        $('.check_2').on('click', function () {
            $('.weui-tab__panel2').css("display","block").siblings().css("display","none");
        });
        $('.check_3').on('click', function () {
            $('.weui-tab__panel3').css("display","block").siblings().css("display","none");
        });

    });

</script>
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
                            <div class="weui-flex__item"><div class="placeholder"><img class="cover" src="{{env('APP_URL')}}/{{ $book->image }}" alt="" width="260px"></div></div>
                        </div>


                    </div>
                </div>

                <div class="row page">
                    <div class="page__hd text-center">
                        <h2 class="page__title center"></h2>
                        <p class="text-center">
                        @if($book->chapters()->count())
                                    <a href="{{route('book.read',$book->id)}}" class="weui-btn_cell weui-btn_cell-default text-center">在线免费阅读</a>
                                    @endif</p>
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
              </div>
              <div class="weui-tab__panel2" style="display:none">
                  暂无
              </div>
              <div class="weui-tab__panel3" style="display:none">
                  免费借书.
              </div>
            </div>

        </div>
    </div>
</div>


@endsection
