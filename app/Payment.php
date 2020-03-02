<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    public function clubs()
    {
        return $this->belongsTo('App\Club', 'club_id')->withTrashed();
    }

    public function events()
    {
        return $this->belongsTo('App\Event', 'event_id')->withTrashed();
    }
}
