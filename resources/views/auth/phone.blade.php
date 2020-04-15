@extends('layouts.app')

@section('content')

<van-field v-model="phone" type="tel" label="手机号" placeholder="请输入手机号码"
:rules="[{ required: true, message: '请填写手机号码' }]"
 /></van-field>

<van-field
  v-model="sms"
  center
  clearable
  label="短信验证码"
  placeholder="请输入短信验证码"
  :rules="[{ required: true, message: '请填写验证码' }]"
>
  <template #button>
    <van-button size="small" v-bind:disabled="dis" @click="send_sms" type="primary">发送验证码</van-button>
  </template>
</van-field>

<div style="margin: 16px;">
    <van-button round block type="info"  @click='verify_phone' native-type="submit">
      绑定手机号
    </van-button>
  </div>

@endsection


@section('scriptsAfterJs')
<script>
function timer(time) {
    var btn = $("#sendButton");
    btn.attr("disabled", true);  //按钮禁止点击
    btn.val(time <= 0 ? "发送验证码" : ("" + (time) + "秒后可发送"));
    var hander = setInterval(function() {
        if (time <= 0) {
            clearInterval(hander); //清除倒计时
            btn.val("发送验证码");
            btn.attr("disabled", false);
            return false;
        }else {
            btn.val("" + (time--) + "秒后可发送");
        }
    }, 1000);
}


//调用方法


  $(document).ready(function () {
    // 监听 移除 按钮的点击事件
    $('.verify_phone').click(function () {
      // $(this) 可以获取到当前点击的 移除 按钮的 jQuery 对象
      // closest() 方法可以获取到匹配选择器的第一个祖先元素，在这里就是当前点击的 移除 按钮之上的 <tr> 标签
      // data('id') 方法可以获取到我们之前设置的 data-id 属性的值，也就是对应的 SKU id
      var contact_phone =$('.contact_phone').val();
      if(contact_phone==false){
        swal("填写手机号码")
        return false
      }

      axios.post('/wechat/send_sms/'+contact_phone)
        .then(function (response) { // 请求成功会执行这个回调
        //  console.log(response);
          $("#verification_key").val(response.data.key)
          swal('操作成功', '', 'success');
          //location.reload();
        })



      timer(30);
    })


  });
</script>
@endsection
