<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register','UserController@register');
Route::post('/login','UserController@login');

Route::middleware('auth:api')->group(function () {

    Route::get('/profile','UserProfile@index');
    Route::post('/bank-info','UserProfile@bankInfo');
    Route::post('/employment-info','UserProfile@employmentInfo');
    Route::post('/next-of-kin-info','UserProfile@nextOfKin');

});
