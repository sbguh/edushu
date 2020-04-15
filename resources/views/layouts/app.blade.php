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
    <title>@yield('title', '中小学生免费借书平台') - 共享书房</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body data-weui-theme="light">
<div id="app" >
    @include('layouts._header')

    @yield('content')
    <div style="clear:both;margin-bottom:100px"></div>
    @include('layouts._footer')

</div>
    @yield('scriptsAfterJs')

    <script>

    var app = new Vue({
        el: '#app',
        delimiters : ['[[', ']]'],
        data: {
          //message: 'Hello Vue!'
          value:'',
          activeNames: ['1'],
          inputVal:'',
          result:[],
          active: 0,
          show: false,
          searchResult:false,
          phone:'',
          dis:false,
          verification_key:'',
          sms:''

        },
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
                  onCancel() {
                    Toast('取消');
                  },

                  onClickIcon() {
                     Toast('点击图标');
                   },
                   onClickButton() {
                     Toast('点击按钮');
                   },
                   verify_phone(){

                      if(this.phone==false){
                        swal("填写手机号码")
                        return false
                      }

                      if(this.sms==false){
                        swal("填写验证码")
                        return false
                      }
                      let data = {"phone":this.phone,"sms":this.sms,'verification_key':this.verification_key};
                      axios.post('/wechat/verify_phone',data)

                      .then(response => {
                         swal('验证成功', '', 'success');
                         location.href = "{{ session('return_wechat')['url'] }}";
                        })
                        .catch(error => {
                          //  console.log(error.response)
                            swal(error.response.data.message, '', 'error');
                        });


                   },
                   send_sms(){

                     if(this.phone==false){
                       swal("填写手机号码")
                       return false
                     }

                     axios.post('/wechat/send_sms/'+this.phone)
                      .then(function (response) { // 请求成功会执行这个回调

                        //$("#verification_key").val(response.data.key)
                        app.verification_key = response.data.key;
                        console.log("verification_key"+ app.verification_key);
                        swal('发送成功', '', 'success');

                        //location.reload();
                      })

                     this.dis = true;
                       setTimeout(() => {
                        this.dis = false;
                      }, 30000);


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
$(function(){

  })
    </script>
</body>
</html>
