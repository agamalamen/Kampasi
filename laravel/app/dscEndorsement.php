<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dscEndorsement extends Model
{
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function dsc()
  {
    return $this->belongsTo('App\dsc');
  }

}
