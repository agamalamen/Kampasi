<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prep extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function prepPlace()
    {
      return $this->belongsTo('App\prepPlace', 'place');
    }
}
