@extends('layouts.rent_app')
@section('title', $novel->title)

@section('jssdk')

@endsection


@section('content')
<div class="page">

<van-nav-bar
  title=""
  left-text="返回"
  right-text=""
  left-arrow
  @click-left="onClickLeftNovel"
/></van-nav-bar>

<van-tabs v-model="active">

  <van-tab title="详细">
    <div class="page">
      <div class="page__hd">

        <div class="weui-flex">
            <div class="weui-flex__item"><div class="placeholder" style="padding:5px;"><img src="{{ Storage::disk('edushu')->url($novel->image) }}" width="180px"></div></div>
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
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">字数:</label> <span class="weui-form-preview__value">{{$novel->words/10000}}万字</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">作者:</label> <span class="weui-form-preview__value">{{$novel->author}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">借阅:</label> <span class="weui-form-preview__value">{{$novel->rent_count}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">浏览:</label> <span class="weui-form-preview__value">{{$novel->count}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">价格:</label> <span class="weui-form-preview__value">￥{{$novel->price}}</span></div>
            </div>

        </div>
        <div class="weui-flex" class="weui-tabbar" style="padding:15px 5px;">
          <van-goods-action-icon icon="cart-o" text="购物车" badge="0" /></van-goods-action-icon>
            @if($favored)
           <van-goods-action-icon icon="star" text="已收藏" class="btn-disfavor"  color="blue" /> </van-goods-action-icon>
           @else
           <van-goods-action-icon icon="star" text="未收藏" class="btn-favor" color="#ff5000" /> </van-goods-action-icon>
           @endif
          <van-goods-action-button type="warning" text="借书" /> </van-goods-action-button>
          <van-goods-action-button type="danger" text="在线购买" /></van-goods-action-button >
        </div>





        <article class="weui-article">
          <van-divider>共读书房推荐</van-divider>
          <div>{!!$novel->description!!}</div>
        </article>

      </div>






  </div>
  </van-tab>
  <van-tab title="谁在借阅">

<div class="page">
  <div class="weui-cells">
@foreach($rent_book as $rent)

            <div class="weui-cell weui-cell_active">
                <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
                     <img src="{{ isset($rent->user->extras->headimgurl)?$rent->user->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
                    <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{$rent->user->level?$rent->user->level:0}}级</span>
                </div>
                <div class="weui-cell__bd">
                    <p>{{$rent->user->name}} </p>
                    <p style="font-size: 13px; color: #888;">阅读级别:  {{$rent->user->level?$rent->user->level:0}}级, 阅读字数:  {{$rent->user->read_count?($rent->user->read_count/10000).'万字':0}}， 借过: {{$rent->user->rent_count?$rent->user->rent_count:0}}本</p>
                </div>
            </div>


@endforeach
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
                        <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{$rent->user->level?$rent->user->level:0}}级</span>
                    </div>
                    <div class="weui-cell__bd">
                        <p>{{$rent->user->name}} </p>
                        <p style="font-size: 13px; color: #888;">阅读级别:  {{$rent->user->level?$rent->user->level:0}}级, 阅读字数:  {{$rent->user->read_count?($rent->user->read_count/10000).'万字':0}}， 借过: {{$rent->user->rent_count?$rent->user->rent_count:0}}本</p>
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



  });
</script>

@endsection
