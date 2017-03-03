<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dscEndorsement;
use App\dsc;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;


class dscEndorsementController extends Controller
{
    public function getEndorse($dsc_id)
    {
      if(!Auth::User()) {
        return redirect()->route('get.login')->with(['message' => 'Sorry! you need to be logged in first!', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $dsc = DSC::find($dsc_id);
      $matchThese = ['dsc_id' => $dsc_id, 'user_id' => Auth::User()->id];
      $endorsement = dscEndorsement::where($matchThese)->first();
      if($endorsement == '') {
        $endorsement = New dscEndorsement();
        $endorsement->user_id = Auth::User()->id;
        $endorsement->dsc_id = $dsc_id;
        $endorsement->save();
        $dsc->endorsements_count = $dsc->endorsements->count();
        $dsc->update();
        return redirect()->back();
      }
      $endorsement->delete();
      $dsc->endorsements_count = $dsc->endorsements->count();
      $dsc->update();
      return redirect()->back();
    }
}
