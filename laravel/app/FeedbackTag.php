<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackTag extends Model
{
    public function feedback()
    {
      return $this->belongsTo('App\Feedback');
    }
}
