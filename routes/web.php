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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

#--Admin--#
Route::get('/dashboard', 'DashboardController@index')->middleware('role:Admin')->name('dashboard');

#--Admin - Product--#
Route::get('/products', 'Admin\ProductsController@index')->middleware('role:Admin')->name('products');
Route::get('/products/create', 'Admin\ProductsController@create')->middleware('role:Admin');
Route::get('/products/{product}/edit', 'Admin\ProductsController@edit')->middleware('role:Admin');
Route::post('/products', 'Admin\ProductsController@store')->middleware('role:Admin');
Route::patch('/products/{product}', 'Admin\ProductsController@update')->middleware('role:Admin');
Route::delete('/products/{product}', 'Admin\ProductsController@destroy')->middleware('role:Admin');


Route::get('/product/{product}', 'ProductsController@show');


Route::get('/carts', 'CartsController@index')->name('cart');
Route::post('/carts/store', 'CartsController@store');
Route::delete('/carts/{cart}', 'CartsController@destroy');
Route::get('/carts/{cart}/increment', 'CartsController@increment');
Route::get('/carts/{cart}/decrement', 'CartsController@decrement');



#--Admin - Categories--#
// Route::get('/categories', 'Admin\CategoriesController@index')->name('categories');
// Route::get('/categories/create', 'Admin\CategoriesController@create');
// Route::get('/categories/{category}/edit', 'Admin\CategoriesController@edit');
// Route::post('/categories', 'Admin\CategoriesController@store');
// Route::patch('/categories/{category}', 'Admin\CategoriesController@update');
// Route::delete('/categories/{category}', 'Admin\CategoriesController@destroy');

Route::resource('/categories', 'Admin\CategoriesController')->middleware('role:Admin');
#--Admin - Details--#
Route::resource('/details', 'Admin\DetailsController')->middleware('role:Admin');

#--Admin - Roles--#
Route::resource('/roles', 'Admin\RolesController')->middleware('role:Admin');

#--Admin - Roles--#
Route::resource('/users', 'Admin\UsersController')->middleware('role:Admin');

#--Admin - Orders--#
Route::resource('/admin/orders', 'Admin\OrdersController')->middleware('role:Admin');
Route::get('/admin/orders/{order:order_code}', 'Admin\OrdersController@show')->middleware('role:Admin');
Route::patch('/admin/shipment/{shipment}', 'Admin\ShipmentController@update')->middleware('role:Admin');

#--User - Collection --#
Route::get('/collection/{category:name}', 'CollectionsController@show');


// Route::view('/blocked', 'blocked');d

Route::resource('/shipments', 'ShipmentsController')->middleware('auth');
Route::get('/orders/create', 'OrdersController@create');
Route::get('/orders', 'OrdersController@index')->name('orders');
Route::get('/order/{order:order_code}', 'OrdersController@show');
Route::delete('/order/{order:order_code}', 'OrdersController@destroy');


Route::get('/profile', 'ProfileController@show')->middleware('auth');