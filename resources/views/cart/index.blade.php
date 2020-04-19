@extends('layouts.app')
@section('title', '购物车')

@section('content')
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="card">
  <div class="card-header">我的购物车</div>

  @if ($errors->any())
<div class="jd_login_panle_input" style="padding: 0 26px; font-size: 13px; color: red;">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

  <div class="card-body">
    <table class="table table-striped">
      <thead>
      <tr>
        <th>商品</th>
        <th>单价</th>
        <th>数量</th>
        <th>操作</th>
      </tr>
      </thead>
      <tbody class="product_list">
        @if($cartItems->count())
      @foreach($cartItems as $item)
        <tr data-id="{{ $item->id }}">
          <td class="product_info">
            <div class="preview">
                <img src="{{ Storage::disk('edushu')->url($item->product->image)}}" width="40px;">
            </div>
            <div @if(!$item->product->on_sale) class="not_on_sale" @endif>

              @if(!$item->product->on_sale)
                <span class="warning">该商品已下架</span>
              @endif
            </div>
          </td>
          <td><span class="price">￥{{ $item->product->price }}</span></td>
          <td>
             <input type="text" class="form-control form-control-sm amount" @if(!$item->product->on_sale) disabled @endif name="amount" value="{{ $item->amount }}">
          </td>
          <td>
            <button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" aria-hidden="true"></i></button>
          </td>
        </tr>
      @endforeach
      @endif
      </tbody>
    </table>

    <!-- 开始 -->
<div>

<van-form  @submit="submitorder">

  <van-field
    v-model="address"
    rows="2"
    autosize
    label="收货地址"
    type="textarea"
    maxlength="50"
    placeholder="收货地址"
    show-word-limit
  /></van-field>

  <van-field
    v-model="remark"
    rows="2"
    autosize
    label="备注"
    type="textarea"
    maxlength="50"
    placeholder="请输入备注"
    show-word-limit
  /></van-field>

  <div style="margin: 16px;">
    <van-button round block type="info" native-type="submit">
      提交订单
    </van-button>
  </div>
</van-form>

</div>
<!-- 结束 -->

  </div>
</div>
</div>
</div>

<div style="height:50px;"></div>
@endsection


@section('scriptsAfterJs')


@if(env('WE_CHAT_DISPLAY', true))


<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>

<script>



wx.config({!! $app->jssdk->buildConfig(array('openAddress'), false) !!});

wx.ready(function () {



  wx.openAddress({

    success: function (res) {

      $(".address").val(res.userName +", "+res.telNumber +", "+ res.provinceName + res.cityName + res.detailInfo);
      //alert("成功");
    },
    fail: function(err) {
      //alert("失败");
      //alert(err.errMsg);
    },
    cancel: function(err) {
      //alert("取消");
    }



    });

});
</script>
@endif
<script>
  $(document).ready(function () {



    $('.shippingaddress').click(function () {

      wx.openAddress({

        success: function (res) {
          //alert("成功");
          data.address = res.userName +", "+res.telNumber +", "+ res.provinceName + res.cityName + res.detailInfo;
          //$(".address").val(res.userName +", "+res.telNumber +", "+ res.provinceName + res.cityName + res.detailInfo);
        },
        fail: function(err) {
          //alert(err.errMsg);
        },
        cancel: function(err) {
          //alert("取消");
        }



        });

    });

    // 监听 移除 按钮的点击事件
    $('.btn-remove').click(function () {
      // $(this) 可以获取到当前点击的 移除 按钮的 jQuery 对象
      // closest() 方法可以获取到匹配选择器的第一个祖先元素，在这里就是当前点击的 移除 按钮之上的 <tr> 标签
      // data('id') 方法可以获取到我们之前设置的 data-id 属性的值，也就是对应的 SKU id
      var id = $(this).closest('tr').data('id');
      swal({
        title: "确认要将该商品移除？",
        icon: "warning",
        buttons: ['取消', '确定'],
        dangerMode: true,
      })
      .then(function(willDelete) {
        // 用户点击 确定 按钮，willDelete 的值就会是 true，否则为 false
        if (!willDelete) {
          return;
        }
        axios.delete('/cart/' + id)
          .then(function () {
            location.reload();
          })
      });
    });


    $('#select-all').change(function() {
      // 获取单选框的选中状态
      // prop() 方法可以知道标签中是否包含某个属性，当单选框被勾选时，对应的标签就会新增一个 checked 的属性
      var checked = $(this).prop('checked');
      // 获取所有 name=select 并且不带有 disabled 属性的勾选框
      // 对于已经下架的商品我们不希望对应的勾选框会被选中，因此我们需要加上 :not([disabled]) 这个条件
      $('input[name=select][type=checkbox]:not([disabled])').each(function() {
        // 将其勾选状态设为与目标单选框一致
        $(this).prop('checked', checked);
      });
    });

    $('.btn-create-order').click(function () {
          // 构建请求参数，将用户选择的地址的 id 和备注内容写入请求参数
          var req = {
            address: $('.address').val(),
            items: [],
            remark: $('#order-form').find('textarea[name=remark]').val(),
          };
          // 遍历 <table> 标签内所有带有 data-id 属性的 <tr> 标签，也就是每一个购物车中的商品 SKU
          $('table tr[data-id]').each(function () {
            // 获取当前行的单选框
            var $checkbox = $(this).find('input[name=select][type=checkbox]');
            // 如果单选框被禁用或者没有被选中则跳过
            if ($checkbox.prop('disabled') || !$checkbox.prop('checked')) {
              return;
            }
            // 获取当前行中数量输入框
            var $input = $(this).find('input[name=amount]');
            // 如果用户将数量设为 0 或者不是一个数字，则也跳过
            if ($input.val() == 0 || isNaN($input.val())) {
              return;
            }
            // 把 SKU id 和数量存入请求参数数组中
            req.items.push({
              sku_id: $(this).data('id'),
              amount: $input.val(),
            })
          });
          axios.post('{{ route('orders.store') }}', req)
            .then(function (response) {
              swal('订单提交成功', '', 'success');
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
        });


        $('.btn-check-now').click(function () {
     // 请求加入购物车接口
     axios.post('{{ route('product.cart.add') }}', {
       sku_id: $('label.active input[name=skus]').val(),
       amount: $('.cart_amount input').val(),
     })
       .then(function () { // 请求成功执行此回调
         swal('加入购物车成功', '', 'success')
         .then(function() {
         location.href = '{{ route('product.cart.index') }}';
       });
       }, function (error) { // 请求失败执行此回调
         if (error.response.status === 401) {
           // http 状态码为 401 代表用户未登陆
           swal('请先登录', '', 'error');
         } else if (error.response.status === 422) {
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
       })
   });


  });
</script>
@endsection



@section('search')

@endsection
