@extends('layouts.app')
@section('title'," 学习报告中心".$user->name)

@section('jssdk')

@endsection


@section('content')


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
