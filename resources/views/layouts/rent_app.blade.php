<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover"
  />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '中小学生免费借书平台') - 分级阅读</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body data-weui-theme="light">
<div id="app" >
    @include('layouts.rent_header')

    @yield('content')
    <div style="clear:both;margin-bottom:100px"></div>




    @include('layouts.rent_footer')

</div>


    <script>

$data ={
  //message: 'Hello Vue!'
  value:'',
  inputVal:'',
  result:[],
  active: 0,
  activeNames: ['1'],
  searchResult:false,
  icon: {
   active: 'https://img.yzcdn.cn/vant/user-active.png',
   inactive: 'https://img.yzcdn.cn/vant/user-inactive.png'
  },
  list: [],
  show: false,
  error: false,
  loading: false,
  finished: false

};

    var app = new Vue({
        el: '#app',
        delimiters : ['[[', ']]'],
        data: $data,
        methods: {
                  onSearch(val) {
                    this.value = val;
                    if(this.value.length) {
                      this.searchResult = true;
                      axios.post('/search/' + this.value)
                      .then(
                        response => {
                          this.result=response.data;
                          //alert(typeof(this.result));
                        //  console.log(this.result)

                        }
                      )
                  }

                  },
                  onLoad() {
this.loading = false;
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

                   onClickLeftNovel() {
                     location.href = '{{ route('rent.index') }}';
                    },
                    onClickRight() {
                      Toast('按钮');
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

    </script>
  @yield('scriptsAfterJs')
</body>
</html>
