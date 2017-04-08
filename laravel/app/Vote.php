<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function candidate()
    {
      return $this->belongsTo('App\Candidate');
    }
}
