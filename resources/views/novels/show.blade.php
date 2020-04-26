@extends('layouts.app')
@section('title', $novel->title)

@section('jssdk')

@endsection


@section('content')
<div class="page">

<van-tabs v-model="active">

  <van-tab title="详细">
    <div class="page">
      <div class="page__hd">

        <div class="weui-flex">
            <div class="weui-flex__item"><div class="placeholder" style="padding:5px;"><img src="{{ Storage::disk('edushu')->url($novel->image) }}" width="180px"></div>
            <div>
               @if($favored)
                <van-goods-action-icon icon="star" text="已收藏" class="btn-disfavor"  color="blue" /> </van-goods-action-icon>
               @else
                <van-goods-action-icon icon="star" text="未收藏" class="btn-favor" color="#ff5000" /> </van-goods-action-icon>
               @endif
             </div></div>
            <div class="weui-flex__item">
              <div class="placeholder">
                <h3>{{$novel->title}}</h3>
                @if($novel->categories()->count())
                <div class="tags">
                  <div class="clearfix">
                    <label class="weui-form-preview__label">适合:</label>
                    @foreach($novel->categories()->where('parent_id',1)->get() as $category)
                       <van-tag round type="warning"><a style="color:white"  href="{{route('category.novel',$category->id)}}">{{$category->name}}</a></van-tag>
                    @endforeach
                  </div>
                  <div class="clearfix">
                  <label class="weui-form-preview__label"> 标签:</label>
                    @foreach($novel->tags()->get() as $tag)

                       <van-tag mark type="primary"><a style="color:white" href="{{route('tags.novel',$tag->id)}}">{{$tag->name}}</a></van-tag>
                    @endforeach
                  </div>
                </div>
                @endif
              </div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">出版社:</label> <span class="weui-form-preview__value">{{$novel->press}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">作者:</label> <span class="weui-form-preview__value">{{$novel->author}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">浏览:</label> <span class="weui-form-preview__value">{{$novel->count}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">图书价格:</label> <span class="weui-form-preview__value">￥{{$novel->price}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">在线预约:</label> <span class="weui-form-preview__value">￥{{$novel->rent_price}}</span></div>
            </div>

        </div>
          @guest
          <div class="weui-flex" class="weui-tabbar" >
           <van-goods-action-button type="danger" text="尚未登陆" /> </van-goods-action-button>
          </div>

          @else
        <div class="weui-flex" class="weui-tabbar" >
          @if(Auth::user()->cards)
            @if(Auth::user()->cards->active)
              @if(strtotime(Auth::user()->cards->end_date)> strtotime("now"))
              <van-goods-action-button type="danger" class="btn-add-to-cart" text="会员预约借书" /> </van-goods-action-button>
              @else
                <van-goods-action-button type="danger"  text="您的账号已过有效期" /> </van-goods-action-button>
              @endif
            @else
              <van-goods-action-button type="danger"  text="您的账号尚未激活" /> </van-goods-action-button>
            @endif

          @else
          <van-goods-action-button type="danger" text="您尚未成为我们的会员" /> </van-goods-action-button>
          @endif
        </div>
        @endguest





        <article class="weui-article">
          <van-divider>共读书房推荐</van-divider>
          <div>{!!$novel->description!!}</div>
        </article>

      </div>






  </div>
  </van-tab>

  <van-tab title="谁借阅过">
    <div class="page">
      <div class="weui-cells">
    @foreach($return_book as $rent)


                <div class="weui-cell weui-cell_active">
                    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
                         <img src="{{ isset($rent->user->extras->headimgurl)?$rent->user->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
                        <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{$rent->card->user->level?$rent->card->user->level:0}}级</span>
                    </div>
                    <div class="weui-cell__bd">
                        <p>{{$rent->card->user->name}} </p>
                        <p style="font-size: 13px; color: #888;">阅读级别:  {{$rent->card->user->level?$rent->card->user->level:0}}级, 阅读字数:  {{$rent->card->user->read_count?($rent->card->user->read_count/10000).'万字':0}}， 借过: {{$rent->card->user->rent_count?$rent->card->user->rent_count:0}}本</p>
                    </div>
                </div>


    @endforeach
  </div>
</div>
  </van-tab>
  <van-tab title="读后感">暂未开放</van-tab>
</van-tabs>


</div>
@endsection



@section('scriptsAfterJs')
<script>
  $(document).ready(function () {

    // 监听收藏按钮的点击事件
    $('.btn-favor').click(function () {
      // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
      axios.post('{{ route('novels.favor', ['novel' => $novel->id]) }}')
        .then(function () { // 请求成功会执行这个回调
          swal('操作成功', '', 'success');
          location.reload();
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
     axios.delete('{{ route('novels.disfavor', ['novel' => $novel->id]) }}')
       .then(function () {
         swal('操作成功', '', 'success')
           .then(function () {
             location.reload();
           });
       });
   });

   $('.btn-add-to-cart').click(function () {

      // 请求加入购物车接口
      axios.post('{{ route("cart.add") }}', {
        item_id: {{$novel->id}},
        item_type: 'Novel',
        amount: 1,
      })
        .then(function () { // 请求成功执行此回调
          swal('加入购物车成功', '', 'success')
          .then(function() {
          location.href = '{{ route('cart.index') }}';
        });
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

            // 其他情况应该是系统挂了
            swal('系统错误', '', 'error');
          }
        })
    });

  });
</script>

@endsection
