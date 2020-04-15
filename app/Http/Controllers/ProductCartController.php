<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddProductCartRequest;
use App\Models\CartProduct;
use App\Models\ProductSku;

class ProductCartController extends Controller
{
    //
    public function add(AddProductCartRequest $request)
    {

        $user   = $request->user();
        $skuId  = $request->input('sku_id');
        $amount = $request->input('amount');

        // 从数据库中查询该商品是否已经在购物车中
        if ($cart = $user->cartProducts()->where('product_sku_id', $skuId)->first()) {

            // 如果存在则直接叠加商品数量

            $productsku = ProductSku::where('id',$skuId)->first();
            if($productsku->limit_buy){

              if(($cart->amount + $amount)>$productsku->limit_buy){
                $cart->update([
                    'amount' => $productsku->limit_buy,
                ]);
              }

            }else{
              $cart->update([
                  'amount' => $cart->amount + $amount,
              ]);
            }

        } else {

            // 否则创建一个新的购物车记录
            $cart = new CartProduct(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }

        return [];
    }


    public function index(Request $request)
    {
        $cartItems = $request->user()->cartProducts()->with(['productSku.product'])->get();

        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        $need_address =1;
        $user   = $request->user();
        $app = app('wechat.payment');

        if($user->phone_number==false){
          session(['return_wechat' =>['url'=>route('product.cart.index'),'name'=> '购物车'] ]);
          return redirect(route('wechat.add.phone'));
        }
        $user = session('wechat.oauth_user.default');

        //$editAddress = $app->jssdk->shareAddressConfig($user_wechat->getToken());
        $editAddress = "";

        return view('products.cart', ['cartItems' => $cartItems,'app'=>$app, 'user'=>$user,'editAddress' =>$editAddress, 'addresses' => $addresses,'need_address'=>$need_address]);
    }


    public function remove(ProductSku $sku, Request $request)
    {

        $request->user()->cartProducts()->where('product_sku_id', $sku->id)->delete();

        return [];
    }



}
