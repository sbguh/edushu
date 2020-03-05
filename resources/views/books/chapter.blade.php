@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <h3>{{$chapter->title}}</h3>
<div>{!!$chapter->content!!}</div>
@if($prev)
<div>上一章: <a href="{{route('book.read.chapter',[$book->id,$prev->id])}}">{{$prev->title}}</a></div>
@endif


@if($next)
<div>下一章: <a href="{{route('book.read.chapter',[$book->id,$next->id])}}">{{$next->title}}</a></div>
@endif

</div>
</div>

</div>
@endsection
