<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    public function member()
    {
        return $this->belongsTo('App\Member', 'member_id');
    }
    public function race()
    {
        return $this->belongsTo('App\Race', 'race_id');
    }
    public function event()
    {
        return $this->race()->id;
    }
}
