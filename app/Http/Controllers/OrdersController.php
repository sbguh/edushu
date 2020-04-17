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
            $order   = new Order([
                'address'      => $request->input('address'),
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
                'body' => $order->order_number,
                'out_trade_no' => $order->order_number,
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
              return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
        }



    }

}
