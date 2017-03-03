<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function position()
    {
      return $this->belongsTo('App\Position');
    }
}
