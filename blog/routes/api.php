<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => '/test', 'middleware' => 'apikey'], function () {
    // curl -X GET http://192.168.186.135:8001/api/test/one
    Route::get('/one', 'TestController@getOne');
    // curl -X POST http://192.168.186.135:8001/api/test/one -d "name=Bob&age=44&flag=1"
    Route::post('/one', 'TestController@setOne');
});

