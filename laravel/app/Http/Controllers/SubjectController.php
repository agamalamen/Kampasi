<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class SubjectController extends Controller
{
    public function getSubjects()
    {
      foreach(Auth::User()->school->subjects as $subject) {
        foreach($subject->scholars as $scholar) {
          echo $scholar->user->name;
        }
      }
    }
}
