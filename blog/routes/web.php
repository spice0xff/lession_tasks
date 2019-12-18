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

//Route::get('/test/one', 'TestController@getOne');
//
//// curl -X POST http://192.168.186.135:8001/test/one -d "name=Bob&age=44&flag=1"
//Route::post('/test/one', 'TestController@setOne');

Route::group(['prefix' => '/test'], function () {
    Route::get('/one', 'TestController@getOne');
    Route::post('/one', 'TestController@setOne');
});
