@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body product-info">
    <div class="row">
      <div class="col-12">
        <div class="row">
            <div class="col-sm-4 col-xs-12"><img class="cover" src="{{env('APP_URL')}}/{{ $book->image }}" alt="" width="120px">
              <div>@if($book->chapters()->count())
              <a href="{{route('book.read',$book->id)}}"><button class="btn btn-success btn-favor">在线阅读</button></a>
              @endif</div>
            </div>
            <div class="col-sm-8 col-xs-12">
              <button class="btn btn-success btn-favor">购买</button>
              <button class="btn btn-primary btn-add-to-cart">免费借此书</button>
            </div>
        </div>
        <div class="title">{{ $book->title }}</div>
        <div class="price"><label>价格</label><em>￥</em><span>{{ $book->price }}</span></div>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
          {!! $book->description !!}
        </div>
        <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
@endsection
