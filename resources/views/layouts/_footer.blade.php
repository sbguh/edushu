
<div class="page footer">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-tab__panel">

            </div>
            <div class="weui-tabbar">
                <div class="weui-tabbar__item weui-bar__item_on">
                    <p class="weui-tabbar__label"><i class="fa fa-3x fa-home" aria-hidden="true"></i></p>
                    <p class="weui-tabbar__label">首页</p>
                </div>
                <div class="weui-tabbar__item">
                  <a href="{{route('rent.index')}}">
                    <p class="weui-tabbar__label"><i class="fa fa-3x fa-book" aria-hidden="true"></i></p>
                    <p class="weui-tabbar__label">借阅</p>
                  </a>
                </div>
                <div class="weui-tabbar__item">
                  <a href="{{route('books.index')}}">
                    <p class="weui-tabbar__label"> <i class="fa fa-3x fa-etsy" aria-hidden="true"></i> </p>
                    <p class="weui-tabbar__label">在线阅读</p>
                  </a>
                </div>
                <div class="weui-tabbar__item">

                     <p class="weui-tabbar__label"><i class="fa fa-3x fa-user-circle" aria-hidden="true"></i></p>
                    <p class="weui-tabbar__label">我的账号</p>

                </div>
            </div>
        </div>
    </div>
</div>
<van-number-keyboard safe-area-inset-bottom />
