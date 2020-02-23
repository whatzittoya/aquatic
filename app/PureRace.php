<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PureRace extends Model
{
    use SoftDeletes;
    public function event()
    {
        return $this->belongsToMany('App\Event', 'event_race');
    }
    public function races()
    {
        return $this->hasMany('App\EventRace', 'pure_race_id');
    }
}
