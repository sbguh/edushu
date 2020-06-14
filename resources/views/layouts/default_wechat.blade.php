<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '中小学生免费借书平台') - 中小学生精选好书 | 分级阅读</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

@section('jssdk')
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
wx.config({!! $app->jssdk->buildConfig(array('updateAppMessageShareData','updateTimelineShareData'), false) !!});

  wx.ready(function () {
        wx.updateAppMessageShareData({
            title: '中小学生免费借书平台', // 分享标题
            desc: '中小学必读书目免费借，中小学身边的免费借书平台', // 分享描述
            link: 'https://book.edushu.co', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '', // 分享图标
            success: function () {
              // 设置成功
            }
          })
      });


</script>



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
    });
</script>

</head>
<body>
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')
        <div class="container">
            @yield('content')
        </div>
        @include('layouts.wechat_footer')
    </div>
    <!-- JS 脚本 -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scriptsAfterJs')
</body>
</html>
