@extends('layouts.app')
@section('title', '查看订单')

@section('content')
  <div class="card-header">订单详情</div>
<div class="row">
<div class="col-lg-10 offset-lg-1">

<div class="card">

  <div class="card-body">

<div class="weui-form-preview__bd">
      @foreach($order->products as $index => $item)


                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">商品</label>
                    <span class="weui-form-preview__value"><a href="{{ $item->product->link }}">{{$item->product_name}}</a></span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">单价</label>
                    <span class="weui-form-preview__value">￥{{ $item->price }}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">数量</label>
                    <span class="weui-form-preview__value">{{ $item->amount }}</span>
                </div>

                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">小计</label>
                    <span class="weui-form-preview__value">￥{{ number_format($item->price * $item->amount, 2, '.', '') }}</span>
                </div>
      @endforeach
</div>
    <div class="order-bottom">
      <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">收货地址：</label>
                    <span class="weui-form-preview__value">{{ $order->address }}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">订单备注：</label>
                    <span class="weui-form-preview__value">{{ $order->remark ?: '-' }} </span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">订单编号：</label>
                    <span class="weui-form-preview__value">{{ $order->order_number }}</span>
                </div>

                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">订单总价：</label>
                    <span class="weui-form-preview__value">￥{{ $order->total_amount }}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">订单状态：</label>
                    <span class="weui-form-preview__value">
                      @if($order->paid_at)
                        @if($order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)
                          已支付
                        @else
                          {{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}
                        @endif
                      @elseif($order->closed)
                        已关闭
                      @else
                        未支付
                      @endif

                    </span>
                </div>
      </div>


    </div>

    @if($order->paid_at==false)
    <div class="clearfix" style="text-align:center">

      <van-goods-action-button type="danger" onclick="callpay()"  class="btn-add-to-cart" text="立即支付" /> </van-goods-action-button>
    </div>
    @endif

  </div>
</div>
</div>
</div>
@endsection


@section('scriptsAfterJs')

@if(env('WE_CHAT_DISPLAY', true)&&$prepayId)

<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">

function jsApiCall()
{
  WeixinJSBridge.invoke(
         'getBrandWCPayRequest', {!! $app->jssdk->bridgeConfig($prepayId) !!},
         function(res){
             if(res.err_msg == "get_brand_wcpay_request:ok" ) {

               location.reload();
                  // 使用以上方式判断前端返回,微信团队郑重提示：
                  // res.err_msg将在用户支付成功后返回
                  // ok，但并不保证它绝对可靠。
             }
         }
     );
}

function callpay()
{
  if (typeof WeixinJSBridge == "undefined"){
      if( document.addEventListener ){
          document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
      }else if (document.attachEvent){
          document.attachEvent('WeixinJSBridgeReady', jsApiCall);
          document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
      }
  }else{
      jsApiCall();
  }
}


</script>
@endif
@endsection

@section('search')

@endsection
