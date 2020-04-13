@extends('layouts.app')
@section('title', '中小学生必读书目')


@section('jssdk')

@endsection


@section('content')


<div class="page">

  <div class="page__hd">
      <p class="page__desc page_header_title">标签: {{$category->name}}</p>
  </div>

  <div class="row">


    @foreach($novels as $book)

    <van-card
      thumb= "{{ Storage::disk('edushu')->url($book->image) }}"
      thumb-link="{{route('novel.show',$book->id)}}"
    >
    <template #title>
     <a href="{{route('novel.show',$book->id)}}">{{  $book->title }}</a>
    </template>

    <template #desc>
    <div>{{  $book->sub_title }}</div>
    </template>

      <template #tags>
        @if($book->categories()->count())

          @foreach($book->categories()->where('parent_id',1)->take(2)->get() as $category)
             <van-tag plain type="danger"><a href="{{route('category.novel',$category->id)}}">{{$category->name}}</a></van-tag>
          @endforeach

        @endif
      </template>



    </van-card>
    @endforeach

  </div>

</div>



@endsection


@section('scriptsAfterJs')

<script>


@foreach($novels as $book)
//$data.list.push({{$book->id}})
@endforeach


</script>
@endsection
