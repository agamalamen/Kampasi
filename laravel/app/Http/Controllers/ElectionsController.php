<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\School;
use App\Candidate;
use App\Election;
use App\Vote;
use App\User;
use App\ElectionsComment;
use Illuminate\Support\Facades\Auth;


class ElectionsController extends Controller
{
    /*public function getElections()
    {
      $school = School::find(1);
      $ITreps = $school->elections;
      return view('elections.elections')->with(['ITreps' => $ITreps]);
    }*/

    public function postElectionsComment(Request $request, $feedback_id)
    {
      $this->validate($request, [
        'content' => 'required'
      ]);

      $comment = new ElectionsComment();
      $comment->content = $request['content'];
      $comment->user_id = Auth::User()->id;
      $comment->school_id = Auth::User()->school->id;
      $comment->save();
      return redirect()->back();
    }


    public function getElections($date) {
      return view('app.school.elections.elections');
    }

    public function postRun(Request $request, $date) {
      $candidate = Candidate::where('user_id', Auth::User()->id)->first();
      if($candidate != []) {
        return redirect()->back()->with(['message' => 'You are already running for ' . $candidate->position->name, 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $candidate = new Candidate();
      $candidate->user_id = Auth::user()->id;
      $candidate->position_id = $request['position'];
      $candidate->save();
      return redirect()->route('get.candidate', ['2017', Auth::User()->username])->with(['message' => 'You are now running for ' . $candidate->position->name, 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function postVote(Request $request) {
      if(Auth::User()->role != 'student') {
        return redirect()->back()->with(['message' => 'Sorry only students are allowed to vote.', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $date = date('m/d/Y h:i:s a', time());
      $startDate = "04/09/2017 09:00:00 am";
      $endDate = "04/09/2017 01:30:00 pm";

      if(strtotime($date) < strtotime($startDate)) {
        return redirect()->back()->with(['message' => 'Voting did not start yet! Come back on 9th April at 9 AM', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      if(strtotime($date) > strtotime($endDate)) {
        return redirect()->back()->with(['message' => 'Voting is over!', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      if(Auth::User()->voted) {
        return redirect()->back()->with(['message' => 'You already voted before!', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      $inputs = $request->all();
      $x = count($inputs);
      $i = 1;
      while($x > $i) {

        $vote = new Vote();
        $vote->user_id = Auth::User()->id;
        $vote->candidate_id = $inputs[$i];
        $vote->save();
        if($inputs[$i] != 0) {
          $candidate = Candidate::find($inputs[$i]);
          $candidate->votes = $candidate->votes + 1;
          $candidate->update();
        }
        $i += 1;
      }

      $user = Auth::User();
      $user->voted = 1;
      $user->update();
      return redirect()->back()->with(['message' => 'Thanks for voting!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getCandidate($date, $candidate_username) {
      /*foreach(Auth::User()->school->users as $user) {
        if ($user->voted) {
          echo $user->name;
          echo '<br>';
        }
      }*/
      $user = User::where('username', $candidate_username)->first();
      $candidate = Candidate::where('user_id', $user->id)->first();
      return view('app.school.elections.candidate')->with(['candidate' => $candidate]);
    }

    public function postCandidateDescription($date, Request $request) {
      $candidate = Auth::User()->candidate;
      $candidate->description = $request['description'];
      $candidate->update();
      return redirect()->back()->with(['message' => 'Your description was updated successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    /*public function getElection($username, $election_username)
    {

      $election = Election::where('username', $election_username)->first();
      $election->views = $election->views +1;
      $election->update();

      //Proccessing goals
      $separatedGoals = array();
      $goals = $election->goals;
      $startPoint = 0;
      while (strpos($goals, ',') !== false) {
        $breakPoint = strcspn($goals,",");
        array_push($separatedGoals, substr($goals, $startPoint, $breakPoint));
        $goals = substr($goals, $breakPoint+2);
      }
      array_push($separatedGoals, $goals);

      //Proccessing strengths
      $separatedStrengths = array();
      $strengths = $election->strengths;
      $startPoint = 0;
      while (strpos($strengths, ',') !== false) {
        $breakPoint = strcspn($strengths,",");
        array_push($separatedStrengths, substr($strengths, $startPoint, $breakPoint));
        $strengths = substr($strengths, $breakPoint+2);
      }
      array_push($separatedStrengths, $strengths);

      //Proccessing plans
      $separatedPlans = array();
      $plans = $election->plans;
      $startPoint = 0;
      while (strpos($plans, ',') !== false) {
        $breakPoint = strcspn($plans,",");
        array_push($separatedPlans, substr($plans, $startPoint, $breakPoint));
        $plans = substr($plans, $breakPoint+2);
      }
      array_push($separatedPlans, $plans);

      //Proccessing plans
      $separatedBackgrounds = array();
      $backgrounds = $election->background;
      $startPoint = 0;
      while (strpos($backgrounds, ',') !== false) {
        $breakPoint = strcspn($backgrounds,",");
        array_push($separatedBackgrounds, substr($backgrounds, $startPoint, $breakPoint));
        $backgrounds = substr($backgrounds, $breakPoint+2);
      }
      array_push($separatedBackgrounds, $backgrounds);


      return view('elections.election')->with(['election' => $election, 'separatedGoals'=> $separatedGoals, 'separatedStrengths'=> $separatedStrengths, 'separatedPlans' => $separatedPlans, 'separatedBackgrounds' => $separatedBackgrounds]);
    }*/

    public function getVote() {
      return 'hello';
    }
}
