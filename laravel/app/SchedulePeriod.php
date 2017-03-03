<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedulePeriod extends Model
{
    public function scheduleDay()
    {
      return $this->belongsTo('App\ScheduleDay');
    }

    public function classrooms()
    {
      return $this->belongsToMany('App\Classroom');
    }
}
