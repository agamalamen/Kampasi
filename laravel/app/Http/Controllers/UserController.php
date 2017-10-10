<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Input;
use Hash;
use App\User;
use App\Masterpiece;
use App\School;
use App\Hall;
use App\Notification;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function deleteAccount($id)
    {
      $user = User::find($id);
      foreach($user->endorsements as $endorsement) {
        $endorsement->delete();
      }

      foreach($user->offCampusRequests as $request) {
        $request->delete();
      }

      foreach($user->preps as $prep) {
        $prep->delete();
      }

      $user->delete();
      return 'User account was deleted';
    }

    public function postBirthdate(Request $request)
    {
      $this->validate($request, [
        'birthdate' => 'required'
      ]);

      $user = Auth::User();
      $user->birthdate = $request['birthdate'];
      $user->update();
      return redirect()->back()->with(['message' => 'You have successfuly updated your birthdate!', 'status' => 'alert-success', 'dismiss' => True]);
    }

    public function getMembers($filter) {
      $school = Auth::User()->school;
      $halls = $school->halls;

      if ($filter == 'all') {
        $members = $school->users;
      } else {
        foreach($halls as $hall) {
          if($filter == $hall->name) {
            $members = User::where('hall_id', $hall->id)->get();
            break;
          } else {
            return redirect()->route('get.members', ['all']);
          }
        }
      }


      return view('app.school.members')->with(['members' => $members]);
    }

    public function searchMembers()
    {
      // Array with names
      $school = School::find(1);
      $members = $school->users;

      // get the q parameter from URL
      $q = $_GET["q"];

      $hint = "";

      // lookup all hints from array if $q is different from ""
      if ($q !== "") {
      $q = strtolower($q);
      $len=strlen($q);
        foreach($members as $member) {
          if (stristr($q, substr($member->name, 0, $len))) {
              if ($hint === "") {
                  $bio = $member->bio;
                  if(strlen($bio) > 35) {
                    $bio = substr($bio, 0, 35) . '...';
                  }
                  $hint = '
                  <li>
                    <div class="row">
                      <div class="col-xs-2">
                        <img class="img-circle" style="width: 50px; height: 50px;" src="'. route('get.avatar', $member->avatar) .'">
                      </div><!-- .col-md-4 -->
                      <div class="col-xs-8" style="text-align: left;">
                        <a href="'. route('dashboard', $member->username) .'">' . $member->name . '</a>

                        <p>' . $bio . '</p>
                      </div><!-- .col-md-8 -->
                    </div><!-- .row -->
                    <hr>
                  </li>
                  ';
              } else {
                $bio = $member->bio;
                if(strlen($bio) > 35) {
                  $bio = substr($bio, 0, 35) . '...';
                }
                $hint .= '
                <li>
                  <div class="row">
                    <div class="col-xs-2">
                      <img class="img-circle" style="width: 50px; height: 50px;" src="'. route('get.avatar', $member->avatar) .'">
                    </div><!-- .col-md-4 -->
                    <div class="col-xs-8" style="text-align: left;">
                      <a href="'. route('dashboard', $member->username) .'">' . $member->name . '</a>

                      <p>' . $bio . '</p>
                    </div><!-- .col-md-8 -->
                  </div><!-- .row -->
                  <hr>
                </li>
                ';
              }
          }
        }
      }

      // Output "no suggestion" if no hint was found or output correct values
      if($hint == '') {
        $hint = '<p class="text-center" style="font-style: italic; color: grey;">No results were found</p><hr>';
        foreach($school->recentUsers as $member) {
          $bio = $member->bio;
          if(strlen($bio) > 35) {
            $bio = substr($bio, 0, 35) . '...';
          }
          $hint .= '
          <li>
            <div class="row">
              <div class="col-xs-2">
                <img class="img-circle" style="width: 50px; height: 50px;" src="'. route('get.avatar', $member->avatar) .'">
              </div><!-- .col-md-4 -->
              <div class="col-xs-8" style="text-align: left;">
                <a href="'. route('dashboard', $member->username) .'">' . $member->name . '</a>

                <p>' . $bio . '</p>
              </div><!-- .col-md-8 -->
            </div><!-- .row -->
            <hr>
          </li>
          ';
        }
        echo $hint;
      } else {
        echo $hint;
      }
    }



    public function getStaffulty()
    {
      return view('staffulty');
    }

    public function postStaffulty(Request $request)
    {
      if (Auth::User()->role == 'staffulty'){
        return redirect()->back()->with(['message' => 'Your account type is already staffulty.', 'status' => 'alert-info', 'dismiss' => true]);
      } elseif($request['staffulty_code'] == '') {
        return redirect()->back()->with(['message' => 'Please enter the staffulty code.', 'status' => 'alert-danger', 'dismiss' => true]);
      } elseif ($request['staffulty_code'] == '1infiniteLoop') {
        $user = Auth::User();
        $user->role = 'staffulty';
        $user->update();
        $authority = $user->authority;
        $authority->prep_duty = 1;
        $authority->update();
        return redirect()->route('dashboard', [$user->username])->with(['message' => 'Your account type was changed to staffulty successfully!', 'status' => 'alert-success', 'dismiss' => true]);
      } else {
        return redirect()->back()->with(['message' => 'Sorry, the code you entered is wrong.', 'status' => 'alert-danger', 'dismiss' => true]);
      }
    }

    public function getAvatar($avatar_name) {
      $avatar = Storage::disk('local')->get($avatar_name);
      return Response($avatar, 200);
    }

    public function postEditAvatar(Request $request) {

      $this->validate($request, [
        'avatar' => 'required|mimes:jpeg,jpg,png,gif'
      ]);

      $file = $request->file('avatar');
      $user = Auth::User();
      $file_name = 'user-' . $user->id . '.jpg';
      $user->avatar = $file_name;
      $user->update();
      if($file) {
        Storage::disk('local')->put($file_name, File::get($file));
        $message = 'Your avatar was uploaded successfully!';
        $status = 'alert-success';
        return redirect()->back()->with(['message' => $message, 'status' => $status, 'dismiss' => true]);
      }
    }

    public function postEditBio(Request $request)
    {
      $this->validate($request, [
        'bio' => 'required'
      ]);

      $user = Auth::User();
      $user->bio = $request['bio'];
      $user->update();
      return redirect()->back()->with(['message' => 'Your bio was updated successfully', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getLogin()
    {
      return view('account.login');
    }

    public function postLogin(Request $request)
    {
      $this->validate($request, [
            'usernameOrEmail' => 'required',
            'password' => 'required'
        ]);

        $rememberMe = $request['rememberMe'];

      if (Auth::attempt(['email' => $request['usernameOrEmail'], 'password' => $request['password']], $rememberMe)) {
        if (Auth::User()->school_id != 0) {
          return route('dashboard', Auth::User()->school->username);
        } else { return route('home'); }
      }
      else {
        if (Auth::attempt(['username' => $request['usernameOrEmail'], 'password' => $request['password']], $rememberMe)) {
          if (Auth::User()->school_id != 0) {
            return route('dashboard', Auth::User()->school->username);
          } else { return route('home'); }
        } else { return 0; }
      }
    }

    public function getSignup()
    {
      return view('account.signup');
    }

    public function postSignup(Request $request)
    {
      $this->validate($request, [
        'fullName' => 'required|min:3',
        'username' => 'required|min:3|unique:users|unique:schools',
        'email' => 'required|email|unique:users',
        'phone' => 'required|digits:10',
        'password' => 'required|min:6'
      ]);

      

      $user = new User();
      $user->name = $request['fullName'];
      $user->username = $request['username'];
      $user->email = $request['email'];
      $user->phone = $request['phone'];
      $user->school_id = 1;
      $user->password = bcrypt($request['password']);
      $random_avatar = strval(rand(1,12));
      $user->avatar = 'default_' . $random_avatar . '.png';
      $user->save();
      DB::table('authorities')->insert([
            ['user_id' => $user->id]
        ]);
      $notification = new Notification();
      $notification->user_id = $user->id;
      $notification->message = 'Congratulations! You have successfully created your account.';
      $notification->route = route('dashboard', [$user->username]);
      $notification->save();
      Auth::login($user);
      return route('home');
    }

    public function getStaffultySignup()
    {
      return view('account.staffulty-signup');
    }

    public function postStaffultySignup(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|min:3',
        'username' => 'required|min:3|unique:users|unique:schools',
        'email' => 'required|email|unique:users',
        'phone' => 'required|digits:10',
        'password' => 'required|min:6',
        'code'     => 'required'
      ]);

      if($request['code'] != '1infiniteLoop') {
        return redirect()->back()->with(['message' => 'The code you entered is not correct!', 'status' => 'alert-danger', 'dismiss' => 'true']);
      }

      $user = new User();
      $user->name = $request['name'];
      $user->username = $request['username'];
      $user->email = $request['email'];
      $user->phone = $request['phone'];
      $user->school_id = 1;
      $user->password = bcrypt($request['password']);
      $user->role = 'staffulty';
      $user->save();
      DB::table('authorities')->insert([
            ['user_id' => $user->id]
        ]);
      $notification = new Notification();
      $notification->user_id = $user->id;
      $notification->message = 'Congratulations! You have successfully created your account.';
      $notification->route = route('dashboard', [$user->username]);
      $notification->save();
      Auth::login($user);
      return redirect()->route('home');
    }

    public function getCreateUserManually()
    {
      if(Auth::User()->role != 'staffulty') {
        return redirect()->back()->with(['message' => 'Sorry! You do not have access to this page.', 'dismiss' => 'true', 'status' => 'alert-danger']);
      }
      return view('app.school.admin.create-user-manually');
    }

    public function postCreateUserManually(Request $request)
    {

      $this->validate($request, [
        'name' => 'required|min:3',
        'username' => 'required|unique:users|unique:schools',
        'email' => 'required|email|unique:users',
        'role' => 'required',
      ]);

      $password = 'AliensExist' . strval(rand(100, 999)) . '195' . strval(rand(100, 999));

      $user = new User();
      $user->name = $request['name'];
      $user->username = $request['username'];
      $user->email = $request['email'];
      $user->role = $request['role'];
      $user->school_id = Auth::User()->school->id;
      $user->avatar = 'default_' . rand(1, 13) . '.png';
      $user->password = bcrypt($password);
      $user->save();

      DB::table('authorities')->insert([
            ['user_id' => $user->id]
        ]);

      $to = $user->email;
          $from = "ahmed@kampasi.com";
          $subject = "Kampasi - Your account was successfully created!";

          //begin of HTML message
          $message ="
          <html>
          <body>
          <h1></h1>
          <p>
          Hi ". $user->name .", <br>
          Welcome to Kampasi! <br>
          Someone just created an account for you on our platform.
          <br>Your logging credentials:<br>
          <b>Username:</b> ". $user->username ."
          <b>Temporary password: </b> ". $password ." <br>

          You can login from <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.login') ."\">here</a>

          <br>

          Cheers,<b>
          Ahmed
          </p>
          </body>
          </html>";
          //end of message
          $headers  = "From: $from\r\n";
          $headers .= "Content-type: text/html\r\n";

          mail($to, $subject, $message, $headers);
          return redirect()->back()->with(['message' => 'User account created.', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function postGoogleSignup(Request $request)
    {
      $user = DB::table('users')->where('email', $request['email'])->first();
      if ($user) {
        //Signin
        if ($user->source == 'google') {
          $user = User::find($user->id);
          Auth::login($user);
          if ($user->school_id != 0) {
            return route('dashboard', $user->school->username);
          } else {
            return route('home');
          }
        } else {
          return route('get.login');
        }
      } else {
        //Signup
        $user = new User();
        $user->name = $request['fullName'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->avatar = $request['avatar'];
        $user->school_id = 1;
        $user->source = 'google';
        $user->save();
        Auth::login($user);
        return route('home');
      }
    }

    public function logout()
    {
      Auth::logout();
      return redirect()->route('home');
    }

    public function getForgotPassword()
    {
      return view('account.forgot-password');
    }

    public function postForgotPassword(Request $request)
    {
      $this->validate($request, [
        'email' => 'required'
      ]);

      $user = User::where('email', $request['email'])->get()->first();
      if($user == '[]') {
        return redirect()->back()->with(['message'=> 'There is no account with this email', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      $length = 10;
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }

      $user->reset_password_code = $randomString;
      $user->update();
      $to = $user->email;
      $from = "ahmed@kampasi.com";
      $subject = "Kampasi - Reset your password!";
      //begin of HTML message
      $message ="
      <html>
      <body>
      <h1></h1>
      <p>
      Hello ". $user->name .", <br>
      Please copy and paste this code <b>". $randomString ."</b> in the reset password code field. <br>
      <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.reset.password') ."\">Reset password</a>
      </p>
      </body>
      </html>";
      //end of message
      $headers  = "From: $from\r\n";
      $headers .= "Content-type: text/html\r\n";
      mail($to, $subject, $message, $headers);
      
      return redirect()->route('get.reset.password')->with(['message' => 'You will receive an email with your reset password code. It might take a few moments. Please be patient!', 'status' => 'alert-info']);
    }

    public function getResetPassword()
    {
      return view('account.reset-password');
    }

    public function postResetPassword(Request $request)
    {
      $this->validate($request, [
        'code' => 'required|size:10',
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password'
      ]);
      $user = User::where('reset_password_code', $request['code'])->get()->first();
      if($user == '') {
        return redirect()->back()->with(['message' => 'Sorry! this code does not belong to any account']);
      }
      $user->password = bcrypt($request['password']);
      $user->reset_password_code = 0;
      $user->update();
      return redirect()->route('get.login')->with(['message' => 'Please login with your new password', 'status' => 'alert-info', 'dismiss' => true]);
    }

    public function postChangePassword(Request $request)
    {
      if(!Hash::check($request['old_password'], Auth::User()->password)) {
        return redirect()->back()->with(['message' => 'Your old password is not correct!', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $this->validate($request, [
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_new_password' => 'required|same:new_password'
      ]);
      $user = Auth::user();
      $user->password = bcrypt($request['new_password']);
      $user->update();
      $message = 'Your password has been successfully changed.';
      return redirect()->back()->with(['message' => $message, 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function postUpdateEmail(Request $request)
    {
      if(!Hash::check($request['password'], Auth::User()->password)) {
        return redirect()->back()->with(['message' => 'Your password is not correct!', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $this->validate($request, [
          'email' => 'required',
          'phone' => 'required|digits:10',
          'password' => 'required|min:6'
        ]);

      foreach(Auth::User()->school->users as $user) {
        if($request['email'] == $user->email && Auth::User()->id != $user->id) {
          return 'Email has already been taken.';
        }
      }

      $user = Auth::User();
      $user->email = $request['email'];
      $user->phone = $request['phone'];
      $user->update();
      return redirect()->back()->with(['message' => 'Your information was updated successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getOffCampusUsersDuringPrep()
    {
      $requests = Auth::User()->school->offCampusRequests;
      foreach($requests as $request) {
        if($request->driver_approval == 'accepted' && $request->student_life_approval == 'accepted' && $request->security_approval == 'accepted') {
          $departing_date = $request->departure_time;
          $returning_date = $request->arriving_time;
          $current_date = date("Y-m-d 08:00:00");;
          //echo strtotime($current_date);
          if(strtotime($departing_date) < strtotime($current_date) && strtotime($returning_date) > strtotime($current_date)) {
            echo $request->user->name;
            echo '<br>';
            foreach($request->users as $user) {
              $matchThese = ['user_id' => $user->id, 'off_campus_request_id' => $request->id];
              $present = DB::table('off_campus_request_user')->where($matchThese)->first();
              if($present) {
                echo $user->name;
              }
            }
          }
        }
      }
    }
}
