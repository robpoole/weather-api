<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Weather;

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

/*Route::group(['middleware' => 'auth:api'], function() {
    Route::get('weather/{location}', 'WeatherController@index');
});*/
Route::get('cities', 'App\Http\Controllers\Cities@index');
Route::get('weather/{location}', 'App\Http\Controllers\Weather@index');