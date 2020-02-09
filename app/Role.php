<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function permisions()
    {
        return $this->belongsToMany('App\Permission', 'permission_role');
    }
    public function hasAccess($permissions)
    {
        return $this->permisions()->where('slug', $permissions)->count() == 1;
    }
}
