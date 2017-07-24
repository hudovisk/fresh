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

//AuthController
Route::group([], function () {

    //public
    Route::post('/password/email', 'AuthController@forgotPassword');
    Route::post('/password/reset', 'AuthController@resetPassword');

    //authenticated
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/register', 'AuthController@register');
    });
});

//UserController
Route::group([], function () {

    //authenticated
    Route::group(['middleware' => ['auth:api']], function () {
        Route::put('/me', 'UserController@updateProfile');
    });
});

//AdvertisementController
Route::group(['prefix' => '/advertisements'], function () {

    //authenticated
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/', 'AdvertisementController@index');
        Route::post('/', 'AdvertisementController@create');
        Route::put('/{uuid}', 'AdvertisementController@edit');
        Route::get('/{uuid}', 'AdvertisementController@show');
        Route::delete('/{uuid}', 'AdvertisementController@delete');
    });
});
