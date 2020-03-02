<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    public function club()
    {
        return $this->belongsTo('App\Club', 'club_id')->withTrashed();
    }
    public function member()
    {
        return $this->belongsTo('App\Member', 'member_id')->withTrashed();
    }
    public function race()
    {
        return $this->belongsTo('App\EventRace', 'race_id')->withTrashed();
    }
    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id')->withTrashed();
    }
    public function rule()
    {
        return $this->belongsTo('App\Rule', 'category_rule_id')->withTrashed();
    }
}
