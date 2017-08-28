<?php

namespace App\Http\Controllers\User;

use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return response()->json(['data'=> $users], 200);
    }
    /**
    *
    *
    */
    public function show(User $user)
    {
        return response()->json(['data'=>$user], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'email'=> 'required|email|unique:users',
            'password'=>'required|confirmed'
            ]);
        $user= User::create($request->all());
        return response()->json(['data'=>$user], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:5|confirmed'
            ]);
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
            ]);
        return response()->json(['data'=>$user], 200);
    }

    
    public function update(Request $request, user $user)
    {
        //$user=auth()->user();
        $this->validate($request, [
            'name'=>'required',
            'email'=> 'required|email|unique:users,email,'.$user->id,
            'password'=>'required|confirmed'
            ]);
        $user->name= $request->name;
        $user->email=$request->email;
        $user->password= bcrypt($request->password);
        if($user->isClean()){
            return response()->json('You have not changed anything', 422);
        }
        $user->save();
        return response()->json(['data'=>$user], 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
      $user->delete(); 
      return response()->json(['data'=>$user], 200); 
    }
}
