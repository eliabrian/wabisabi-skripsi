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
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

#--Admin - Product--#
Route::get('/products', 'Admin\ProductsController@index')->name('products');
Route::get('/products/create', 'Admin\ProductsController@create');
Route::get('/products/{product}/edit', 'Admin\ProductsController@edit');
Route::post('/products', 'Admin\ProductsController@store');
Route::patch('/products/{product}', 'Admin\ProductsController@update');
Route::delete('/products/{product}', 'Admin\ProductsController@destroy');

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

#--User - Collection --#
Route::get('/collection/{category:name}', 'CollectionsController@show');

Route::view('/blocked', 'blocked');