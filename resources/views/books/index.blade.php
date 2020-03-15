@extends('layouts.wechat_default')
@section('title', '中小学生必读书目')


@section('jssdk')

@endsection



@section('content')


<div class="page">
  <div class="page__hd">
    <h6 class="page__title">欢迎关注公众号获取更多免费资源！</h6>
      <p class="page__desc"><img src="https://book.edushu.co/uploads/images/wechat1.png" width="100%"/></p>
  </div>

  <div class="page__hd">
      <p class="page__desc page_header_title">猜你想要</p>
  </div>
  <div class="row">
    @foreach($books as $book)
    <div class="col-5" style="border:1px solid #ededed;margin:5px;padding:5px;">
      <div class="weui-flex__item ">
        <div class="placeholder ">
          <a href="{{route('books.show',$book->id)}}"><img src="{{ $book->image }}" alt="" width="110px"></a>
          <div class="title">{{ $book->name }}</div>
          @if($book->categories()->count())
          <div class="tags">
            <div class="clearfix">
              <div class="float-left title">适合:</div>
              @foreach($book->categories()->where('parent_id',1)->take(2)->get() as $category)
                 <p><a href="{{route('category.show',$category->id)}}">{{$category->name}}</a></p>
              @endforeach
            </div>
            <div class="clearfix">
              <div class="float-left title">标签:</div>
              @foreach($book->tags()->take(2)->get() as $tag)
                 <p><a href="{{route('tags.show',$tag->id)}}">{{$tag->name}}</a></p>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
</div>
</div>
@endsection
