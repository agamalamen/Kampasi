<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function schedulePeriods()
    {
      return $this->hasMany('App\SchedulePeriod');
    }
}
