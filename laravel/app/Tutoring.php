<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutoring extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function tutor()
    {
      return $this->belongsTo('App\Tutor');
    }

    public function tutorSubject()
    {
      return $this->belongsTo('App\TutorSubject');
    }

    public function tutee()
    {
      return $this->belongsTo('App\Tutee');
    }

    public function tutoringPeriod()
    {
      return $this->belongsTo('App\TutoringPeriod');
    }
}
