@section('footerBar')
<div class="col-xs-12">
  <footer class="footer">
    <nav>

      <div class="page" class="navbar navbar-default navbar-fixed-bottom">
          <div class="page__bd" style="height: 100%;">
              <div class="weui-tab">
                  <div class="weui-tab__panel">

                  </div>
                  <div class="weui-tabbar">
                      <div class="weui-tabbar__item weui-bar__item_on">
                          <div style="display: inline-block; position: relative;">
                              <a href="{{route('root')}}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu01.png" alt="" class="weui-tabbar__icon"></a>
                          </div>
                          <p class="weui-tabbar__label"><a href="{{route('root')}}">首页</a></p>
                      </div>
                      <div class="weui-tabbar__item">
                          <a href="{{route('books.favorites')}}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu02.png" alt="" class="weui-tabbar__icon"></a>
                          <p class="weui-tabbar__label"><a href="{{route('books.favorites')}}">收藏</a></p>
                      </div>
                      <div class="weui-tabbar__item">
                          <div style="display: inline-block; position: relative;">
                              <a href="{{route('category.index')}}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu03.png" alt="" class="weui-tabbar__icon"></a>
                              <span class="weui-badge weui-badge_dot" style="position: absolute; top: 0; right: -6px;"></span>
                          </div>
                          <p class="weui-tabbar__label"><a href="{{route('category.index')}}">分类筛选</a></p>
                      </div>
                      <div class="weui-tabbar__item">
                          <a href="{{ route('wechatoauth') }}"><img src="{{env('APP_URL')}}/uploads/images/bar_menu04.png" alt="" class="weui-tabbar__icon"></a>
                          <p class="weui-tabbar__label"><a href="{{ route('wechatoauth') }}">我的账号</a></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      </nav>
  </footer>
</div>
@show
