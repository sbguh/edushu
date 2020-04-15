@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                  <div class="weui-cell__bd">
                      <span style="vertical-align: middle;"><a class="nav-link" href="{{ route('wechatoauth') }}">点击一键登录</a></span>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
