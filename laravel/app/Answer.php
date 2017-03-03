<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function question()
    {
      return $this->belongsTo('App\Question');
    }

    public function corrects()
    {
      return $this->hasMany('App\correct')->where('correct', 1);
    }
}
