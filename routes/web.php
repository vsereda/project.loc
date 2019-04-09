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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/home', function (){
    return 'HOME!!!';
});
Route::get('/test1', 'TestController@test1');
Route::get('/test2', 'TestController@test2');
Auth::routes();

Route::get('/', 'Home_Controller@index')->name('home');
Route::resource('products', 'ProductController');

Route::resource('items', 'BasketController');
Route::resource('orders', 'OrderController');


Route::group(['middleware' => 'auth'], function () {

    Route::resource('addresses', 'AddressesController');

//    Route::group([
//        'prefix' => 'kitchen',
//        'middleware' => 'role:superadministrator|administrator|kitchener',
//        ], function () {
//            Route::resource('orders', 'OrderController');
//            Route::get('/', 'KitchenController@index')->name('kitchen');
//            Route::get('/dinner/{number}', 'KitchenController@diner_number')->name('dinner')->where('number', '[0-9]+');
//    });
//    Route::get('/delivery', 'CourierController@index')->name('courier')
//        ->middleware(['role:superadministrator|administrator|courier']);
});

