<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function items()
    {
      return $this->hasMany('App\Item')->where('deleted', 0)->orderBy('id', 'DESC');
    }

    public function recentItems()
    {
      return $this->hasMany('App\Item')->where('deleted', 0)->limit(3)->orderBy('id', 'DESC');
    }

    public function attributes()
    {
      return $this->hasMany('App\InventoryAttribute');
    }

    public function users()
    {
      return $this->belongsToMany('App\User')->orderBy('id', 'DESC');
    }

    public function recentUsers()
    {
      return $this->belongsToMany('App\User')->limit(3)->orderBy('id', 'DESC');
    }
}
