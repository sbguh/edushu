@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-body product-info">
    <div class="row">
      <div class="col-5">
        <img class="cover" src="{{env('APP_URL')}}/{{ $book->image }}" alt="" width="120px">
      </div>
      <div class="col-7">
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
@endsection
