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
      $data = [];
      Mail::send('mails.test', $data, function($message) {
        $message->from('agamalamen@gmail.com', 'Laravel');
        $message->to('afarag16@alastudents.org');
      });
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