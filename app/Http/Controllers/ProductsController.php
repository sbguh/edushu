<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSku;
use App\Exceptions\InvalidRequestException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Charge;
class ProductsController extends Controller
{
    //
    public function index(Request $request)
    {
        $builder = Product::query()->where('on_sale', true);

        // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索商品
        if ($search = $request->input('search', '')) {
            $like = '%'.$search.'%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }

        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
        if ($order = $request->input('order', '')) {
            // 是否是以 _asc 或者 _desc 结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $products = $builder->paginate(16);

        return view('products.index', ['products' => $products,'filters'  => [
                'search' => $search,
                'order'  => $order,
            ]]);
    }

    public function show(Product $product, Request $request)
    {

        if (!$product->on_sale) {
            throw new InvalidRequestException('商品未上架');
        }



        $favored = false;
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象
        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }

        return view('products.show', ['product' => $product, 'favored' => $favored]);
    }

    public function pay_notify(Request $request){


      $response = $app->handlePaidNotify(function($message, $fail){
          // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单

          $order= Order::where('payment_no',$message['out_trade_no'])->first();

          if (!$order || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
              return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
          }

          ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

          if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
              // 用户是否支付成功
              if (array_get($message, 'result_code') === 'SUCCESS'&&$message['sign']==$order->sign) {
                  $order->paid_at = time(); // 更新支付时间为当前时间
                  $order->status = 'paid';

                  $charger_count = Charge::where('charge_number',$order->payment_no)->count();

                  $item= $order->items()->first();
                  if($item->product->id==65&&$charger_count==0){

                    $charge = new Charge([
                      'charge_number'=>$order->payment_no,
                      //'amount'=>$order->total_amount,
                      'remark'=>'自动入账',
                      'type' => "自动在线充值",
                      //'sign'=>$result['sign']

                    ]);

                    $charge->user()->associate($order->user_id);
                    $charge->amount = $order->total_amount;
                    $charge->save();

                    $order->ship_status="完成充值";
                    $order->save();
                  }


              // 用户支付失败
              } elseif (array_get($message, 'result_code') === 'FAIL') {
                  $order->status = 'paid_fail';
              }
          } else {
              return $fail('通信失败，请稍后再通知我');
          }

          $order->save(); // 保存订单

          return true; // 返回处理完成
      });

      return $response;

      // \Log::info("pay_notify".$request);
/*
    $data = file_get_contents('php://input');
    $obj = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
    $json = json_encode($obj);
    $result = json_decode($json, true);

    //  \Log::info("pay_notify: out_trade_no ".$result['out_trade_no']);
        $order= Order::where('payment_no',$result['out_trade_no'])->first();
        if($order){
          if($order['sign']==$order->sign){
            $order->status="付款成功";
            $order->save();

            $charger_count = Charge::where('charge_number',$order->payment_no)->count();
            $item= $order->items()->first();
            if($item->product->id==65&&$charger_count==0){

              $charge = new Charge([
                'charge_number'=>$order->payment_no,
                //'amount'=>$order->total_amount,
                'remark'=>'自动入账',
                'type' => "自动在线充值",
                //'sign'=>$result['sign']

              ]);

              $charge->user()->associate($order->user_id);
              $charge->amount = $order->total_amount;
              $charge->save();

              $order->ship_status="完成充值, 请查看余额";
              $order->save();
            }
            //$prepayId = $result['prepay_id']; //就是拿这个id 很重要
            //return view('products.wechatpay', ['app' => $app, 'prepayId' => $prepayId,'total_fee'=>$order['total_fee']/100]);
          }else{
            $order->status="待付款";
            $order->save();
            //$prepayId = $result['prepay_id']; //就是拿这个id 很重要
            //return view('products.wechatpay', ['app' => $app, 'prepayId' => $prepayId,'total_fee'=>$order['total_fee']/100]);
          }
        }

      return true;
*/
    }

    public function wechatpay(Request $request)
    {

      $validatedData = $request->validate([
            'skus' => 'required',
        ]);


      $user   = $request->user();
      $skuId  = $request->input('skus');
      $prefix = date('YmdHis');

      $productSku =ProductSku::find($skuId);
      $no = 'wechat'.$prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

      $order = new Order([
        'total_amount'=> $productSku->price,
        'payment_method'=>'WeChat',
        'payment_no' => $no,
        'status' =>"暂未付款",
        //'sign'=>$result['sign']

      ]);

      $order->user()->associate($user);
      $order->save();

       $item = $order->items()->make([
         'amount' => 1,
         'price'=>$productSku->price
       ]);

      $item->product()->associate($productSku->product_id);
      $item->productSku()->associate($productSku);
      $item->save();

        $app = app('wechat.payment');

        $result = $app->order->unify([
          'body' => $productSku->product->name,
          'out_trade_no' => $no,
          'total_fee' => $productSku->price *100,
          //'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
          'notify_url' => route('checkout.notify'), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
          'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
          'openid' => $user->openid,
      ]);

      if($result['return_code']=="SUCCESS"){
        \Log::info("log sign".$result['sign']);
          $order->sign =  $result['sign'];
          $order->save();
          $prepayId = $result['prepay_id']; //就是拿这个id 很重要
          return view('products.wechatpay', ['app' => $app, 'prepayId' => $prepayId,'total_fee'=>$productSku->price]);

      }

    }


    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteProducts()->find($product->id)) {
            return [];
        }

        $user->favoriteProducts()->attach($product);

        return [];
    }

    public function disfavor(Product $product, Request $request)
     {
         $user = $request->user();
         $user->favoriteProducts()->detach($product);

         return [];
     }

     public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);

        return view('products.favorites', ['products' => $products]);
    }


}
