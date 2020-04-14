@extends('layouts.app')
@section('title', $report->title." - 学习报告")

@section('jssdk')

@endsection


@section('content')

<div class="page">
    <div class="page__hd" style="text-align:center;">
        <h1 class="page__title"><a href="{{route('reports.index')}}">学习报告</a></h1>
        <p class="page__desc">编号：{{$report->report_number}}</p>
    </div>
    <div class="page__bd">
        <div class="weui-form-preview">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">名称</label>
                    <em class="weui-form-preview__value">{{$report->title}}</em>
                </div>
            </div>

            <div class="weui-form-preview__bd">
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">学员姓名</label>
                  <span class="weui-form-preview__value">{{$user->real_name?$user->real_name:$user->name}}</span>
              </div>

                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">课程老师</label>
                    <span class="weui-form-preview__value">{{$report->teacher}}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">上课时间</label>
                    <span class="weui-form-preview__value">{{$report->date_time}}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">课程</label>
                    <span class="weui-form-preview__value">{{$classroom->name}}</span>
                </div>
            </div>

        </div>
        <article class="weui-article">
           <section>
              <div>{!!$report->description!!}</div>
           </section>
        </article>
    </div>
</div>

@endsection



@section('scriptsAfterJs')


@endsection
