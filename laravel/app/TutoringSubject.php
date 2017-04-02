<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutoringSubject extends Model
{
      public function turtorSubject()
      {
        return $this->hasMany('App\TutorSubject');
      }

      public function school()
      {
        return $this->belongsTo('App\School');
      }
}
