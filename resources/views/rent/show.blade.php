@extends('layouts.app')
@section('title', $novel->title)

@section('jssdk')

@endsection


@section('content')
<div class="page">

<van-tabs v-model="active">

  <van-tab title="详细">
    <div class="page">
      <div class="page__hd">

        <div class="weui-flex">
            <div class="weui-flex__item"><div class="placeholder"><img src="{{ Storage::disk('edushu')->url($novel->image) }}" width="200px"></div></div>
            <div class="weui-flex__item">
              <div class="placeholder">
                <h3><a href="{{route('novel.show',$novel->id)}}">{{$novel->title}}</a></h3>
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
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">字数:</label> <span class="weui-form-preview__value">{{$novel->words/10000}}万字</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">作者:</label> <span class="weui-form-preview__value">{{$novel->author}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">当前状态:</label> <span class="weui-form-preview__value">{{$rent->state}}</span></div>
              <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">
                  @if($rent->deleted_at)
                  还书时间
                  @else
                  还书截至日期
                  @endif

                </label> <span class="weui-form-preview__value">
                @if($rent->deleted_at)
                 {{$rent->deleted_at}}
                @else
                {{$rent->return_time}}
                @endif
              </span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">已阅读:</label> <span class="weui-form-preview__value">{{$rent->user->read_count?($rent->user->read_count/10000).'万字':0}}</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">阅读等级:</label> <span class="weui-form-preview__value">{{$user->level}}级</span></div>
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">累计积分:</label> <span class="weui-form-preview__value">{{round($user->scores)}}分</span></div>
              @if(Auth::user()->id == $user->id)
              <div class="weui-form-preview__item"><label class="weui-form-preview__label">借书记录:</label> <span class="weui-form-preview__value"><a href="{{route('user.rent.index')}}">点击查看历史借书记录</a></span></div>
              @endif


            </div>

        </div>





        <article class="weui-article">
          <van-divider>共读书房推荐</van-divider>
          <p><span style="text-decoration:underline">{{$user->name}} </span>您好！本书目前的状态为：<b>{{$rent->state}}, </b>
            借阅开始日期: {{$rent->created_at}} ,
            @if($rent->deleted_at)
            还书日期: {{$rent->deleted_at}}
            @else
            还书截至日期: {{$rent->return_time}}
            @endif

          </p>
          <p>阅读等级的提升规则: 借书并按时还书 加10，每阅读一万字加1分，分享读后感加20分， 打卡做阅读笔记加 10分，朋友为你点赞 加5分，每增加100分提升一个阅读等级</p>
          <p>阅读等级: 等级越高享受的特权越多，可以增加借书数量，延长还书时间，享受VIP购书折扣，报名共读书房有折扣。</p>
          <p>积分: 可以用来兑换，参与活动。按时还书，打卡，写读后感，邀请朋友点赞你的打卡内容或者你的读后感，可以相应增加积分.</p>
        </article>

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
