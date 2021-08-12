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
Route::get('/', function () {
    return view('welcome', ['sales' => 'Samantha']);
});
*/


Route::get('/', 'App\Http\Controllers\StockController@showProducts');
Route::get('/calculate', 'App\Http\Controllers\StockController@calculate');
