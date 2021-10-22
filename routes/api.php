<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/test-api-token', function(){
            // return 'Authenticated!';
        // });

#customer login routes
Route::post('/customer-signup', 'Api\CustomerController@signup');
Route::post('/customer-login', 'Api\CustomerController@login');
Route::post('/password/email', 'Api\CustomerController@forgot');
Route::post('/password/reset', 'Api\CustomerController@reset');

#products route
Route::get('/products', 'Api\IndexController@index');
Route::get('/product/{id}', 'Api\IndexController@productDetail');

#Add-to-cart routes
Route::post('/add-to-cart', 'Api\OrderPlacement@addtocart');
#place order
Route::post('/place-order', 'Api\OrderPlacement@placeOrder');

Route::group(['middleware' => 'auth:customer-api'], function() {

    #add to whishlist
    Route::post('/add-to-wishlist', 'Api\IndexController@addToWishList');
    Route::get('/wish-list', 'Api\IndexController@viewWishList');
    Route::get('/delete-wish/{id}', 'Api\IndexController@deleteWishList');
    
    #View customer orders
    Route::get('/orders', 'Api\OrderPlacement@customerOrders');

    #account settings
    Route::match(['get', 'post'], '/account', 'Api\CustomerController@account')->name('account.setting');
    Route::post('/update-customer-pwd', 'Api\CustomerController@updatePassword');
    

    Route::get('/customer-logout', 'Api\CustomerController@logout');

});