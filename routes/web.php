<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'PagesController@root')->name('root');
Route::redirect('/', '/books')->name('root');

Route::any('/subscribe', 'WeChatController@subscribe')->name('wechat.subscribe');


Auth::routes(['verify' => true]);
//Auth::routes();

Route::group(['middleware' => ['auth',env('WE_CHAT_DISPLAY', true)?'wechat.oauth':"web"]], function() {
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
    Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
    Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
    Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

    Route::post('books/{book}/favorite', 'BooksController@favor')->name('books.favor');
    Route::post('novels/{novel}/favorite', 'NovelsController@favor')->name('novels.favor');
    Route::delete('novels/{novel}/favorite', 'NovelsController@disfavor')->name('novels.disfavor');

    Route::delete('books/{book}/favorite', 'BooksController@disfavor')->name('books.disfavor');
    Route::get('books/favorites', 'BooksController@favorites')->name('books.favorites');


    Route::post('product_cart', 'ProductCartController@add')->name('product.cart.add');
    Route::get('product_cart', 'ProductCartController@index')->name('product.cart.index');
    Route::delete('product_cart/{sku}', 'ProductCartController@remove')->name('product.cart.remove');


    Route::post('wechat/verify_phone', 'WeChatController@save_phone')->name('wechat.save.phone');
    Route::get('wechat/phone', 'WeChatController@add_phone')->name('wechat.add.phone');

    Route::post('orders', 'OrdersController@store')->name('orders.store');
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    Route::get('orders', 'OrdersController@index')->name('orders.index');


    Route::post('checkout/wechatpay', 'ProductsController@wechatpay')->name('checkout.wechatpay');
    Route::get('rent/{rent_number}', 'RentController@show')->name('rent.show');
    Route::get('userrent', 'RentController@index')->name('user.rent.index');
    Route::get('reports/{report_number}', 'ReportsController@show')->name('reports.show');
    Route::get('reports/', 'ReportsController@index')->name('reports.index');

    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::get('cart',  'CartController@index')->name('cart.index');
    Route::delete('cart/{cart}', 'CartController@remove')->name('cart.remove');

    Route::get('users', 'UsersController@show')->name('users.show');
    Route::post('users', 'UsersController@store')->name('users.save');

    Route::get('cards', 'CardsController@show')->name('cards.show');


});

Route::group(['middleware' => [env('WE_CHAT_DISPLAY', true)?'wechat.oauth':"web"]], function () {
  Route::get('products/{product}', 'ProductsController@show')->name('products.show');

  });


    Route::post('wechat/send_sms/{phone}', 'WeChatController@send_sms')->name('wechat.send_sms');

Route::get('products', 'ProductsController@index')->name('products.index');




//wechat
// https://github.com/overtrue/laravel-wechat


Route::group(['middleware' => ['web']], function () {

Route::any('/wechat', 'WeChatController@serve');
Route::any('payments/wechat-notify', 'OrdersController@pay_notify')->name('checkout.notify');
});


Route::any('/wechat/usermenu', 'WeChatController@usermenu');  //自定义菜单

Route::any('/wechat/qrcode', 'WeChatController@qrcode')->name('wechat.qrcode');  //自定义菜单



Route::get('books/audio/{book}', 'BooksController@bookaudio')->name('books.audio');
Route::get('chapter/audio/{chapter}', 'BooksController@chapteraudio')->name('chapter.audio');
/*
Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('wechat/auth', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
    });
});
*/
Route::get('category', 'CategoryController@index')->name('category.index');
Route::get('category/{category}', 'CategoryController@show')->name('category.show');
Route::get('category/novel/{category}', 'CategoryController@novel')->name('category.novel');

Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');

Route::get('tags/novel/{tag}', 'TagsController@novel')->name('tags.novel');



Route::get('books', 'BooksController@index')->name('books.index');
Route::get('books/{book}', 'BooksController@show')->name('books.show');
Route::get('read/{book}', 'BooksController@read')->name('book.read');
Route::get('read/{book}/{chapter}', 'BooksController@chapter')->name('book.read.chapter');
Route::any('search/{keyword}', 'BooksController@search')->name('books.search');
Route::any('/rent/search/{keyword}', 'NovelsController@search')->name('books.search');


Route::get('rents', 'NovelsController@index')->name('rent.index');
Route::get('rents/{novel}', 'NovelsController@show')->name('novel.show');

Route::group(['middleware' => ['web',  env('WE_CHAT_DISPLAY', true)?'wechat.oauth':"web" ]], function () {
  Route::any('/jssdk', 'WeChatController@jssdk')->name('jssdk');
  Route::any('/wechatoauth', 'WeChatController@wechatoauth')->name('wechatoauth');
});



//end wechat route



//Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
