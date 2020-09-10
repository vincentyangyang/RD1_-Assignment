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


Route::get('', 'baseController@index')->name('index');
Route::get('getWeek','baseController@getWeek')->name('getWeek');
Route::post('getTwoDay','baseController@getTwoDay')->name('getTwoDay');
Route::get('getRain','baseController@getRain')->name('getRain');
