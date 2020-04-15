@extends('layouts.app')
@section('title', $user->name)

@section('jssdk')

@endsection


@section('content')


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
