@extends('layouts.app')
@section('title', $activity->name." - 活动中心")

@section('jssdk')

@endsection


@section('content')

@if(count($activity->users))
<van-notice-bar color="#1989fa" left-icon="volume-o">
  参与活动用户
              @foreach($activity->users as $user)
                 <img src="{{$user->extras->avatar}}" width="18px"> 
              @endforeach
</van-notice-bar>


@endif


<div class="page">

    <div class="page__bd">
        <div class="weui-form-preview">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">名称</label>
                    <em class="weui-form-preview__value">{{$activity->name}}</em>
                </div>
            </div>

            <div class="weui-form-preview__bd">
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">活动时间</label>
                  <span class="weui-form-preview__value">{{$activity->date_time}}</span>
              </div>

                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">活动地点</label>
                    <span class="weui-form-preview__value">{{$activity->address}}</span>
                </div>
            </div>

        </div>
        <article class="weui-article">
           <section>
              <div>{!!$activity->description!!}</div>
           </section>
        </article>
    </div>
</div>

@endsection



@section('scriptsAfterJs')


@endsection


@section('search')

@endsection
