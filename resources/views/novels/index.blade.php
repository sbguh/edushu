@extends('layouts.app')
@section('title', '免费在线图书馆')


@section('jssdk')

@endsection


@section('content')

<van-tabs v-model="active" animated>
  <van-tab name="a" title="借阅最多">
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


      <template #tags>
        @if($book->tags()->count())

          @foreach($book->tags()->take(2)->get() as $tag)
             <van-tag plain type="danger"><a href="{{route('tags.novel',$tag->id)}}">{{$tag->name}}</a></van-tag>
          @endforeach

        @endif
      </template>

      <template #footer>

        </template>
    </van-card>

    @endforeach
  </van-tab>


</van-tabs>

<div class="page">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab" style="margin-bottom:30px">
            <div>{{ $novels->render() }}</div>
        </div>
    </div>
</div>



@endsection
