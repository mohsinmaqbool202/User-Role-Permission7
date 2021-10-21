<?php

use Illuminate\Support\Facades\Route;

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

#Admin side routes
Route::get('admin-login', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//user email verification route
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

//goole login routes
Route::get('auth/google', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\RegisterController@handleProviderCallback');

//facebook login routes
Route::get('/auth/redirect/{provider}', 'Auth\RegisterController@facebookRedirect');
Route::get('auth/callback/{provider}', 'Auth\RegisterController@facebookCallback');

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    #upload multiple images of product
    Route::match(['get','post'], 'products/store-multiple-images/{product_id}', 'ProductController@storeMultipleImages')->name('product.store-multiple-images');
    #delete img of product
    Route::get('products/delete-image/{id}','ProductController@deleteImage')->name('products.delete-image');
    Route::resource('products','ProductController');
    #view all customers
    Route::get('/all-customers','CustomerController@viewCustomers')->name('all.customers');

    #view orders route
    Route::get('/all-orders', 'OrderPlacement@viewOrders')->name('all.orders');
    // Route::get('/view-order/{id}', 'OrderPlacement@viewOrderDetail');

});



#user/customer side routes

#Home Page Routes
Route::get('/', 'IndexController@index');

#Product detail page
Route::get('product/{id}', 'IndexController@productDetail')->name('product.detail');

#user register /login page
Route::get('/login-register', 'CustomerController@customerLoginRegister')->name('login.register');

#register form submit
Route::post('/customer-register', 'CustomerController@register');

#activate account 
Route::get('/confirm/{code}', 'CustomerController@confirmAccount');

#user login route
Route::post('/customer-login', 'CustomerController@login');

#user logout route
Route::get('/customer-logout', 'CustomerController@logout');

#Add-to-cart routes
Route::get('/add-to-cart', 'OrderPlacement@addtocart');

#cart page route
Route::match(['get', 'post'], '/cart', 'OrderPlacement@cart');

#Delete cart items route
Route::get('/cart/delete-product', 'OrderPlacement@deleteCartProduct')->name('remove.from.cart');

#update product quantity in cart
Route::get('/update-cart', 'OrderPlacement@updateCartQuantity');


Route::group(['middleware' => ['frontlogin']], function(){

    #user account page
    Route::match(['get', 'post'], '/account', 'CustomerController@account')->name('account.setting');
    #update user pwd
    Route::get('/check-customer-pwd', 'CustomerController@checkUserPwd');
    Route::post('/update-customer-pwd', 'CustomerController@updatePassword');

    #add to whishlist
    Route::get('/add-to-wishlist', 'IndexController@addToWishList');
    Route::get('/wish-list', 'IndexController@viewWishList');
    Route::get('/delete-wish/{id}', 'IndexController@deleteWishList');

    #checkout page
    Route::match(['get','post'], '/checkout', 'OrderPlacement@checkout');
    #order review 
    Route::get('/order-review', 'OrderPlacement@orderReview');
    #place order
    Route::match(['get','post'], '/place-order', 'OrderPlacement@placeOrder');
    #View customer orders
    Route::get('/orders', 'OrderPlacement@customerOrders');
});

