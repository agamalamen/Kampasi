<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function authority()
    {
      return $this->HasOne('App\Authority');
    }

    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function classrooms()
    {
      return $this->belongsToMany('App\Classroom');
    }

    public function classroom($id)
    {
      return $this->belongsTo('App\Classroom')->where('id', $id);
    }

    public function questions()
    {
      return $this->hasMany('App\Question');
    }

    public function answers()
    {
      return $this->hasMany('App\Answer');
    }

    public function corrects()
    {
      return $this->hasMany('App\Correct')->where('correct', 1);
    }

    public function endorsements()
    {
      return $this->hasMany('App\Endorsement');
    }

    public function correct($answer_id)
    {
      return $this->hasOne('App\Correct')->where('answer_id', $answer_id)->first();
    }

    public function offCampusRequests()
    {
      return $this->hasMany('App\OffCampusRequest')->orderBy('id', 'DESC');
    }

    public function offCampusRequest()
    {
      return $this->hasMany('App\OffCampusRequest')->orderBy('id', 'DESC')->limit(1);
    }

    public function notifications()
    {
      return $this->hasMany('App\Notification')->orderBy('id', 'DESC')->limit(6);
    }

    public function allNotifications()
    {
      return $this->hasMany('App\Notification')->orderBy('id', 'DESC');
    }

    public function unseenNotifications()
    {
      return $this->hasMany('App\Notification')->where('seen', 0);
    }

    public function preps()
    {
      return $this->hasMany('App\Prep')->orderBy('id', 'DESC');
    }

    public function prep()
    {
      return $this->hasOne('App\Prep')->where('date', date('Y-m-d'));
    }

    public function nightWatcher()
    {
      return $this->hasOne('App\NightWatcher');
    }

    public function hall()
    {
      return $this->belongsTo('App\Hall');
    }

    public function mentor()
    {
      return $this->hasOne('App\Mentor');
    }

    public function student()
    {
      return $this->hasOne('App\Mentor');
    }

    public function scholar()
    {
      return $this->hasOne('App\Scholar');
    }

    public function prepPlace()
    {
      return $this->belongsTo('App\PrepPlace');
    }

    public function masterpiece()
    {
      return $this->hasMany('App\Masterpiece');
    }

    public function feedbacks()
    {
      return $this->hasMany('App\Feedback');
    }

    public function feedbackComments()
    {
      return $this->hasMany('App\FeedbackComment');
    }

    public function externalChaperones()
    {
      return $this->hasMany('App\ExternalChaperone');
    }

    public function transactions()
    {
      return $this->hasMany('App\Transaction');
    }

    public function candidate()
    {
      return $this->hasOne('App\Candidate');
    }

    public function votes()
    {
      return $this->hasMany('App\Vote');
    }

    public function availableChaperones()
    {
      return $this->hasMany('App\AvailableChaperone');
    }

    public function electionsComments()
    {
      return $this->hasMany('App\ElectionsComment');
    }

    public function tutor()
    {
      return $this->hasOne('App\Tutor');
    }

    public function items()
    {
      return $this->belongsToMany('App\Item')->withPivot('received_date', 'return_date');
    }

    public function inventories()
    {
      return $this->hasMany('App\Inventory');
    }

    public function allocatedCosts()
    {
      return $this->hasMany('App\UserAllocatedCost')->where('paid', 0);
    }

    public function paidAllocatedCosts()
    {
      return $this->hasMany('App\UserAllocatedCost')->where('paid', 1);
    }
}
