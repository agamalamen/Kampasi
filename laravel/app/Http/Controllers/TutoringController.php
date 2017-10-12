<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\School;
use App\Tutoring;
use App\Tutee;
use App\Tutor;
use App\TutorSubject;
use App\User;

class TutoringController extends Controller
{
    public function getTutoring($school_username)
    {
      $userWatchingToday = 0;
      foreach(Auth::User()->school->todayNightWatchers as $nightWatcher) {
        if($nightWatcher->user_id == Auth::User()->id) {
          $userWatchingToday = 1;
          break;
        }
      }
      $school = School::where('username', $school_username)->first();
      return view('app.school.tutoring.tutoring')->with(['school' => $school, 'userWatchingToday' => $userWatchingToday]);
    }

    public function getTutors($school_username)
    {
      /*if(Auth::User()->role == 'student') {
        return redirect()->route('get.tutoring', $school_username)->with(['message' => 'You are not autorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }*/
      $school = School::where('username', $school_username)->first();
      return view('app.school.tutoring.tutors')->with(['school' => $school]);
    }

    public function getSignupTutoring($school_username, $tutoring_id)
    {
      $tutee = Tutee::where('user_id', Auth::User()->id)->first();
      if($tutee == '') {
        $tutee = new Tutee();
        $tutee->user_id = Auth::User()->id;
        $tutee->school_id = Auth::User()->school->id;
        $tutee->save();
      }

      $tutoring = Tutoring::find($tutoring_id);

      $matchThese = ['tutee_id' => $tutee->id, 'date' => $tutoring->date, 'tutoring_period_id' => $tutoring->tutoring_period_id];
      $otherTutoring = Tutoring::where($matchThese)->first();

      if($otherTutoring != '') {
        return redirect()->back()->with(['message' => 'You already signed up for another slot in this period!', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $tutoring->tutee_id = $tutee->id;
      $tutoring->update();
      return redirect()->back();
    }

    public function postTutoring($school_username, Request $request)
    {

      $this->validate($request, [
        'date' => 'required',
        'subject' => 'required'
      ]);

      $matchThese = ['tutor_id' => Auth::User()->id, 'date' => $request['date'], 'tutoring_period_id' => $request['tutoringPeriod']];
      $tutoring = Tutoring::where($matchThese)->first();
      if($tutoring != '') {
        return redirect()->back()->with(['message' => 'You already signed up for this slot!', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      $tutoring = new Tutoring();
      $tutoring->tutor_id = Auth::User()->tutor->id;
      $tutoring->tutor_subject_id = $request['subject'];
      $tutoring->date = $request['date'];
      $tutoring->tutoring_period_id = $request['tutoringPeriod'];
      $tutoring->school_id = Auth::User()->school->id;
      $tutoring->save();
      return redirect()->back()->with(['message' => 'You added your tutoring session successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function postTutor(Request $request)
    {
      $tutor = Tutor::where('user_id', $request['tutor'])->first();
      if($tutor != '') {
        return redirect()->back()->with(['message' => 'You already added this user as a tutor', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      $user = User::find($request['tutor']);
      $tutor = new Tutor();
      $tutor->user_id = $request['tutor'];
      $tutor->school_id = $user->school->id;
      $tutor->save();
      return redirect()->back()->with(['message' => 'You added a new tutor successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getDeleteTutor($school_username, $tutor_id)
    {
      $tutor = Tutor::find($tutor_id);
      $tutor->hidden = 1;
      $tutor->update();
      return redirect()->back()->with(['message' => 'Tutor was deleted.', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function postTutorSubject(Request $request)
    {
      $matchThese = ['tutor_id' => $request['tutor'], 'tutoring_subject_id' => $request['tutoringSubject']];
      $tutorSubject = TutorSubject::where($matchThese)->first();
      if($tutorSubject != '') {
        return redirect()->back()->with(['message' => 'This tutor is already offering this subject', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $tutorSubject = new Tutorsubject();
      $tutorSubject->tutor_id = $request['tutor'];
      $tutorSubject->tutoring_subject_id = $request['tutoringSubject'];
      $tutorSubject->save();
      return redirect()->back()->with(['message' => 'Subject was added to tutor successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function tutorNotHere($school_username, $tutoring_id)
    {
        $tutoring = Tutoring::find($tutoring_id);
        if($tutoring->tutor_here) {
          $tutoring->tutor_here = 0;
        } else {
          $tutoring->tutor_here = 1;
        }
        $tutoring->update();
        return redirect()->back();
    }

    public function tuteeNotHere($school_username, $tutoring_id)
    {
        $tutoring = Tutoring::find($tutoring_id);
        if($tutoring->tutee_here) {
          $tutoring->tutee_here = 0;
        } else {
          $tutoring->tutee_here = 1;
        }
        $tutoring->update();
        return redirect()->back();
    }
}
