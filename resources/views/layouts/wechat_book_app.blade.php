<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '中小学生免费借书平台') - 中小学生精选好书</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link type="text/css" href="/skin/blue.monday/css/jplayer.blue.monday.css" rel="stylesheet" />
<script src="{{ mix('js/app.js') }}"></script>


@section('jssdk')

@show
<script type="text/javascript">


    $(function(){

      var app = new Vue({
          el: '#app',
          delimiters : ['[[', ']]'],
          data: {
            //message: 'Hello Vue!'
            value:'',
            inputVal:'',
            this.show=false;
            result:[],
          },


          methods: {
                searchkeyword: function (e) {
                  // `this` 在方法里指向当前 Vue 实例
                  this.value = e.target.value;
                  $searchResult.show();
                  if(this.value.length) {
                    $searchResult.show();
                    axios.post('/search/' + this.value)
                    .then(
                      response => {
                        this.result=response.data;
                        //alert(typeof(this.result));
                        console.log(this.result)

                      }
                    )
                }



              },
              onCancel() {
                Toast('取消');
              },

              onClickIcon() {
                 Toast('点击图标');
               },
               onClickButton() {
                 Toast('点击按钮');
               },
               showPopup() {

                 if(this.show){
                   this.show=false;
                 }else{
                   this.show = true;
                 }
               }
               
              }

        })

        var $searchBar = $('#searchBar'),
            $searchResult = $('#searchResult'),
            $searchText = $('#searchText'),
            $searchInput = $('#searchInput'),
            $searchClear = $('#searchClear'),
            $searchCancel = $('#searchCancel');

            $searchResult.hide();
            //$searchResult.hide();
        function hideSearchResult(){
            $searchResult.hide();
            $searchInput.val('');
        }
        function cancelSearch(){
            hideSearchResult();
            $searchBar.removeClass('weui-search-bar_focusing');
            $searchText.show();
        }

        $searchText.on('click', function(){
            $searchBar.addClass('weui-search-bar_focusing');
            $searchInput.focus();
        });
        $searchInput
            .on('blur', function () {
                if(!this.value.length) cancelSearch();
            })
            .on('input', function(){
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }
            })
        ;
        $searchClear.on('click', function(){
            hideSearchResult();

            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            cancelSearch();

            $searchInput.blur();
        });

        $('.weui-navbar__item').on('click', function () {
            $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
        });

        $('.check_1').on('click', function () {

            $('.weui-tab__panel1').css("display","block").siblings().css("display","none");
        });
        $('.check_2').on('click', function () {

            $('.weui-tab__panel2').css("display","block").siblings().css("display","none");
        });
        $('.check_3').on('click', function () {

            $('.weui-tab__panel3').css("display","block").siblings().css("display","none");
        });

    });
</script>

</head>
<body data-weui-theme="light">
<div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')
        <div class="container wechat_content">
            @yield('content')
        </div>
</div>
        @include('layouts.wechat_book_footer')

    <!-- JS 脚本 -->

    @yield('scriptsAfterJs')
</body>
</html>
