<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $data=[];
        foreach(auth()->user()->roles as $role)
        {
            foreach($role->permissions as $perm)
            {
                if($perm->name == $permission)
                {
                    $data[]= $permission;
                }
            }
        }
        foreach(auth()->user()->permissions as $p)
        {
            if($p->name == $permission)
            {
                $data[]=$permission;
            }
        }
        if($data == null)
        {
            return response()->json('you are forbidden', 403);
        }
        return $next($request);
    }
}
