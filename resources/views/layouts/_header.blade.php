



<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <!-- Branding Image -->
    <a class="navbar-brand " href="{{ url('/') }}">
      <img src="https://book.edushu.co/uploads/images/logo.png" alt="共享书房" width="40px">首页
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">

      </ul>
@section('Navbar')
      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav navbar-right">
        <!-- 登录注册链接开始 -->
        @guest
        <li class="nav-item"><a class="nav-link" href="{{ route('wechatoauth') }}">登录</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
        @else
        <li class="nav-item">
           <a class="nav-link mt-1" href="{{ route('product.cart.index') }}"><i class="fa fa-shopping-cart"></i></a>
         </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
             <a href="{{ route('books.favorites') }}" class="dropdown-item">听书收藏</a>
             <a href="{{ route('products.favorites') }}" class="dropdown-item">商品收藏</a>
            <a class="dropdown-item" id="logout" href="#"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出登录</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
        </li>
        @endguest
        <!-- 登录注册链接结束 -->
      </ul>

@show
    </div>

  </div>
</nav>

<div class="page">

    <div class="page__bd">
        <!--<a href="javascript:" class="weui-btn weui-btn_primary">点击展现searchBar</a>-->
        <div class="weui-search-bar" id="searchBar">
            <form class="weui-search-bar__form">
                <div class="weui-search-bar__box">
                    <i class="weui-icon-search"></i>
                    <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索"  @input="searchkeyword" required/>
                    <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                </div>
                <label class="weui-search-bar__label" id="searchText">
                    <i class="weui-icon-search"></i>
                    <span>搜索</span>
                </label>
            </form>
            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel" >取消</a>
        </div>
        <div class="weui-cells searchbar-result" id="searchResult">
            <div class="weui-cell weui-cell_active weui-cell_access">
                <div class="weui-cell__bd weui-cell_primary" v-for="book in result">
                    <p><a :href="'https://book.edushu.co/books/'+ book.id"><img :src="'https://book.edushu.co/' + book.image" width="80px"/></a></p>
                </div>
            </div>
        </div>
    </div>


</div>
