<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dsc extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function updates()
    {
      return $this->hasMany('App\dscUpdate')->orderBy('id', 'DESC');
    }

    public function endorsements()
    {
      return $this->hasMany('App\dscEndorsement');
    }

    public function endorsement($user_id)
    {
      return $this->hasOne('App\dscEndorsement')->where('user_id', $user_id)->first();
    }

    public function creators()
    {
      return $this->hasMany('App\dscCreator');
    }

    public function threeCreators()
    {
      return $this->hasMany('App\dscCreator')->limit(3);
    }

}
