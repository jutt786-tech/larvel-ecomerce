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

use App\Http\Controllers\ProductController;
//use Illuminate\Routing\Route;
use App\Http\Middleware\AdminVerify;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', 'HomeController@index')->name('home');

Route::post('/coupon','CouponController@couponValue')->name('coupon.couponValue');
Route::delete('/coupon','CouponController@destroy')->name('coupon.destroy');

Route::resource('checkout', 'OrderController');
// order invoice list
Route::get('order_list/{id}','OrdereviewController@singleOrder')->name('single');
Route::get('order_list','OrdereviewController@OrderList')->name('order_list');

// orde updaeted  admin
    Route::get('order/index/{id}', 'OrdereviewController@OrderCancel')->name('OrderCancel');
//    Route::get('order/index/{id}', 'OrdereviewController@OrderSucess')->name('OrderSucess');


// product route
Route::group(['as' =>'products.', 'prefix'=>'products'], function (){
    Route::get('/','ProductController@show')->name('all');
    Route::get('/{product}','ProductController@single')->name('single');
    Route::get('/addToCart/{product}', 'ProductController@addToCart')->name('addToCart');
});

// Cart route
Route::group(['as'=>'cart', 'prefix'=>'cart'], function (){
    Route::get('/','ProductController@cart')->name('all');
    Route::DELETE('/remove', 'ProductController@removeProduct')->name('remove');
    Route::patch('/update', 'ProductController@updateProduct')->name('update');
});
Route::group(['as'=>'admin.'], function(){
	Route::get('/admin','AdminController@dashboard')->name('dashboard');
	Route::resource('product','ProductController');
	Route::resource('category','CategoryController');
    Route::resource('order', 'OrdereviewController');

});

Auth::routes();
Auth::routes(['verify' => true]);
//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home', 'HomeController@index')->name('home');
