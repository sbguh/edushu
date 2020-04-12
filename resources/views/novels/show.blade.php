@extends('layouts.rent_app')
@section('title', $novel->name)

@section('jssdk')

@endsection


@section('content')
<div class="page">

<van-nav-bar
  title=""
  left-text="返回"
  right-text=""
  left-arrow
  @click-left="onClickLeftNovel"
/></van-nav-bar>

<van-tabs v-model="active">

  <van-tab title="详细">
    <div class="page">
      <div class="page__hd">

        <div class="weui-flex">
            <div class="weui-flex__item"><div class="placeholder"><img src="{{ Storage::disk('edushu')->url($novel->image) }}" width="200px"></div></div>
            <div class="weui-flex__item">
              <div class="placeholder">
                <h3>{{$novel->title}}</h3>
                @if($novel->categories()->count())
                <div class="tags">
                  <div class="clearfix">
                    <label class="weui-form-preview__label">适合:</label>
                    @foreach($novel->categories()->where('parent_id',1)->get() as $category)
                       <van-tag round type="warning"><a style="color:white"  href="{{route('category.show',$category->id)}}">{{$category->name}}</a></van-tag>
                    @endforeach
                  </div>
                  <div class="clearfix">
                  <label class="weui-form-preview__label"> 标签:</label>
                    @foreach($novel->tags()->get() as $tag)

                       <van-tag mark type="primary"><a style="color:white" href="{{route('tags.novel',$tag->id)}}">{{$tag->name}}</a></van-tag>
                    @endforeach
                  </div>
                </div>
                @endif
              </div>
              <div><label class="weui-form-preview__label">字数:</label> <span class="weui-form-preview__value">{{$novel->words/10000}}万字</span></div>
              <div><label class="weui-form-preview__label">作者:</label> <span class="weui-form-preview__value">{{$novel->author}}</span></div>
              <div><label class="weui-form-preview__label">借阅:</label> <span class="weui-form-preview__value">{{$novel->rent_count}}</span></div>
              <div><label class="weui-form-preview__label">浏览:</label> <span class="weui-form-preview__value">{{$novel->count}}</span></div>
            </div>

        </div>





        <article class="weui-article">
          <van-divider>共读书房推荐</van-divider>
          <div>{!!$novel->description!!}</div>
        </article>

      </div>






  </div>
  </van-tab>
  <van-tab title="谁在借阅">

<div class="page">
  <div class="weui-cells">
@foreach($rent_book as $rent)

            <div class="weui-cell weui-cell_active">
                <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
                     <img src="{{ isset($rent->user->extras->headimgurl)?$rent->user->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
                    <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{$rent->user->level?$rent->user->level:0}}级</span>
                </div>
                <div class="weui-cell__bd">
                    <p>{{$rent->user->name}} </p>
                    <p style="font-size: 13px; color: #888;">阅读级别:  {{$rent->user->level?$rent->user->level:0}}级, 阅读字数:  {{$rent->user->read_count?($rent->user->read_count/10000).'万字':0}}， 借过: {{$rent->user->rent_count?$rent->user->rent_count:0}}本</p>
                </div>
            </div>


@endforeach
  </div>
</div>

  </van-tab>
  <van-tab title="谁借阅过">
    <div class="page">
      <div class="weui-cells">
    @foreach($return_book as $rent)


                <div class="weui-cell weui-cell_active">
                    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
                         <img src="{{ isset($rent->user->extras->headimgurl)?$rent->user->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
                        <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{$rent->user->level?$rent->user->level:0}}级</span>
                    </div>
                    <div class="weui-cell__bd">
                        <p>{{$rent->user->name}} </p>
                        <p style="font-size: 13px; color: #888;">阅读级别:  {{$rent->user->level?$rent->user->level:0}}级, 阅读字数:  {{$rent->user->read_count?($rent->user->read_count/10000).'万字':0}}， 借过: {{$rent->user->rent_count?$rent->user->rent_count:0}}本</p>
                    </div>
                </div>


    @endforeach
  </div>
</div>
  </van-tab>
  <van-tab title="读后感">暂未开放</van-tab>
</van-tabs>


</div>
@endsection



@section('scriptsAfterJs')


@endsection
