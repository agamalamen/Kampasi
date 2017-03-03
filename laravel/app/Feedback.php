<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function tags()
    {
      return $this->hasMany('App\FeedbackTag');
    }

    public function comments()
    {
      return $this->hasMany('App\FeedbackComment')->orderBy('id', 'DESC');
    }

    public function up_supports()
    {
      return $this->hasMany('App\FeedbackSupport')->where('support', 1);
    }

    public function down_supports()
    {
      return $this->hasMany('App\FeedbackSupport')->where('support', 0);
    }

    public function up_support($user_id)
    {
      return $this->hasOne('App\FeedbackSupport')->where(['user_id' => $user_id, 'support' => 1])->first();
    }

    public function down_support($user_id)
    {
      return $this->hasOne('App\FeedbackSupport')->where(['user_id' => $user_id, 'support' => 0])->first();
    }

}
