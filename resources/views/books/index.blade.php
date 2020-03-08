@extends('layouts.wechat_default')
@section('title', '商品列表')

@section('content')
<div class="row">
<div class="col-sm-12 col-xs-12 col-lg-12 ">
<div class="card">
  <div class="card-body">
    <div class="row products-list" >
      @foreach($books as $book)
        <div class="col-xs-2 col-sm-4 col-lg-3 product-item">
          <div class="product-content">
            <div class="top">
              <div class="img"><a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" alt="" width="120px"></a></div>
              <div class="price"><b>￥</b>{{ $book->price }}</div>
              <div class="title">{{ $book->name }}</div>
            </div>
            <div class="bottom">
              <div>@if($book->chapters()->count())
              <a href="{{route('book.read',$book->id)}}"><button class="btn btn-success btn-favor">在线阅读</button></a>
              @endif</div>
              <div class="sold_count">
              <a href="{{route('books.show',$book->id)}}"><button class="btn btn-primary btn-add-to-cart">新书订购</button></a>
              <a href="{{route('books.show',$book->id)}}"><button class="btn btn-primary btn-add-to-cart">免费借</button> </a></div>
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
