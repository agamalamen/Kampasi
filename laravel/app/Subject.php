<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function mentors()
    {
      return $this->belongsToMany('App\Mentor');
    }

    public function classrooms()
    {
      return $this->belongsToMany('App\Classroom');
    }

    public function scholars()
    {
      return $this->belongsToMany('App\Scholar');
    }
}
