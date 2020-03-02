<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    public function races()
    {
        return $this->hasMany('App\EventRace')->withTrashed();
    }

    public function participants()
    {
        return $this->hasMany('App\Participant')->withTrashed();
    }
}
