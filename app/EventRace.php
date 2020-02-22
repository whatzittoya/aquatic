<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRace extends Model
{
    //
    use SoftDeletes;
    protected $table = 'races';

    public function rules()
    {
        return $this->belongsToMany('App\Rule', 'event_race_categories', 'event_race_id');
    }
    public function pureRaces()
    {
        return $this->belongsTo('App\PureRace', 'pure_race_id');
    }
}
