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
Route::get('/test','UserController@test');


Route::middleware('auth:api')->group(function () {

    Route::post('/profile','UserProfile@index');
    Route::post('/user-profile','UserProfile@updateUserProfile');
    Route::post('/bank-info','UserProfile@bankInfo');
    Route::post('/employment-info','UserProfile@employmentInfo');
    Route::post('/next-of-kin-info','UserProfile@nextOfKinInfo');
    Route::post('/loan-request','Loans@loanRequest');
    Route::post('/loans','Loans@index');
    Route::post('/dashboard','Dashboard@index');
    Route::post('/image-upload','UserProfile@uploadProfilePicture');
    Route::post('/loan-history','Loans@loanHistory');
    Route::post('/contact-us','UserProfile@contactUs');
    Route::post('/user-confirm-amount','Loans@userConfirmAmount');
    Route::post('/get-loan-amount','Loans@getLoanAmount');
    Route::post('/success-transaction','Loans@successTransaction');
});
