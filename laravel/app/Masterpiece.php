<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterpiece extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
