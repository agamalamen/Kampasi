<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App;
use App\User;
use App\OffCampusRequest;
use App\PrepPlace;
use App\School;
use App\Http\Requests;

class DashboardController extends Controller
{
    public function getWelcome()
    {
      if(Auth::User()) {
        return redirect()->route('dashboard', ['ala'])->with(['background_cover' => 'hello']);
      } else {
        return view('welcome');
      }
    }

    public function getDashboard($username) {
      $user = User::where('username', $username)->first();
      $school = School::where('username', $username)->first();
      if (empty($user)) {
        if (empty($school)) {
          return view('errors.503');
        }
        else {
          if (Auth::User()->school == $school) {
            if(Auth::User()->role == 'staffulty') {
              $latest_request = DB::table('off_campus_requests')->where('chaperon_id', Auth::User()->id)->orderBy('id', 'DESC')->first();
              if($latest_request) {
                $requested_by = User::find($latest_request->user_id);
              } else {
                $requested_by = 0;
                }
              } elseif(Auth::User()->role == 'student') {
              $latest_request = DB::table('off_campus_requests')->where('user_id', Auth::User()->id)->orderBy('id', 'DESC')->first();
              if($latest_request) {
                $requested_by = User::find($latest_request->user_id);
              } else {
                $requested_by = 0;
              }
            } else {
              $latest_request = DB::table('off_campus_requests')->orderBy('id', 'DESC')->first();
              if($latest_request) {
                $requested_by = User::find($latest_request->user_id);
              } else {
                $requested_by = 0;
              }
            }

            return view('app.school.school-dashboard')->with(['school' => $school, 'request' => $latest_request, 'requested_by' => $requested_by, 'background_cover' => 'hello']);
          } else {
            return redirect()->route('home');
          }
        }
      }
      else {
        return view('app.user.user-dashboard')->with(['user' => $user]);
      }
    }

    public function getAbout()
    {
      return view('about-us');
    }
}
