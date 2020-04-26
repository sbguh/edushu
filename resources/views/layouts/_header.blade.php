@guest

@else

@if(Auth::user()->check_subscribe == 0)
<van-notice-bar wrapable :scrollable="false" mode="closeable">
 <div>系统检测到您尚未关注公众号,这将导致很多功能您将无法使用。 长按下图并识别二维码，或者微信搜索 “<span>中小学生阅读推广</span>”</div>
   <p class="page__desc"><img src="https://book.edushu.co/uploads/images/wechat1.png" width="100%"/></p>

</van-notice-bar>
@endif

@endif

@section('search')

  <van-search
    v-model="value"
    placeholder="请输入搜索关键词"
    @input="onSearch"

    />
</van-search>

<div class="weui-cells searchbar-result" v-if="searchResult" id="searchResult">
  <div  v-for="book in result">
      <div style="margin:5px;"><a :href="'https://book.edushu.co/books/'+ book.id"><img :src="'{{env("APP_URL")}}/uploads/' + book.image" width="80px"/>[[book.title]]</a></div>
<van-divider />
  </div>
</div>
@show
