@extends('layouts.app')
@section('title'," 订单中心".$user->name)

@section('jssdk')

@endsection


@section('content')


<div class="page">
  <div class="weui-cell weui-cell_active">
      <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
           <img src="{{ isset(Auth::user()->extras->headimgurl)?Auth::user()->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
          <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{Auth::user()->level?Auth::user()->level:0}}级</span>
      </div>
      <div class="weui-cell__bd">
          <p>{{$user->real_name?$user->real_name:$user->name}} </p>
          <p style="font-size: 13px; color: #888;">订单记录</p>
      </div>
  </div>


    <div class="page__bd">
        <div class="weui-form-preview">

            <div class="weui-form-preview__bd">
              @if($orders->count())
              @foreach($orders as $order)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">订单号</label>
                  <span class="weui-form-preview__value"><a href="{{route('orders.show',$order->id)}}">{{$order->order_number}}</a></span>
              </div>
              @endforeach

              @else
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">订单</label>
                  <span class="weui-form-preview__value">暂无</span>
              </div>
              @endif

            </div>

        </div>
    </div>

    <div class="float-right">{{ $orders->render() }}</div>

</div>

@endsection



@section('scriptsAfterJs')


@endsection


@section('search')

@endsection
