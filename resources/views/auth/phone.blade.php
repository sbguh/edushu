@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">用户信息</div>

                @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



                <div class="card-body">
                <form class="form-horizontal" role="form" action="{{ route('wechat.save.phone') }}" method="post">
                  {{ csrf_field() }}

                  </div>
                  <div class="form-group row">
                    <label class="col-form-label text-md-right col-sm-2">电话</label>

                      @if($user->phone_number)
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" readonly>
                      </div>
                      @else
                      <div class="col-sm-6">
                      <input type="text" class="form-control contact_phone" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                      </div>
                      <div class="col-sm-3">
                        <input type="hidden" name="verification_key" id="verification_key">
                      <button id="sendButton" type="button" name="verify_phone" class="verify_phone btn btn-info">获取验证码</button>
                      </div>


                        <label class="col-form-label text-md-right col-sm-2">验证码</label>
                        <div class="col-sm-4">

                          <input type="text" class="form-control" name="verify_code" value="">
                        </div>


                      @endif

                  </div>


                  @if($user->phone_number==false)
                  <div class="form-group row text-center">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                  </div>
                  @endif

                </form>
                </div>
            </div>
        </div>
    </div>
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
