<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Election;
use Illuminate\Support\Facades\Auth;

use Crypt;
class TestingController extends Controller
{
    public function testingUrl()
    {
      $x = 1;
      foreach(Auth::User()->school->users as $user) {
        if($user->avatar == 'default.jpg') {
          $user->avatar = 'default_' . strval($x) . '.png';
          $user->update();
          $x += 1;
        }
        if($x == 13) {
          $x = 1;
        }
      }
    }
}
