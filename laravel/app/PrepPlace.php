<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrepPlace extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function users()
    {
      return $this->hasMany('App\User');
    }

    public function prep()
    {
      return $this->hasOne('App\Prep');
    }
}
