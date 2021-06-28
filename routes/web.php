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

Route::get('/pos-cashier', 'App\Http\Controllers\PosCashierController@index')->name('index');

Route::get('/new-order', 'App\Http\Controllers\PosCashierController@newOrder')->name('newOrder');
Route::get('/request-refund', 'App\Http\Controllers\PosCashierController@requestRefund')->name('requestRefund');

Route::get('/get-orders', 'App\Http\Controllers\PosCashierController@getOrders')->name('getOrders');
Route::post('/refund-order', 'App\Http\Controllers\PosCashierController@refundOrder')->name('refundOrder');

Route::get('/get-products', 'App\Http\Controllers\PosCashierController@getProducts')->name('getProducts');
Route::post('/add-products', 'App\Http\Controllers\PosCashierController@addProducts')->name('addProducts');

Route::post('/check-out', 'App\Http\Controllers\PosCashierController@checkOut')->name('checkOut');
