<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
	public function offCampusRequest()
  	{
    	return $this->belongsTo('App\OffCampusRequest');
  	}

  	public function user()
  	{
  		return $this->belongsTo('App\User');
  	}
}
