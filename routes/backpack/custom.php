<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('useraddress', 'UserAddressCrudController');
    Route::crud('icon', 'IconCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('product_sku', 'Product_skuCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('product_sku', 'Product_skuCrudController');
    Route::crud('chapter', 'ChapterCrudController');
    Route::crud('book', 'BookCrudController');
    Route::crud('tag', 'TagCrudController');

    Route::crud('product_sku', 'Product_skuCrudController');
    Route::crud('productsku', 'ProductSkuCrudController');
}); // this should be the absolute last line of this file