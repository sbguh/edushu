<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\Cart;
use App\User;
use App\Models\Book;
class CartController extends Controller
{
    //
    public function add(Request $request)
        {


            $user   = $request->user();
            $itemId  = $request->input('item_id');
            $itemType  = $request->input('item_type');
            $amount = $request->input('amount');
            $commentable_id = $itemId;
            $commentable_type=sprintf("App\Models\%s",ucfirst($itemType));


            // 从数据库中查询该商品是否已经在购物车中
            if ($cart = $user->carts()->where('commentable_id', $commentable_id)->where('commentable_type',$commentable_type)->first()) {

                // 如果存在则直接叠加商品数量
                $cart->update([
                    'amount' => $cart->amount + $amount,
                ]);
            } else {

                // 否则创建一个新的购物车记录
                $cart = new Cart([
                  'amount' => $amount,
                  'commentable_id' =>$commentable_id,
                  'commentable_type'=>$commentable_type
                ]);

                $cart->user()->associate($user);
                $cart->save();
            }



            return [];
        }


        public function index(Request $request)
          {


            $cartItems = $request->user()->carts()->get();
            $product_items = array();
            foreach($cartItems as $key=>$item){
              $model_name = $item->commentable_type;
              $model_id = $item->commentable_id;

              $item_orm = (New $model_name)::find($model_id);

              if(isset($item_orm->limit_buy)&& $item_orm->limit_buy){
                    if($item->amount > $item_orm->limit_buy){
                        $item->amount = $item_orm->limit_buy;
                    }

                  }
              $item->save();
              $item->product = $item_orm;
              $cartItems[$key] = $item;
            }

            $need_address =1;
            $user   = $request->user();

            //$app = app('wechat.official_account');

            if($user->phone_number==false){
              session(['return_wechat' =>['url'=>route('cart.index'),'name'=> '购物车'] ]);
              return redirect(route('wechat.add.phone'));
            }

            //$app = app('wechat.payment');
            $app = app('wechat.official_account');
            $user = session('wechat.oauth_user.default');
            //$editAddress = $app->jssdk->shareAddressConfig($user_wechat->token);
            $editAddress = "";

            return view('cart.index', ['cartItems' => $cartItems,'app'=>$app, 'user'=>$user,'editAddress' =>$editAddress, 'need_address'=>$need_address]);

          }

        public function remove(Cart $cart, Request $request)
        {

            $cart->delete();

            return [];
        }


        public function wechatpay(Request $request)
          {


            $user   = $request->user();
            $skuId  = $request->input('productsku_id');


            $result = $app->order->unify([
              'body' => '腾讯充值中心-QQ会员充值',
              'out_trade_no' => '20150806125346',
              'total_fee' => 1,
              //'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
              'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
              'openid' => $user->openid,
            ]);


              return view('cart.index', ['cartItems' => $cartItems]);
          }

}
