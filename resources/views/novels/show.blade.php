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
                <h6>{{$novel->title}}</h6>
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
              <div class="weui-form-preview__item">
                <span class="weui-form-preview__value">
                  @guest
                    <van-button type="warning" text="尚未登陆" url="{{ route('wechatoauth') }}" /> </van-button>
                  @else

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

                  @endguest
                </span>
              </div>

            </div>

        </div>
        <div class="weui-flex" class="weui-tabbar" style="margin-top:5px;text-align:center;padding:0px 5px;" >

            <van-button type="primary" icon="plus" size="small" @click="showAfterRead" class="btn-add-to-read" text="写读后感" /> </van-button>


            <van-button type="info" icon="add" size="small" @click="showTips" class="btn-add-to-tips" text="做读书笔记" /> </van-button>



        </div>




        <article class="weui-article">
          <van-divider>共读书房推荐</van-divider>
          <div>{!!$novel->description!!}</div>

          <div class="visible-print text-center">
          	{!! QrCode::size(100)->generate(Request::url()); !!}
          	<p>扫描二维码访问本页</p>
          </div>

        </article>

      </div>






  </div>
  </van-tab>

  <van-tab title="读后感">
    <div class="page">

      <div class="weui-cell weui-cell_active" v-for="afterread in book_after_reads">
                    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;" v-if="afterread.user.extras">
                        <img :src="[[afterread.user.extras.avatar]]" style="width: 50px; display: block;"/>
                    </div>
                    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;" v-else>
                        <img src="https://img.yzcdn.cn/vant/user-inactive.png" style="width: 50px; display: block;"/>
                    </div>
                    <div class="weui-cell__bd">
                        <p style="font-size：9px">[[afterread.user.name]]</p>
                        <p style="font-size: 13px; color: #888;">[[afterread.content]]</p>
                        <div v-if="afterread.files">
                          <p v-for="img in afterread.files" @click="ImagePreview([img.file]);"> <img :src="img.file" width="80px"   /></p>
                        </div>
                    </div>
                    <van-divider></van-divider>
    </div>
    <div style="text-align:right;margin-top:10px"><van-button type="info" icon="add" size="small" @click="showAfterRead" class="btn-add-to-tips" text="写读后感" /> </van-button></div>
</div>
  </van-tab>
  <van-tab title="读书笔记">

    <div class="page">

      <div class="weui-cell weui-cell_active" v-for="afterread in book_tips">
                    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;" v-if="afterread.user.extras">
                        <img :src="[[afterread.user.extras.avatar]]" style="width: 50px; display: block;"/>

                    </div>
                    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;" v-else>
                        <img src="https://img.yzcdn.cn/vant/user-inactive.png" style="width: 50px; display: block;"/>
                    </div>
                    <div class="weui-cell__bd">
                        <p>[[afterread.title]]</p>
                        <p style="font-size：9px">[[afterread.user.name]]</p>
                        <p style="font-size: 13px; color: #888;">[[afterread.content]]</p>
                        <div v-if="afterread.files">
                          <p v-for="img in afterread.files" @click="ImagePreview([img.file]);" > <img :src="img.file" width="80px"  /></p>
                        </div>
                    </div>
                    <van-divider></van-divider>
    </div>
</div>

<div style="text-align:right;margin-top:10px"><van-button type="primary" icon="plus" size="small" @click="showTips" class="btn-add-to-read" text="做读书笔记" /> </van-button></div>


  </van-tab>
</van-tabs>


</div>

<van-popup v-model="show_tips"
closeable
  position="bottom"
  :style="{ height: '80%' }">
  <van-field v-model="comment_title" label="输入章节" /></van-field>
  <van-field
  v-model="after_read"
  rows="3"
  autosize
  label=""
  type="textarea"
  placeholder="做读书笔记"
/></van-field>

<van-uploader v-model="fileList" :after-read="afterRead" multiple /></van-uploader>

<div style="margin: 16px;">
  <van-goods-action-button type="info" @click="after_read_click({{$novel->id}},1)" class="add_tips" text="提交" /> </van-goods-action-button>

</div>


</van-popup>


<van-popup v-model="show_after_read"
closeable
  position="bottom"
  :style="{ height: '80%' }">


  <van-field
  v-model="after_read"
  rows="3"
  autosize
  label=""
  type="textarea"
  placeholder="写读后感"
/></van-field>
<van-uploader v-model="fileList" :after-read="afterRead" multiple /></van-uploader>
<div style="margin: 16px;" >
  <van-goods-action-button type="info" @click="after_read_click({{$novel->id}},0)" class="btn-add-to-cart" text="提交" /> </van-goods-action-button>
</div>

</van-popup>


@endsection



@section('scriptsAfterJs')
<script>




  $(document).ready(function () {

    data.book_tips = {!! $book_tips !!}
    data.book_after_reads = {!!$book_after_reads!!}

    $('.after_read_click').click(function () {
     console.log("tes111t")
      alert("tesst");
    });

    $('.add_tips').click(function () {
     console.log("tes111t")
      alert("tesst");
    });

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
