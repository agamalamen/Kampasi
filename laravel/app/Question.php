<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function classroom()
    {
      return $this->belongsTo('App\Classroom');
    }

    public function answers()
    {
      return $this->hasMany('App\Answer');
    }

    public function bestAnswers()
    {
      return $this->hasMany('App\Answer')->limit(2)->orderBy('id', 'DESC');
    }

    public function tags()
    {
      return $this->hasMany('App\Tag');
    }
}
