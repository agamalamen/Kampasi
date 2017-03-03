<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class MentorController extends Controller
{
    public function getMentors()
    {
      foreach(Auth::User()->school->scholars as $scholar) {
        echo $scholar->user->name;
      }
    }
}
