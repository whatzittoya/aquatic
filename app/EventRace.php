<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRace extends Model
{
    //
    use SoftDeletes;
    protected $table = 'event_race';
}
