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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();




Route::get('showbalance', 'App\Http\Controllers\HomeController@showbalance')
	->name('home.showbalance');

Route::resource('/home', 'App\Http\Controllers\HomeController');

Route::get('/', function () {
    return redirect()->route('home.index');
});


//------------------------------------------------

//Route::resource('nomenclatures', 'App\Http\Controllers\NomenclaturesController');

//------------------------------------------------

//Route::resource('subdivision', 'App\Http\Controllers\SubdivisionController');

//------------------------------------------------

Route::resource('writeoffs', 'App\Http\Controllers\WriteOffOfMaterialController');

//------------------------------------------------

Route::resource('users', 'App\Http\Controllers\UsersController');

//------------------------------------------------

Route::resource('orders', 'App\Http\Controllers\OrderMaterialController');

//------------------------------------------------

Route::resource('receipts', 'App\Http\Controllers\ReceiptOfMaterialController');

//------------------------------------------------
