<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Endorsement;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Election;
class EndorsementController extends Controller
{
    public function endorse($username, $election_id)
    {
      if($election_id == 0) {
        return redirect()->route('get.login')->with(['message' => 'Sorry! You need to login first in order to endorse', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $matchThese = ['election_id' => $election_id, 'user_id' => Auth::User()->id];
      $endorsement = Endorsement::where($matchThese)->first();
      if($endorsement == '') {
        $endorsement = New Endorsement();
        $endorsement->user_id = Auth::User()->id;
        $endorsement->election_id = $election_id;
        $endorsement->save();
        return redirect()->back();
      }
      $endorsement->delete();
      return redirect()->back();
    }
}
