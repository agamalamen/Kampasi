<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
    public function itemAttributes()
    {
      return $this->belongsTo('App\Item');
    }

    public function inventoryAttribute()
    {
      return $this->belongsTo('App\InventoryAttribute');
    }
}
