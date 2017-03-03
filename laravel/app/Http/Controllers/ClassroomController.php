<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;
use App\Classroom;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function getClassrooms($school_username)
    {
      $school = School::where('username', $school_username)->first();
      if (empty($school)) {
        return view('errors.503');
      }
      return view('app.school.classrooms.classrooms')->with(['school' => $school]);
    }

    public function getClassroom($school_username, $classroom_username)
    {
      $school = School::where('username', $school_username)->first();
      $classroom = Classroom::where('username', $classroom_username)->first();
      if (empty($school)) {
        return view('errors.503');
      } else if (empty($classroom)) {
        return view('errors.503');
      }

      return view('app.school.classrooms.classroom')->with(['school' => $school, 'classroom' => $classroom]);
    }
}
