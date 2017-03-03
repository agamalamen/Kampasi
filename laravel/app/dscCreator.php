<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dscCreator extends Model
{
    public function dsc()
    {
      return $this->belongsTo('App\dsc');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

}
