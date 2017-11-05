<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prep;
use DB;
use App\User;
use App\prepPlace;
use App\NightWatcher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class PrepController extends Controller
{

  /*public function getPrepReport($date)
  {
    $preps = Auth::User()->school->dated_preps($date);
    return view('app.school.prep.report')->with(['preps' => $preps, 'date' => $date]);
  }*/

  public function getPrepReports($date) 
  {
    $preps = Prep::all()->where('date', $date);
    return view('app.school.prep.report')->with(['preps' => $preps]);
  }

  public function getRedirectPrepDate(Request $request)
  {
    return redirect()->route('get.prep.reports', $request['date']);
  }

  public function postMassPrep()
  {
    $prepStarts ="19:05:00";
    $prepEnds = "21:00:00";
    if(Date('D') != 'Fri' || Date('D') != 'Sat' || time() < strtotime($prepEnds)) {
      foreach(Auth::User()->school->students as $student) {
        $prep = Prep::where(['user_id' => $student->id, 'date' => date('Y-m-d')])->get();
        if($prep == '[]') {
          if($student->prep_place_id != 0) {
            $prep = new Prep();
            $prep->user_id = $student->id;
            $prep->date = date('Y-m-d');
            $prep->place =  $student->prep_place_id;
            $prep->save();
          }
        }
      }
    }
  }

  public function getPrepHistoryBla()
  {
    foreach(Auth::User()->school->preps as $prep) {
      echo $prep->prepPlace;
    }
  }

  public function getPrep($place)
  {
    /*if(Date('D') != 'Fri' || Date('D') != 'Sat') {
      $this->postMassPrep();
    }*/
    if($place == 'all') {
      $todayPreps = Auth::User()->school->todayPreps;
    } elseif ($place == 'Dorms') {
      $todayPreps = Auth::User()->school->todayDormsPreps;
    } elseif ($place == 'Classrooms') {
      $todayPreps = Auth::User()->school->todayClassroomsPreps;
    } elseif($place == 'Dinning-hall') {
      $todayPreps = Auth::User()->school->todayDinningHallPreps;
    } elseif ($place == 'MST') {
      $todayPreps = Auth::User()->school->todayMSTPreps;
    } elseif($place == 'history') {
      $todayPreps = Auth::User()->school->preps;
    }
    else {
      $todayPreps = Auth::User()->school->todayPreps;
    }

    return view('app.school.prep.prep')->with(['todayPreps' => $todayPreps, 'place' => $place]);
  }

  public function postPrep(Request $request)
    {
      /*$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
      $yql_query = 'select item.condition from weather.forecast where woeid in (select woeid from geo.places(1586976) where text="johannesburg, sa")';
      $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
      // Make call with cURL
      $session = curl_init($yql_query_url);
      curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
      $json = curl_exec($session);
      // Convert JSON to PHP object
      $phpObj =  json_decode($json);
      var_dump($phpObj);*/


      if(Date('D') == 'Fri' || Date('D') == 'Sat') {
        return redirect()->back()->with(['message' => 'There is no prep today. Go get a life!', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $prepStarts ="19:05:00";
      $prepEnds = "21:00:00";
      if (time() > strtotime($prepEnds)) {
        return redirect()->back()->with(['message' => 'Sorry signing for prep is over!', 'status' => 'alert-info', 'dismiss' =>true]);
      }

      $matchThese = ['user_id' => Auth::User()->id, 'date' => date('Y-m-d')];
      $prepSignup = Prep::where($matchThese)->first();
      if($prepSignup == '')
      {
        $prepSignup = new Prep();
        $prepSignup->user_id = Auth::User()->id;
        $prepSignup->date = date('Y-m-d');
        $prepSignup->place = $request['place'];
        if (time() > strtotime($prepStarts))
        {
          $prepSignup->late = 1;
        }
        $prepSignup->save();
      }
      $prepSignup->place = $request['place'];
      $prepSignup->late = 0;
      $prepSignup->update();
      if(!$prepSignup->late) {
        return redirect()->back();
      } else {
        return redirect()->back()->with(['message' => 'You signed up for prep late today!', 'status' => 'alert-warning', 'dismiss' => true]);
      }
    }

  public function postNightWatchers(Request $request)
  {
    $matchThese = ['user_id' => $request['duty_id'], 'date' => date('Y-m-d')];
    $nightWatcher = NightWatcher::where($matchThese)->first();
    if (empty($nightWatcher)) {
      $nightWatcher = new NightWatcher();
      $nightWatcher->user_id = $request['duty_id'];
      $nightWatcher->date = date('Y-m-d');
      $nightWatcher->place = $request['place'];
      $nightWatcher->save();
      return redirect()->back();
    } else {
      return redirect()->back()->with(['message' => 'This user was already added!', 'status' => 'alert-info', 'dismiss' => true]);
    }
  }

  public function prepNotHereUndo($user_id) {
    $matchThese = ['user_id' => $user_id, 'date' => date('Y-m-d')];
    $prep = Prep::where($matchThese)->first();
    $prep->here = 1;
    $prep->update();
    return redirect()->back();
  }

  public function prepNotHere($user_id)
  {
    $matchThese = ['user_id' => $user_id, 'date' => date('Y-m-d')];
    $prep = Prep::where($matchThese)->first();
    $prep->here = 0;
    $prep->update();
    return redirect()->back();
  }

  public function getPrepHistory()
  {
    if(Auth::User()->role == 'student')
    {
      return redirect()->back()->with(['message' => 'Sorry you don\'t have access to this page', 'alert' => 'alert-info', 'dismiss' => true]);
    }
    else {
      return view('app.school.prep.prep-history');
    }
  }

  public function updatePrepPlace()
  {
    $place = $_GET["place"];
    $user = Auth::User();
    $user->prep_place_id = $place;
    $user->update();
  }

}
