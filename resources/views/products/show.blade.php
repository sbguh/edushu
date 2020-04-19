@extends('layouts.app')
@section('title', $product->title)

@section('content')

<div class="row products-show-page">
<div class="col-lg-10 offset-lg-1">
<div class="card">

  @if ($errors->any())
<div class="jd_login_panle_input" style="padding: 0 26px; font-size: 13px; color: red;">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

  <div class="card-body product-info">


    <div class="row">
      <div class="col-5">
        <img class="cover" src="{{Storage::disk('edushu')->url($product->image)  }}" width="180px" alt="">
      </div>
      <div class="col-7">

        @if($product->skus()->count()==1)
        <div class="title"> {{ $product->skus()->first()->title }} </div>
          <div class="price"><label>价格</label><em>￥</em><span>{{ $product->skus()->first()->price }}</span></div>
        @else
        <div class="title">{{ $product->name }}</div>
          <div class="price"><label>价格</label><em>￥</em><span>{{ $product->price }}</span></div>
        @endif

        <div class="skus">

          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            @if($product->skus()->count()==1)
              <input type="hidden" name="skus" class="skus" autocomplete="off" value="{{ $product->skus()->first()->id }}">
            @else
            <label>选择</label>
            @foreach($product->skus as $sku)

            <label
                class="btn sku-btn"
                data-price="{{ $sku->price }}"
                data-stock="{{ $sku->stock }}"
                data-toggle="tooltip"
                title="{{ $sku->description }}"
                data-placement="bottom">
              <input type="radio" name="skus" class="skus" autocomplete="off" value="{{ $sku->id }}"> {{ $sku->title }}
            </label>
            @endforeach

            @endif


            <input type="hidden" name="item_type" class="skus" autocomplete="off" value="Product_sku">


          </div>
        </div>
        <div class="cart_amount"><label>数量</label><input type="text" class="form-control form-control-sm" value="1"><span>件</span><span class="stock"></span></div>
        <div class="buttons">
          <van-goods-action-button type="danger" class="btn-add-to-cart" text="立即购买" /></van-goods-action-button >
        </div>
      </div>
    </div>
    <div class="product-detail">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="true">商品详情</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#product-reviews-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab" aria-selected="false">用户评价</a>
        </li>
      </ul>
      <div class="tab-content image_fix">
        <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
          {!! $product->description !!}
        </div>
        <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
        </div>
      </div>
    </div>
  </div>

</div>
</div>
</div>

@endsection

@section('scriptsAfterJs')
<script>
  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
    $('.sku-btn').click(function () {
      $('.product-info .price span').text($(this).data('price'));
      $('.product-info .stock').text('库存：' + $(this).data('stock') + '件');
      if( $(this).data('stock')==0){
        $(".btn-add-to-cart").attr("style","display:none;");
      }else{
        $(".btn-add-to-cart").attr("style","display:block");
      }
    });


    $('.btn-favor').click(function () {
      // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
      axios.post('{{ route('products.favor', ['product' => $product->id]) }}')
        .then(function () { // 请求成功会执行这个回调
          swal('操作成功', '', 'success');
          location.reload();
        }, function(error) { // 请求失败会执行这个回调
          // 如果返回码是 401 代表没登录
          if (error.response && error.response.status === 401) {
            swal('请先登录', '', 'error');
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
     axios.delete('{{ route('products.disfavor', ['product' => $product->id]) }}')
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
        item_id: $('label.active input[name=skus]').val(),
        item_type: 'Product_sku',
        amount: $('.cart_amount input').val(),
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

$(".sku-btn").first().click();
  });
</script>

@if(env('WE_CHAT_DISPLAY', true))

<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
        wx.updateAppMessageShareData({
            title: "{{$product->extras->meta_title?$product->extras->meta_title:$product->name}}", // 分享标题
            desc: "{{$product->extras->meta_description?$product->extras->meta_description:$product->name}}", // 分享描述
            link: "{{route('products.show',$product->id)}}",// 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '{{Storage::disk('edushu')->url($product->image)}}', // 分享图标
            success: function () {
              // 设置成功
            }
          })
      });


</script>


@endif

@endsection
