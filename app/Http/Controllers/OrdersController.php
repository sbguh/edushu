<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;
use Redirect;
use App\Models\Charge;
class OrdersController extends Controller
{
    public function store(OrderRequest $request)
    {

        $user  = $request->user();
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $request) {
            $address = UserAddress::find($request->input('address_id'));
            // 更新此地址的最后使用时间
          //  $address->update(['last_used_at' => Carbon::now()]);
            // 创建一个订单
            $prefix = date('YmdHis');
            $pay_no = 'wechat'.$prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $order   = new Order([
                'address'      => $request->input('address'),
                'payment_no' => $pay_no,
                'remark'       => $request->input('remark'),
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            // 写入数据库
            $order->save();

            $totalAmount = 0;
        //    $items       = $request->input('items');

            $cartItems = $request->user()->cartProducts()->with(['productSku.product'])->get();

            // 遍历用户提交的 SKU
            foreach ($cartItems as $cartitem) {
                $sku  = $cartitem->productSku;
                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
                    'amount' => $cartitem->amount,
                    'price'  => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                //$totalAmount += $sku->price * $data['amount'];
                $totalAmount += $sku->price * $cartitem->amount;
                if ($sku->decreaseStock($cartitem->amount) <= 0) {
                    throw new InvalidRequestException('该商品库存不足');
                }

                $cartitem->delete();
            }

            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            // 将下单的商品从购物车中移除

            return $order;
        });

        return redirect(route('orders.show',$order->id));
        //return $order;
        //return redirect(route('orders.show',$order->id));
      //  return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    public function show(Order $order, Request $request)
    {

        $this->authorize('own',$order);

        $app = app('wechat.payment');
        $user   = $request->user();

        if($order->paid_at==false&&env('WE_CHAT_DISPLAY', true)){

              $result = $app->order->unify([
                'body' => "订单号: ".$order->order_number.", 请关注公众号查询详情.",
                'out_trade_no' => $order->payment_no,
                'total_fee' => $order->total_amount *100,
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
                return view('orders.show', ['app' => $app, 'prepayId' => $prepayId,'total_fee'=>$order->total_amount, 'order' => $order->load(['items.productSku', 'items.product'])]);

            }
        }else{
              return view('orders.show', ['app' => $app,'prepayId'=>false, 'order' => $order->load(['items.productSku', 'items.product'])]);
        }



    }



    public function pay_notify(Request $request){

      \Log::info("pay_notify begin");
      $app = app('wechat.payment');

      $response = $app->handlePaidNotify(function($message, $fail){
          // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单

          $order= Order::where('payment_no',$message['out_trade_no'])->first();

          if (!$order || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
              return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
          }

          ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

          if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
              // 用户是否支付成功

              \Log::info("pay_notify SUCCESS");

              if (array_get($message, 'result_code') === 'SUCCESS') {
                \Log::info("pay_notify write data");

                $app_wechat = app('wechat.official_account');
                $user = $request->user();
                $openid = $user->openid;
                $app_wechat->template_message->send([
                  'touser' => $openid,
                  'template_id' => 'PC3n2HvWWdaSxXfhXFH_KZvU_uWkO8LECsYlhxV2lIM',
                  'url' => route('orders.show',$order->id),
                  'data' => [
                      'first' =>'支付成功通知',
                      'keyword1' => $order->order_number,
                      'keyword2' => $order->total_amount,
                      'keyword3' => $order->paid_at,
                      'remark' => "感谢您的使用，详情请点击查看"

                  ],
              ]);


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
    }


}
