<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
  public function school()
  {
    return $this->belongsTo('App\School');
  }

  public function users()
  {
    return $this->belongsToMany('App\User');
  }

  public function questions()
  {
    return $this->hasMany('App\Question')->orderBy('id', 'DESC');
  }

  public function subjects()
  {
    return $this->belongsToMany('App\Subject');
  }

  public function mentors()
  {
    return $this->belongsToMany('App\Mentor');
  }

  public function schedulePeriods()
  {
    return $this->belongsToMany('App\SchedulePeriod');
  }

  public function scholars()
  {
    return $this->belongsToMany('App\Scholar');
  }


}
