<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function inventory()
    {
      return $this->belongsTo('App\Inventory');
    }
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function itemAttributes()
    {
      return $this->hasMany('App\ItemAttribute');
    }

    public function users()
    {
      return $this->hasMany('App\User')->withPivot('received_date', 'return_date');
    }

    public function allocatedCosts()
    {
      return $this->hasMany('App\UserAllocatedCost');
    }
}
