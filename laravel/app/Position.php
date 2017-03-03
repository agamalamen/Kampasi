<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  public function candidates()
  {
    return $this->hasMany('App\Candidate');
  }

  public function school()
  {
    return $this->belongsTo('App\School');
  }

}
