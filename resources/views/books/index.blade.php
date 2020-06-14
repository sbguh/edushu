@extends('layouts.app')
@section('title', '免费有声电子书 | 在线免费阅读课外书 | 免费小学生必读课外有声电子书')


@section('jssdk')

@endsection


@section('content')



@foreach($books as $book)

<van-card
  thumb= "{{ Storage::disk('edushu')->url($book->image) }}"
thumb-link="{{route('books.show',$book->id)}}"
>
<template #title>
<a href="{{route('books.show',$book->id)}}">{{  $book->name }}</a>
</template>


<template #desc>
<div>{!!$book->sub_title!!}</div>
</template>

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
