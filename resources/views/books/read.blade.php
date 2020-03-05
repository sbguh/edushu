@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <h3><a href="{{route('book.read',$book->id)}}">{{$book->name}}</a></h3>
  <ul>
  @foreach($chapters as $chapter)
    <li><a href="{{route('book.read.chapter',[$book->id,$chapter->id])}}">{{$chapter->title}}</a></li>
  @endforeach
  </ul>
</div>
</div>

</div>
@endsection
