<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function subjects()
    {
      return $this->hasMany('App\TutorSubject');
    }

    public function tutorings()
    {
      return $this->hasMany('App\Tutoring');
    }
}
