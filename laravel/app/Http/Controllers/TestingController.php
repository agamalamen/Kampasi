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
      $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

      $code = ['y', 'l', 'i', 'k', 'g'];

      $i = 0;
      while ($i < count($code)) {
        $x = 0;
        while($x < count($alphabet)) {
          $code[] = 
          $x++;
        }
        $i++;
      }









    }


    public function fakeLogin()
    {
      if (Auth::attempt(['email' => 'afarag16@alastudents.org', 'password' => 'Youyugi195'])) 
      {
          return redirect()->route('dashboard', Auth::User()->school->username);
      } else {
        return 'wrong something';
      }
    }
}


      /*for ($letter in $alphabet) {
        echo $letter;
        echo "<br>";
      }*/

      /*$school = Auth::User()->school;
      foreach($school->users as $user) {
        if(strpos($user->email, '15')) {
          $user->role = 'alumni';
          $user->update();
        }
      }*/
      //return 'hello world!';
      /*$x = 1;
      foreach(Auth::User()->school->users as $user) {
        if($user->avatar == 'default.jpg') {
          $user->avatar = 'default_' . strval($x) . '.png';
          $user->update();
          $x += 1;
        }
        if($x == 13) {
          $x = 1;
        }
      }*/