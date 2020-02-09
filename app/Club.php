<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    //
    protected $table = 'clubs';
    protected $primaryKey = 'id';
    use SoftDeletes;
    public function members()
    {
        return $this->hasMany('App/Member');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
