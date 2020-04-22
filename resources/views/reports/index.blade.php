@extends('layouts.app')
@section('title'," 学习报告中心".$user->name)

@section('jssdk')

@endsection


@section('content')
<div class="weui-cell weui-cell_active">

    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
         <img src="{{ isset(Auth::user()->extras->headimgurl)?Auth::user()->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
        <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{Auth::user()->level?Auth::user()->level:0}}级</span>
    </div>
    <div class="weui-cell__bd">
        <p>{{Auth::user()->name}} </p>
        <p style="font-size: 13px; color: #888;">账户余额: {{Auth::user()->balance}}, 押金: {{Auth::user()->deposit}}, 阅读级别:  {{Auth::user()->level?Auth::user()->level:0}}级, 阅读字数:  {{Auth::user()->read_count?(Auth::user()->read_count/10000).'万字':0}}， 借过: {{Auth::user()->rent_count?Auth::user()->rent_count:0}}本</p>
    </div>
</div>


<div class="page">
    <div class="page__hd" style="text-align:center;">
        <h3 class="page__title">{{$user->real_name?$user->real_name:$user->name}} 学习报告记录</h3>
    </div>
    <div class="page__bd">
        <div class="weui-form-preview">

            <div class="weui-form-preview__bd">

              @foreach($reports as $report)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label"><a href="{{route('reports.show',$report->report_number)}}">{{$report->date_time}}</a></label>
                  <span class="weui-form-preview__value"><a href="{{route('reports.show',$report->report_number)}}">{{$report->title}}</a></span>
              </div>
              @endforeach

            </div>

        </div>
    </div>

    <div class="float-right">{{ $reports->render() }}</div>

</div>

@endsection



@section('scriptsAfterJs')


@endsection


@section('search')

@endsection
