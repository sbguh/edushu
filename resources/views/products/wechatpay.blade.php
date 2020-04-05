@extends('layouts.app')
@section('title', " - 微信支付 ")


@section('jssdk')
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
wx.config({!! $app->jssdk->bridgeConfig($prepayId) !!});




</script>
@endsection


@section('content')


<h1>微信支付</h1>

@endsection
