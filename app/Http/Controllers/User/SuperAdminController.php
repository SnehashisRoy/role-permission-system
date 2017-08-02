<?php

namespace App\Http\Controllers\User;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperAdminController extends Controller
{
    public function allUsers()
    {
    	$user= User::all();
    	return response()->json($user, 200);
    }

    public function createRole(Request $request)
    {
    	$this->validate($request, [
    		'name'=>'required'
    		]);
    	$role= Role::create($request->all());
    	return response()->json($role, 200);
    }
    public function createPermission(Request $request)
    {
    	$this->validate($request, [
    		'name'=>'required'
    		]);
    	$permission= Permission::create($request->all());
    	return response()->json($permission, 200);
    }
    public function showPermissionOfRole(Role $role)
    {
    	$permissions= Permission::all();
    	$permissionIds= [];
    	foreach($role->permissions as $permission)
    	{
    		
    		$permissionIds[]= $permission->id;

    	}
    	$results= [
    	'permissions'=> $permissions,
    	'permissionIds'=> collect($permissionIds)->toJson()
    	];
    	return response()->json($results, 200);


    }

    public function assignPermissionsToRole(Request $request, Role $role)
    {
    	$permission = collect($request->all());
    	$permissionIds= $permission->values()->all();
    	$role->permissions()->sync($permissionIds);
    	return response()->json('permissions assigned to role', 200);

    }

    public function userRolePermission(User $user)
    {
    	$roles= Role::all();
    	$permissions = Permission::all();
    	$standAlonePermission = [];
    	foreach($permissions as $permission)
    	{
    		foreach($user->roles as $role)
    		{
    			foreach($role->permissions as $perm)
    			{
    				if($perm->id !== $permission->id)
    				{
    					$standAlonePermission[]= $permission;
    				}
    			}
    		}
    	}
    	$roleIds = [];
    	foreach($user->roles as $role)
    	{
    		$roleIds[]= $role->id;
    	}
    	$permissionIds = [];
    	foreach($user->permissions as $permission)
    	{
    		$permissionIds[]= $permission->id;
    	}
    	$result=[
    	'roles'=>$roles,
    	'standAlonePermissions'=> $standAlonePermission,
    	'roleIds'=>$roleIds,
    	'permissionIds'=>$permissionIds
    	];
    	return response()->json($results, 200);

    }



}
