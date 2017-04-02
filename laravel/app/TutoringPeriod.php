<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutoringPeriod extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function tutorings()
    {
      return $this->hasMany('App\Tutoring');
    }
}
