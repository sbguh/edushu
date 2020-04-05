@extends('layouts.wechat_book_app')
@section('title', " - 微信支付 ")


@section('jssdk')
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">

function jsApiCall()
{
  WeixinJSBridge.invoke(
         'getBrandWCPayRequest', {!! $app->jssdk->bridgeConfig($prepayId) !!},
         function(res){
             if(res.err_msg == "get_brand_wcpay_request:ok" ) {
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
@endsection


@section('content')


<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">{{$total_fee}}</span>元</b></font><br/><br/>
<div align="center">
 <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
</div>

@endsection
