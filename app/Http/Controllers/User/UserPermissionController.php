<?php

namespace App\Http\Controllers\User;

use \App\User;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPermissionController extends Controller
{
    public function index(User $user)
    {
    	$permissions=$user->permissions;
    	return response()->json(['data'=>$permissions], 200);    	
    }
    public function store(Request $request , User $user)
    {
    	$permissionIds= $request->all();
    	//dd($permissionIds);
    	$user->permissions()->sync($permissionIds);
    	return response()->json(['data'=>'Permissions updated'], 200);
    }
    public function standAlonePermissions(User $user)
    {
    	$permissions= Permission::all()->map(function($item)use($user){
             foreach($user->roles as $role)
             {
             	foreach($role->permissions as $permission)
             	{
             		if ($item->id == $permission->id)
             		{
             			return null;
             		}
             	}
             }
             return $item;
    	})->all();
    	$standAlonePermissions= array_values(array_filter($permissions));
    	return response()->json(['data'=> $standAlonePermissions], 200);

    }
}
