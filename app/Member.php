<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    //
    use SoftDeletes;
    protected $table = 'members';
    protected $primaryKey = 'id';
    // protected $fillable = ['name', 'best_time', 'born_date', 'club_id', 'valid'];
    public function clubs()
    {
        return $this->belongsTo('App\Club', 'club_id');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
