<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableChaperone extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
