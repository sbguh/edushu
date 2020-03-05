@extends('layouts.app')
@section('title', '商品列表')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body">
    <div class="row products-list">
      @foreach($books as $book)
        <div class="col-3 product-item">
          <div class="product-content">
            <div class="top">
              <div class="img"><a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" width="120px" alt="" width="120px"></a></div>
              <div class="price"><b>￥</b>{{ $book->price }}</div>
              <div class="title">{{ $book->name }}</div>
            </div>
            <div class="bottom">
              <div class="sold_count"><a href="{{route('book.read',$book->id)}}">在线阅读</a></div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
</div>
</div>
@endsection
