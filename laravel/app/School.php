<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function users()
    {
      return $this->hasMany('App\User')->orderBy('id', 'DESC');
    }

    public function recentUsers()
    {
      return $this->hasMany('App\User')->orderBy('id', 'DESC')->limit(5);
    }

    public function students()
    {
      return $this->hasMany('App\User')->where('role', 'student')->orderBy('name', 'ASC');
    }

    public function elections()
    {
      return $this->hasMany('App\Election')->orderBy('views', 'DESC');
    }

    public function classrooms()
    {
      return $this->hasMany('App\Classroom');
    }

    public function offCampusRequests()
    {
      return $this->hasMany('App\OffCampusRequest')->orderBy('id', 'DESC');
    }

    public function offCampusRequest()
    {
      return $this->hasMany('App\OffCampusRequest')->orderBy('id', 'DESC')->limit(1);
    }

    public function offCampusArrivedRequests()
    {
      return $this->hasMany('App\OffCampusRequest')->where('arrived', 1);
    }

    public function offCampusDepartedRequests()
    {
      $matchThese = ['departed' => 1, 'arrived' => 0];
      return $this->hasMany('App\OffCampusRequest')->where($matchThese);
    }

    public function offCampusAcceptedRequests()
    {
      $matchThese = ['departed' => 0, 'arrived' => 0, 'student_life_approval' => 'accepted', 'security_approval' => 'accepted', 'driver_approval' => 'accepted'];
      return $this->hasMany('App\OffCampusRequest')->where($matchThese);
    }

    public function preps()
    {
      return $this->hasMany('App\Prep')->orderBy('date', date('Y-m-d'));
    }

    public function recentPreps()
    {
      return $this->hasMany('App\Prep')->orderBy('date', date('Y-m-d'))->limit(10);
    }

    public function todayPreps()
    {
      return $this->hasMany('App\Prep')->where('date', date('Y-m-d'));
    }

    public function todayOnTimePreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'late' => 0, 'here' => 1];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function todayLatePreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'late' => 1, 'here' => 1];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function reportLatePreps($date) {
      $matchThese = ['date' => $date, 'late' => 1, 'here' => 1];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function reportNotHerePreps()
    {
      $matchThese = ['here' => 0];
      return $this->hasMany('App\Prep')->where($matchThese);
    }
    public function todayNotHerePreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'here' => 0];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function todayDormsPreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'place' => 2];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function todayMSTPreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'place' => 3];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function todayClassroomsPreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'place' => 1];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function todayDinningHallPreps()
    {
      $matchThese = ['date' => date('Y-m-d'), 'place' => 4];
      return $this->hasMany('App\Prep')->where($matchThese);
    }

    public function todayNightWatchers()
    {
      return $this->hasMany('App\NightWatcher')->where('date', date('Y-m-d'));
    }

    public function halls()
    {
      return $this->hasMany('App\Hall');
    }

    public function dscs()
    {
      $dscs = $this->hasMany('App\dsc')->orderBy('endorsements_count', 'DESC');
      return $dscs->orderBy('progress', 'DESC');
    }

    public function subjects()
    {
      return $this->hasMany('App\Subject');
    }

    public function mentors()
    {
      return $this->hasMany('App\Mentor');
    }

    public function scheduleStudents()
    {
      return $this->hasMany('App\Student');
    }

    public function scholars()
    {
      return $this->hasMany('App\Scholar');
    }

    public function scheduleDays()
    {
      return $this->hasMany('App\ScheduleDay');
    }

    public function prepPlaces()
    {
      return $this->hasMany('App\PrepPlace');
    }

    public function feedbacks()
    {
      return $this->hasMany('App\Feedback')->orderBy('points', 'DESC');
    }

    public function recentFeedbacks()
    {
      return $this->hasMany('App\Feedback')->orderBy('points', 'DESC')->limit(4);
    }

    public function externalChaperones()
    {
      return $this->hasMany('App\ExternalChaperone')->orderBy('id', 'DESC');
    }

    public function positions()
    {
      return $this->hasMany('App\Position');
    }

    public function availableChaperones()
    {
      return $this->hasMany('App\AvailableChaperone');
    }

}
