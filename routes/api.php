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

Route::group(['middleware'=>['auth:api']], function(){
	Route::resource('users', 'User\UserController',['except'=>['edit']]);
	Route::resource('roles', 'Role\RoleController', ['only'=>['index', 'store', 'destroy']]);
	Route::resource('roles.permissions', 'Role\RolePermissionController', ['only'=>['index', 'store']]);
	Route::resource('permissions', 'Permission\PermissionController', ['only'=>['index', 'store', 'destroy']]);
	Route::resource('users.roles', 'User\UserRoleController', ['only'=>['index', 'store']]);
	Route::resource('users.permissions', 'User\UserPermissionController', ['only'=>['index', 'store']]);
	Route::get('users/{user}/standalonepermissions', 'User\UserPermissionController@standAlonePermissions');
});

