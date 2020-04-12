@extends('layouts.app')
@section('title', '中小学生必读书目')


@section('jssdk')

@endsection


@section('content')



@foreach($books as $book)

<van-card
  thumb= "{{ Storage::disk('edushu')->url($book->image) }}"

  title={{ $book->name }}
>
  <template #tags>
    @if($book->categories()->count())

      @foreach($book->categories()->where('parent_id',1)->take(2)->get() as $category)
         <van-tag plain type="danger"><a href="{{route('category.show',$category->id)}}">{{$category->name}}</a></van-tag>
      @endforeach

    @endif
  </template>


  <template #tags>
    @if($book->tags()->count())

      @foreach($book->tags()->take(2)->get() as $tag)
         <van-tag plain type="danger"><a href="{{route('tags.show',$tag->id)}}">{{$tag->name}}</a></van-tag>
      @endforeach

    @endif
  </template>

</van-card>
@endforeach

@endsection
