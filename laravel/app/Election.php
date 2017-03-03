<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
      public function school()
      {
        return $this->belongsTo('App\School');
      }

      public function endorsements()
      {
        return $this->hasMany('App\Endorsement');
      }

      public function endorsement($user_id)
      {
        return $this->hasOne('App\Endorsement')->where('user_id', $user_id)->first();
      }


}
