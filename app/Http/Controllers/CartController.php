<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\User;
use App\Models\Book;
class CartController extends Controller
{
    //
    public function add(AddCartRequest $request)
        {

            $user   = $request->user();
            $bookId  = $request->input('book_id');
            $amount = 1;


            // 从数据库中查询该商品是否已经在购物车中
            if ($cart = $user->cartItems()->where('book_id', $bookId)->first()) {

                // 如果存在则直接叠加商品数量
                $cart->update([
                    'amount' => $cart->amount + $amount,
                ]);
            } else {

                // 否则创建一个新的购物车记录
                $cart = new CartItem(['amount' => $amount]);

                $cart->user()->associate($user);

                $cart->book()->associate($bookId);
                $cart->save();
            }

            return [];
        }


        public function index(Request $request)
          {
              $cartItems = $request->user()->cartItems()->with(['book'])->get();


              return view('cart.index', ['cartItems' => $cartItems]);
          }

        public function remove(Book $book, Request $request)
        {

            $request->user()->cartItems()->where('book_id', $book->id)->delete();

            return [];
        }

}
