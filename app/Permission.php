<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable= [
    'name',
    ];

    public function roles()
    {
    	return $this->belongsToMany('App\Role', 'role_permission');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }
}
