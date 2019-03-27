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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'TestController@test');
/* Ecommerce */
Route::group(['prefix' => 'basket', 'namespace' => 'Ecommerce'], function()
{
    Route::get('/', ['as' => 'basket', 'uses' => 'BasketController@index']);
    Route::post('/', ['as' => 'basket', 'uses' => 'BasketController@update']);
    Route::any('add',['as' => 'basket.item.add', 'uses' => 'BasketController@add']);
    Route::get('{id}/remove',['as' => 'basket.item.remove', 'uses' => 'BasketController@delete']);
    Route::get('{id}/inc',['as' => 'basket.item.inc', 'uses' => 'BasketController@inc']);
    Route::get('{id}/dec',['as' => 'basket.item.dec', 'uses' => 'BasketController@dec']);
    Route::get('destroy',['as' => 'basket.destroy', 'uses' => 'BasketController@destroy']);
    Route::get('debug',['as' => 'basket.debug', 'uses' => 'BasketController@debug']);

    Route::get('demo', ['as' => 'basket.demo', 'uses' => 'BasketController@demo']);
});

Route::group(['prefix' => 'product', 'namespace' => 'Ecommerce'], function()
{
    Route::get('/', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::get('items', ['as' => 'product.items', 'uses' => 'ProductController@items']);
    Route::get('item/{id}', ['as' => 'product.item', 'uses' => 'ProductController@item'])->where('id', '[0-9]+');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
