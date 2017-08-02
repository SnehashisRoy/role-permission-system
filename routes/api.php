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
//public route
Route::group(['middleware'=>[]], function(){
	Route::post('register', 'User\UserController@store');
	//Route::post('checkEmail', 'User\UserController@checkEmail');
	//Route::post('resetPassword', User\UserController@resetPassword);


});
//authenticated route
Route::group(['middleware'=>[/*'auth:api']*/]], function(){
	Route::put('updateuser', 'User\UserController@update');
	Route::get('allusers', 'User\SuperAdminController@allUsers');
	Route::post('createrole', 'User\SuperAdminController@createRole');
	Route::post('createpermission', 'User\SuperAdminController@createPermission');
	Route::get('role/{role}/assignpermission', 'User\SuperAdminController@showPermissionOfRole');
	Route::post('role/{role}/assignpermission', 'User\SuperAdminController@assignPermissionsToRole');
	Route::get('user/{user}/rolepermission', 'User\SuperAdminController@showRolePermission');
	Route::post('user/{user}/rolepermission', 'User\SuperAdminController@assignRolePermission');

});


