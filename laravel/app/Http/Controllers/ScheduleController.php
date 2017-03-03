<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\School;

class ScheduleController extends Controller
{

    public function getSchedule()
    {
      $school = School::find(1);
      $subjects = $school->subjects;
      $classrooms = $school->classrooms;
      $days = $school->scheduleDays;
      $mentors = $school->mentors;
      return view('app.school.schedule.schedule')->with(['subjects' => $subjects, 'classrooms' => $classrooms, 'days' => $days, 'mentors' => $mentors]);
    }

    public function getScheduleDays()
    {
      foreach (Auth::User()->school->scheduleDays as $day) {
        foreach($day->schedulePeriods as $period) {
          echo $period;
        }
      }
    }
}
