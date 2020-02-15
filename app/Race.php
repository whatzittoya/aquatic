<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Race extends Model
{
    use SoftDeletes;

    public function rule()
    {
        return $this->belongsTo('App\Rule', 'rule_id');
    }
    public function event()
    {
        return $this->belongsToMany('App\Event', 'event_race');
    }
}
