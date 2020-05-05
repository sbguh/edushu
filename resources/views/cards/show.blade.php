@extends('layouts.app')

@section('content')
<div class="weui-cell weui-cell_active">

    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
      <img src="{{ isset(Auth::user()->extras->avatar)?Auth::user()->extras->avatar:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
        <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{Auth::user()->level?Auth::user()->level:0}}级</span>
    </div>
    <div class="weui-cell__bd">
        <p>{{Auth::user()->name}} </p>
        <p style="font-size: 13px; color: #888;">账户余额: {{Auth::user()->balance}}, 押金: {{Auth::user()->deposit}}, 阅读级别:  {{Auth::user()->level?Auth::user()->level:0}}级, 阅读字数:  {{Auth::user()->read_count?(Auth::user()->read_count/10000).'万字':0}}， 借过: {{Auth::user()->rent_count?Auth::user()->rent_count:0}}本</p>
    </div>
</div>

@if($user->cards)
<van-panel title="我的借阅卡" desc="" status="{{$user->cards->active?'':'未激活'}}">
  <div class="page">
      <div class="weui-form-preview__bd">

        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">卡号</label>
            <span class="weui-form-preview__value"><img src='data:image/png;base64,{!!DNS1D::getBarcodePNG($user->cards->card_number, "CODABAR")!!} '/></span>
        </div>

        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">状态</label>
            <span class="weui-form-preview__value">{{$user->cards->active?'已激活使用':'未激活'}}</span>
        </div>
        @if($user->cards->active == 0)
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">激活后可用时长</label>
            <span class="weui-form-preview__value">{{$user->cards->duration}}天</span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">激活方法</label>
            <span class="weui-form-preview__value">暂不支持在线激活，请联系共读书房工作人员: 13590486819</span>
        </div>
        @endif

        @if($user->cards->active == 1)
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">可借书上限</label>
            <span class="weui-form-preview__value">{{$user->cards->rent_limit}}本</span>
        </div>

        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">起始时间</label>
            <span class="weui-form-preview__value">{{$user->cards->start_date}}</span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">到期日期</label>
            <span class="weui-form-preview__value">{{$user->cards->end_date}}</span>
        </div>
        @endif


      </div>
  </div>
</van-panel>
@else

<van-panel title="我的会员卡" desc="" status="暂无">
  <div class="page">
      <div class="weui-form-preview__bd">
        <div>暂时没有可用的会员卡</div>
      </div>
</div>
</van-panel>

@endif


@endsection


@section('scriptsAfterJs')

@endsection
@section('search')

@endsection
