<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutorSubject extends Model
{
    public function tutor()
    {
      return $this->belongsTo('App\Tutor');
    }

    public function tutoringSubject()
    {
      return $this->belongsTo('App\TutoringSubject');
    }

    public function tutorings()
    {
      return $this->hasMany('App\Tutoring');
    }

}
