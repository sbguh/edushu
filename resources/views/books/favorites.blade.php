@extends('layouts.wechat_default')
@section('title', '我的收藏')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
  <div class="card">
    <div class="card-header">我的收藏</div>
    <div class="card-body">
      <div class="row products-list">
        @foreach($books as $book)
          <div class="col-3 product-item">
            <div class="product-content">
              <div class="top">
                <div class="img">
                  <a href="{{ route('books.show', ['book' => $book->id]) }}">
                    <img src="{{env('APP_URL')}}/{{ $book->image }}" alt="" width="120px">
                  </a>
                </div>
                <a href="{{ route('books.show', ['book' => $book->id]) }}">{{ $book->name }}</a>
              </div>
              <div class="bottom">
                <div class="sold_count">销量 <span>{{ $book->sold_count }}笔</span></div>
                <div class="review_count">评价 <span>{{ $book->review_count }}</span></div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="float-right">{{ $books->render() }}</div>
    </div>
  </div>
</div>
</div>
@endsection
