<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OffCampusRequest extends Model
{
  public function school()
  {
    return $this->belongsTo('App\School');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function users()
  {
    return $this->belongsToMany('App\User');
  }

  public function absences()
  {
    return $this->hasMany('App\Absence');
  }
}
