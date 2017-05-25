<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryAttribute extends Model
{
  public function inventory()
  {
    return $this->belongsTo('App\Inventory');
  }

  public function itemAttributes()
  {
    return $this->hasMany('App\ItemAttribute');
  }
}
