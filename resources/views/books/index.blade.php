@extends('layouts.wechat_default')
@section('title', '中小学生必读书目')


@section('jssdk')

@endsection


@section('content')


<div class="page">

    @foreach($books as $book)
    <div class="weui-flex">
      <div class="weui-flex__item">
        <div class="placeholder">
          <a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" alt="" width="240px"></a>
          <div class="title">{{ $book->name }}</div>
        </div>
      </div>
    </div>
    @endforeach

</div>
@endsection
