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
    <title>佳和超市</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}"></script>


</head>
<body data-weui-theme="light" >
  <div class="container" >

    <div class="row ">
    <div class="col-sm-12 col-xs-12 ">
      <h1>佳和超市</h1>
    </div>
  </div>
  <div class="row " id="app">
    <div class="col-sm-12 col-xs-12 ">

      <form class="form-inline" v-on:submit.prevent="download" >
        <div class="form-group col-sm-9 col-xs-12" >
          <input autofocus="autofocus" v-focus type="text"  v-model="barcode" @focus="urlfocus" @blur="urldefault" class="form-control" style="width: 100% !important;" name="url" id="search" v-bind:placeholder="url_demo" autocomplete="off">

        </div>
        <button type="button" :disabled="isAble" class="btn btn-primary" v-on:click="download">搜索</button>

    </form>
  <div v-if="productData">
    <h2>价格信息</h2>
    <form class="form-horizontal" v-on:submit.prevent="updateproduct" >
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">条码</label>
        <div class="col-sm-10">
         <input type="text"  v-model="ProductBarcode"  class="form-control" name="ProductBarcode"  >

        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
        <div class="col-sm-10">
          <input type="text"  v-model="ProductName"  class="form-control" name="ProductName" >

        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">价格：</label>
        <div class="col-sm-10">
          <input type="text"  v-model="ProductSalePrice"  class="form-control"  name="ProductSalePrice" >

        </div>
      </div>


      <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
           <button type="button"  class="btn btn-primary" v-on:click="updateproduct">更新</button>
         </div>
       </div>

  </form>
</div>
    </div>
</div>

<script>

Vue.directive('focus', {
        // 当绑定元素插入到 DOM 中。

        inserted: function (el) {
            // 聚焦元素
            el.focus()
        },
        //也可以用update,update就是当页面有操作的时候就触发，比如点击按钮，输入框输入都算。
        //有一个要注意的就是，就是你页面有几个input,比如一个input绑定了v-focus,一个没有绑定。你在没绑定v-focus的input输入时，绑定了v-focus的input就是自动获取焦点，这是个bug.
        //update: function (el) {
            //el.focus()
        //}
});

let csrf_token = "{{ csrf_token() }}";
axios.defaults.headers.common = {
'X-Requested-With': 'XMLHttpRequest',
'X-CSRF-TOKEN': csrf_token
};
var app = new Vue({
el: '#app',
data: {
seen: true,
downloadfile:"",
ProductBarcode:'',
ProductName:'',
ProductSalePrice:'',
barcode:"",
error_note: "{{trans('page.error_note')}}",
url:"@yield('webpage_url', '')",
url_demo:"@yield('url_demo', '输入条码')",
withoutsound:false,
videojson:"",
productData:"",
channel:"one",
loading:false,
errored:false,
isAble:false,
},

methods: {
  updateproduct:function(){
    console.log("test update")
    axios.post("{{route('supermarket.update')}}", {
      ProductBarcode: this.ProductBarcode,
      ProductSalePrice: this.ProductSalePrice,
      ProductName: this.ProductName,
    })
    .then(
      response => {
        this.productData = response.data;
        alert("更新成功");
        console.log("productData:"+ this.productData.name)
        this.isAble = false;
        this.ProductBarcode = this.productData.barcode
        this.ProductSalePrice = this.productData.sale_price
        this.ProductName = this.productData.name
        if(response.data ==false ){
          this.errored = true;
        }
      }
    )

  },
  download: function () {
    console.log("this is a test")
    this.productData="";
    if(this.barcode == false){
      this.error_note="请扫描条码";
      this.errored=true;
      return;
    }
    console.log("isAble:"+ this.isAble)
    this.error_note="{{trans('page.error_note2')}}";
    this.loading = true;
    this.withoutsound=false
    this.errored=false
    this.isAble = true;
    axios.post("{{route('supermarket.search')}}", {
      barcode: this.barcode,
    })
    .then(
      response => {
        this.productData = response.data;
        this.barcode ="";
        console.log("productData:"+ this.productData.name)
        this.isAble = false;
        this.ProductBarcode = this.productData.barcode
        this.ProductSalePrice = this.productData.sale_price
        this.ProductName = this.productData.name
        if(response.data ==false ){
          this.errored = true;
        }
      }
    )
    .catch(error => {
      console.log(error);

      this.errored = true
    })
},
downloadItem (url) {

autoDownload(url)
return false
},

urlfocus:function () {
this.url = ""
},

urldefault:function () {
if(this.url==""){
this.url = "@yield('webpage_url', '')"
}

},


},
filters: {
numFilter (value) {
// 截取当前数据到小数点后两位
let realVal = parseFloat(value).toFixed(2)
return realVal
}
}

})
</script>

</body>
</html>
