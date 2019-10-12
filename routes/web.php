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
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('checkout', 'OrderController');

Route::group(['as' =>'products.', 'prefix'=>'products'], function (){
    Route::get('/','ProductController@show')->name('all');
    Route::get('/{product}','ProductController@single')->name('single');
    Route::get('/addToCart/{product}', 'ProductController@addToCart')->name('addToCart');
});

Route::group(['as'=>'cart', 'prefix'=>'cart'], function (){
    Route::get('/','ProductController@cart')->name('all');
    Route::delete('/remove', 'ProductController@removeProduct')->name('remove');
    Route::patch('/update', 'ProductController@updateProduct')->name('update');
});
Route::group(['as'=>'admin.'], function(){
	Route::get('/admin','AdminController@dashboard')->name('dashboard');
	Route::resource('product','ProductController');
	Route::resource('category','CategoryController');
});


//Route::get('/home', 'HomeController@index')->name('home');
