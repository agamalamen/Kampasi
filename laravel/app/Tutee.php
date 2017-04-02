<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutee extends Model
{
    public function tutorings()
    {
      return $this->hasMany('App\Tutoring');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
