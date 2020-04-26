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
    <title>@yield('title', '专注于中小学阅读和写作')</title>
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


    <script>

var data = {
  //message: 'Hello Vue!'
  value:'',
  activeNames: ['1'],
  inputVal:'',
  result:[],
  active: 0,
  show: false,
  searchResult:false,
  phone:'',
  real_name:'',
  birthday:'',
  minDate: new Date(2000, 0, 1),
  maxDate: new Date(),
  currentDate: new Date(),
  showPicker: false,
  gender:'',
  dis:false,
  verification_key:'',
  sms:'',
  remark: "",
  address:"",
  amount:0

};

    var app = new Vue({
        el: '#app',
        delimiters : ['[[', ']]'],
        data: data,
        methods: {
                  onSearch(val) {
                    this.value = val;
                    if(this.value.length) {
                      this.searchResult = true;
                      axios.post('/rent/search/' + this.value)
                      .then(
                        response => {
                          this.result=response.data;
                          //alert(typeof(this.result));
                        //  console.log(this.result)

                        }
                      )
                  }

                  },
                  onConfirm(time) {
                     this.value = time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate();
                     this.birthday = time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate();
                     this.showPicker = false;
                   },
                   formatter(type, val) {
                      if (type === 'year') {
                        return `${val}年`;
                      } else if (type === 'month') {
                        return `${val}月`;
                      }
                      return val;
                    },
                  changeUserInformation(){
                    var req = {
                      real_name: this.real_name,
                      birthday: this.birthday,
                    };
                    axios.post('{{ route('users.save') }}', req)
                      .then(function (response) {
                        swal('更新成功', '', 'success');
                        location.reload();
                      }, function (error) {
                        if (error.response.status === 422) {
                          // http 状态码为 422 代表用户输入校验失败
                          var html = '<div>';
                          _.each(error.response.data.errors, function (errors) {
                            _.each(errors, function (error) {
                              html += error+'<br>';
                            })
                          });
                          html += '</div>';
                          swal({content: $(html)[0], icon: 'error'})
                        } else {
                          // 其他情况应该是系统挂了
                          swal('系统错误', '', 'error');
                        }
                      });
                  },
                  onCancel(val) {
                    alert("tset")
                    console.log("test")
                  },
                  onClickLeftNovel() {
                    location.href = '{{ route('rent.index') }}';
                   },

                  onClickIcon() {
                     Toast('点击图标');
                   },
                   onClickButton() {
                     Toast('点击按钮');
                   },
                   submitorder(values) {
                     var req = {
                       address: this.address,
                       items: [],
                       remark: this.remark,
                     };
                     axios.post('{{ route('orders.store') }}', req)
                       .then(function (response) {
                         swal('订单提交成功', '', 'success');
                         location.href = response.data;
                         console.log('response:', response.data);
                       }, function (error) {
                         if (error.response.status === 422) {
                           // http 状态码为 422 代表用户输入校验失败
                           var html = '<div>';
                           _.each(error.response.data.errors, function (errors) {
                             _.each(errors, function (error) {
                               html += error+'<br>';
                             })
                           });
                           html += '</div>';
                           swal({content: $(html)[0], icon: 'error'})
                         } else {
                           // 其他情况应该是系统挂了
                           swal('系统错误', '', 'error');
                         }
                       });

                     //console.log('submit', req);
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


    @yield('scriptsAfterJs')
</body>
</html>
