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
        return $this->belongsToMany('App\Rule', 'event_race_categories', 'event_race_id')->withTrashed();
    }
    public function pureRaces()
    {
        return $this->belongsTo('App\PureRace', 'pure_race_id')->withTrashed();
    }

    public function participants()
    {
        return $this->hasMany('App\Participant', 'race_id')->where('series', '>', 0)->where('valid_payment', 1)->select('id', 'club_id', 'race_id', 'event_id', 'member_id', 'best_time', 'line_number', 'series', 'result', 'category_rule_id')->orderBy('series', 'asc')->orderBy('line_number', 'asc')->withTrashed();
    }
    public function participantsResult()
    {
        return $this->hasMany('App\Participant', 'race_id')->where('series', '>', 0)->where('valid_payment', 1)->select('id', 'club_id', 'race_id', 'event_id', 'member_id', 'best_time', 'line_number', 'series', 'result', 'category_rule_id')->orderBy('best_time', 'asc')->withTrashed();
    }
}
