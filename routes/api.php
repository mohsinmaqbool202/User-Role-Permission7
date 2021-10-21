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

Route::post('/customer-signup', 'Api\CustomerController@signup');
Route::post('/customer-login', 'Api\CustomerController@login');

#products route
Route::get('/products', 'Api\IndexController@index');
Route::get('/product/{id}', 'Api\IndexController@productDetail');

Route::group(['middleware' => 'auth:customer-api'], function() {

    #add to whishlist
    Route::post('/add-to-wishlist', 'Api\IndexController@addToWishList');
    Route::get('/wish-list', 'Api\IndexController@viewWishList');
    Route::get('/delete-wish/{id}', 'Api\IndexController@deleteWishList');
    
    Route::get('/customer-logout', 'Api\CustomerController@logout');

});