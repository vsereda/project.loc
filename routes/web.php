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

//Test routes
Route::get('/test1', 'TestController@test1');
Route::get('/test2', 'TestController@test2');

//Auth routes
Auth::routes();
Route::get('login', 'Auth\LoginUserController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginUserController@login');
Route::get('register', 'Auth\RegisterUserController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterUserController@register');
Route::group(['prefix' => 'employee'], function () {
    Route::redirect('/', 'login');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('kitchen_login');
    Route::post('login', 'Auth\LoginController@login');
});


Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@show')->name('home.show');
Route::resource('dishes', 'DishController')->only(['show']);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', 'ProductController')->only(['index']);

    // ORDER ROUTES
        Route::get('orders/tasks', 'OrderController@tasks')->middleware(['role:kitchener'])->name('orders.tasks');
        Route::get('orders/kitchen', 'OrderController@kitchen')->middleware(['role:kitchener|courier'])->name('orders.kitchen');
        Route::get('orders/delivery', 'OrderController@delivery')->middleware(['role:kitchener|courier'])->name('orders.delivery');
        Route::post('orders/create', 'OrderController@create')->middleware(['role:user'])->name('orders.create');

        // Absent resource methods in orders. May be in future these will be used. If it is, not forget role middlewares.
        Route::resource('orders', 'OrderController')->except(['index', 'create', 'show', 'edit', 'update', 'destroy']);

    Route::resource('delivery', 'DeliveryController')->only(['index', 'store'])->middleware(['role:courier']);
});