@extends('layouts.app')

@section('content')
<div class="weui-cell weui-cell_active">

    <div class="weui-cell__hd" style="position: relative; margin-right: 10px;">
      <img src="{{ isset(Auth::user()->extras->avatar)?Auth::user()->extras->avatar:'https://img.yzcdn.cn/vant/user-inactive.png' }}" width="80px">
        <span class="weui-badge" style="position: absolute; top: -0.4em; right: -0.4em;">Level {{Auth::user()->level?Auth::user()->level:0}}级</span>
    </div>
    <div class="weui-cell__bd">
        <p>{{Auth::user()->name}} </p>
        <p style="font-size: 13px; color: #888;">账户余额: {{Auth::user()->balance}}, 押金: {{Auth::user()->deposit}}, 阅读级别:  {{Auth::user()->level?Auth::user()->level:0}}级, 阅读字数:  {{Auth::user()->read_count?(Auth::user()->read_count/10000).'万字':0}}， 借过: {{Auth::user()->rent_count?Auth::user()->rent_count:0}}本</p>
    </div>
</div>


<van-field v-model="phone" readonly  type="tel" label="手机号" placeholder="请输入手机号码"
:rules="[{ required: true, message: '请填写手机号码' }]"
 /></van-field>

 <van-field v-model="real_name"  label="真实姓名" placeholder="真实姓名"
 :rules="[{ required: true, message: '请填写真实姓名' }]"
  /></van-field>

   <van-field
     readonly
     clickable
     name="birthday"
     :value="value"
     label="出生年月"
     placeholder="出生年月"
     @click="showPicker = true"
   /></van-field>

   <van-popup v-model="showPicker" position="bottom">
     <van-datetime-picker
     v-model="currentDate"
   type="date"
   :min-date="minDate"
   :max-date="maxDate"
   :formatter="formatter"
       @confirm="onConfirm"
       @cancel="showPicker = false"
     />
   </van-popup>

<div style="margin: 16px;">
    <van-button round block type="info"  @click='changeUserInformation' native-type="submit">
      修改
    </van-button>
  </div>

@endsection


@section('scriptsAfterJs')
<script>
data.phone = '{{$user->phone_number?$user->phone_number:""}}';
data.birthday = '{{$user->birthday?$user->birthday:""}}';
data.value = '{{$user->birthday?date("Y-m-d",strtotime("$user->birthday")):""}}';
data.real_name = '{{$user->real_name?$user->real_name:""}}';

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
@section('search')

@endsection
