<van-popup v-model="show"
closeable
  position="top"
  :style="{ height: '100%' }">

  <div class="page">
    <div class="weui-cells">
  @guest
            <div class="weui-cell weui-cell_active weui-cell_access">
               <div class="weui-cell__bd" style="margin-top: 25px;">
                   <span style="vertical-align: middle;">个人中心</span>
               </div>
               <div class="weui-cell__ft"></div>
           </div>

          <div class="weui-cell weui-cell_active weui-cell_access">
             <div class="weui-cell__bd">
                 <span style="vertical-align: middle;"><a class="nav-link" href="{{ route('login') }}">登录</a></span>
             </div>
             <div class="weui-cell__ft"><a class="nav-link" href="{{ route('login') }}">Login</a></div>
         </div>

  @else
              <div class="weui-cell weui-cell_active">
                  <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
                       <img src="{{ isset(Auth::user()->extras->headimgurl)?Auth::user()->extras->headimgurl:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
                      <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{Auth::user()->level?Auth::user()->level:0}}级</span>
                  </div>
                  <div class="weui-cell__bd">
                      <p>{{Auth::user()->name}} </p>
                      <p style="font-size: 13px; color: #888;">账户余额: {{Auth::user()->balance}}, 押金: {{Auth::user()->deposit}}, 阅读级别:  {{Auth::user()->level?Auth::user()->level:0}}级, 阅读字数:  {{Auth::user()->read_count?(Auth::user()->read_count/10000).'万字':0}}， 借过: {{Auth::user()->rent_count?Auth::user()->rent_count:0}}本</p>
                  </div>
              </div>

             <div class="weui-cell weui-cell_active weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle;">学习报告</span>

                </div>
                <div class="weui-cell__ft"><a href="{{route('root')}}">查看</a></div>
            </div>



            <div class="weui-cell weui-cell_active weui-cell_access">
               <div class="weui-cell__bd">
                   <span style="vertical-align: middle;">我的借阅</span>

               </div>
               <div class="weui-cell__ft"><a href="{{route('root')}}">查看</a></div>
           </div>

            <div class="weui-cell weui-cell_active weui-cell_access">
               <div class="weui-cell__bd">
                   <span style="vertical-align: middle;">订单查询</span>

               </div>
               <div class="weui-cell__ft"><a href="{{route('root')}}">查看</a></div>
           </div>

           <div class="weui-cell weui-cell_active weui-cell_access">
              <div class="weui-cell__bd">
                  <span style="vertical-align: middle;">我的收藏</span>

              </div>
              <div class="weui-cell__ft"><a href="{{route('root')}}">查看</a></div>
          </div>

          <div class="weui-cell weui-cell_active weui-cell_access">
             <div class="weui-cell__bd">
                 <span style="vertical-align: middle;">收货地址</span>

             </div>
             <div class="weui-cell__ft"><a href="{{route('root')}}">查看</a></div>
         </div>

           <div class="weui-cell weui-cell_active weui-cell_access">
              <div class="weui-cell__bd">
                  <span style="vertical-align: middle;">账号设置</span>

              </div>
              <div class="weui-cell__ft"><a href="{{route('root')}}">查看</a></div>
          </div>



@endguest
    </div>
  </div>


</van-popup>

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
                    <p class="weui-tabbar__label">借阅中心</p>
                  </a>
                </div>
                <div class="weui-tabbar__item">
                  <a href="{{route('books.index')}}">
                    <p class="weui-tabbar__label"> <i class="fa fa-3x fa-etsy" aria-hidden="true"></i> </p>
                    <p class="weui-tabbar__label">在线阅读</p>
                  </a>
                </div>

                <div class="weui-tabbar__item" @click="showPopup">

                      <p class="weui-tabbar__label"><i class="fa fa-3x fa-user-circle" aria-hidden="true"></i></p>
                      <p class="weui-tabbar__label">我的账号</p>



                </div>

            </div>
        </div>
    </div>
</div>
<van-number-keyboard safe-area-inset-bottom />
