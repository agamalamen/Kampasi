<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAllocatedCost extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }
}
