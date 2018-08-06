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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//All api of v1
Route::prefix('v1')->group(function () {
    
//get token
Route::get('gettoken', 'Api\V1\DefaultController@gettoken');


//Register
Route::post('user/register', 'Api\V1\UserController@register');
//login
Route::post('user/login', 'Api\V1\UserController@login');
//logout
Route::post('user/logout', 'Api\V1\UserController@logout');


});



//End of All api of v1