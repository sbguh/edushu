@extends('layouts.app')
@section('title', $user->name)

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


<van-collapse v-model="activeNames">
  <van-collapse-item title="借阅中" name="1">
        @foreach($rent_book as $rent)


        <van-card
          thumb= "{{ Storage::disk('edushu')->url($rent->novel->image) }}"
          thumb-link="{{route('rent.show',$rent->rent_number)}}"
        >
        <template #title>
        <a href="{{route('rent.show',$rent->rent_number)}}">{{  $rent->novel->title }}</a>
        </template>

        <template #desc>
        <p>{{  $rent->novel->sub_title }}</p>
        <p>借阅开始日期: {{$rent->created_at}} </p>
        <p>还书截至日期: {{$rent->return_time}} </p>

        </template>



          <template #footer>

            </template>
        </van-card>
        @endforeach
  </van-collapse-item>
  <van-collapse-item title="历史记录" name="2">

    @foreach($return_book as $rent)
    <van-card
      thumb= "{{ Storage::disk('edushu')->url($rent->novel->image) }}"
      thumb-link="{{route('rent.show',$rent->rent_number)}}"
    >
    <template #title>
    <a href="{{route('rent.show',$rent->rent_number)}}">{{  $rent->novel->title }}</a>
    </template>

    <template #desc>
    <div>{{  $rent->novel->sub_title }}</div>
    <p>借阅日期: {{$rent->created_at}} </p>
    <p>还书日期: {{$rent->deleted_at}} </p>

    </template>



      <template #footer>

        </template>
    </van-card>
    @endforeach

  </van-collapse-item>
</van-collapse>


@endsection



@section('scriptsAfterJs')


@endsection


@section('search')

@endsection
