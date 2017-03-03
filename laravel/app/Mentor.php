<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function subjects()
    {
      return $this->belongsToMany('App\Subject');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function classrooms()
    {
      return $this->belongsToMany('App\Classroom');
    }

}
