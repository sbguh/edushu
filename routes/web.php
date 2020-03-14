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




Auth::routes(['verify' => true]);
//Auth::routes();

Route::group(['middleware' => ['auth', 'wechat.oauth']], function() {
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
    Route::delete('books/{book}/favorite', 'BooksController@disfavor')->name('books.disfavor');
    Route::get('books/favorites', 'BooksController@favorites')->name('books.favorites');
    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{book}', 'CartController@remove')->name('cart.remove');

});


Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show');


//wechat
// https://github.com/overtrue/laravel-wechat

Route::any('/wechat', 'WeChatController@serve');
Route::any('/wechat/usermenu', 'WeChatController@usermenu');  //自定义菜单
Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料

        dd($user);
    });
});



Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('wechat/auth', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
    });
});




Route::group(['middleware' => ['web', 'wechat.oauth']], function () {

  Route::get('books', 'BooksController@index')->name('books.index');
  Route::get('books/{book}', 'BooksController@show')->name('books.show');
  Route::get('read/{book}', 'BooksController@read')->name('book.read');
  Route::get('read/{book}/{chapter}', 'BooksController@chapter')->name('book.read.chapter');
  Route::any('search/{keyword}', 'BooksController@search')->name('books.search');

  Route::get('category', 'CategoryController@index')->name('category.index');
  Route::get('category/{category}', 'CategoryController@show')->name('category.show');
  Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');

  Route::any('/jssdk', 'WeChatController@jssdk')->name('jssdk');
  Route::any('/wechatoauth', 'WeChatController@wechatoauth')->name('wechatoauth');


});



//end wechat route



Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
