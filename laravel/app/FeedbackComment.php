<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackComment extends Model
{
  public function feedback()
  {
    return $this->belongsTo('App\Feedback');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
