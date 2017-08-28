<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserRoleController extends Controller
{
    public function index(User $user)
    {
    	$roles=$user->roles;
    	return response()->json(['data'=>$roles], 200);
    }
    
    public function store(User $user, Request $request)
    {
    	
    	$roleId= $request->all();
    	// $roles = collect( $request->all());
    	//$roleIds= $roles->values()->all();
    	$user->roles()->sync($roleId);
    	return response()->json(['data'=>'roles updated'], 200);
    	
    } 
}

