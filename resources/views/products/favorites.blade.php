@extends('layouts.app')
@section('title', '我的收藏')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
  <div class="card">
    <div class="card-header">我的产品收藏</div>
    <div class="card-body">
      <div class="row products-list">
        @foreach($products as $product)
          <div class="col-3 product-item">
            <div class="product-content">
              <div class="top">
                <div class="img">
                  <a href="{{ route('products.show', ['product' => $product->id]) }}">
                    <img src="{{env('APP_URL')}}/{{ $product->image }}" alt="" >
                  </a>
                </div>
                <div class="price"><b>￥</b>{{ $product->price }}</div>
                <a href="{{ route('products.show', ['product' => $product->id]) }}">{{ $product->title }}</a>
              </div>
              <div class="bottom">
                <div class="sold_count">销量 <span>{{ $product->sold_count }}笔</span></div>
                <div class="review_count">评价 <span>{{ $product->review_count }}</span></div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    </div>
    <div class="card-header">我的借阅收藏</div>
    <div class="card-body">
      <div class="row products-list">
        @foreach($novels as $novel)
          <div class="col-3 product-item">
            <div class="product-content">
              <div class="top">
                <div class="img">
                  <a href="{{ route('novel.show', ['novel' => $novel->id]) }}">
                    <img src="{{ Storage::disk('edushu')->url($novel->image) }}" alt="" width="80px">
                  </a>
                </div>
                <div class="price"><b>￥</b>{{ $novel->price }}</div>
                <a href="{{ route('novel.show', ['novel' => $novel->id]) }}">{{ $novel->name }}</a>
              </div>
              <div class="bottom">
                <div class="sold_count">借出 <span>{{ $novel->rent_count }}本</span></div>
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
