<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable= [
    'name',
    ];

    public function permissions()
    {
    	return $this->belongsToMany('App\Permission', 'role_permission');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }
}
