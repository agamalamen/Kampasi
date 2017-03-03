<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function election()
    {
      return $this->belongsTo('App\Election');
    }

}
