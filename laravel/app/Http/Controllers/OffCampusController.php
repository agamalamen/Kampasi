<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OffCampusRequest;
use App\User;
use App\ExternalChaperone;
use App\Notification;
use App\AvailableChaperone;
use App\Absence;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class OffCampusController extends Controller
{

    public function postAvailableChaperones() {
      $matchThese = ['user_id' => Auth::User()->id, 'date' => date("Y-m-d")];
      $availableChaperone = AvailableChaperone::where($matchThese)->first();
      if($availableChaperone != []) {
        return redirect()->back()->with(['message' => 'You already added yourself as available chaperone for today.', 'status'=> 'alert-danger', 'dismiss' => true]);
      }
      $availableChaperone = new AvailableChaperone();
      $availableChaperone->user_id = Auth::User()->id;
      $availableChaperone->date = date("Y-m-d");
      $availableChaperone->save();
      return redirect()->back()->with(['message' => 'You were added to the list of available chaperones for today', 'status'=> 'alert-success', 'dismiss' => true]);
    }

    public function getExternalChaperones()
    {
      return view('app.school.off-campus.external-chaperones');
    }

    public function postExternalChaperone(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:external_chaperones',
        'phone' => 'required|digits:10'
      ]);

      $chaperone = new ExternalChaperone();
      $chaperone->user_id = Auth::User()->id;
      $chaperone->name = $request['name'];
      $chaperone->phone = $request['phone'];
      $chaperone->email = $request['email'];
      $chaperone->save();

      foreach(Auth::User()->school->users as $user) {
        if($user->role == 'student_life') {
          $notification = new Notification();
          $notification->user_id = $user->id;
          $notification->message = 'New external chaperone waiting for your approval';
          $notification->route = route('get.external.chaperones');
          $notification->save();
          $to = $user->email;
          $from = "ahmed@kampasi.com";
          $subject = "Kampasi - New external chaperone request!";

          //begin of HTML message
          $message ="
          <html>
          <body>
          <h1></h1>
          <p>
          Hello ". $user->name .", <br>
          A new external chaperone request was created and waiting for your approval. <br>
          <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.external.chaperones') ."\">View the request</a>
          </p>
          </body>
          </html>";
          //end of message
          $headers  = "From: $from\r\n";
          $headers .= "Content-type: text/html\r\n";

          mail($to, $subject, $message, $headers);
        }
      }

      return redirect()->back()->with(['message' => 'Your external chaperone was submitted successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getApproveExternalChaperone($chaperone_id)
    {
      if(Auth::User()->role != 'student_life') {
        return redirect()->back();
      }
      $chaperone = ExternalChaperone::find($chaperone_id);
      $chaperone->approved = 1;
      $chaperone->update();

      $notification = new Notification();
      $notification->user_id = $chaperone->user->id;
      $notification->message = 'Your external chaperone request was approved.p';
      $notification->route = route('get.external.chaperones');
      $notification->save();
      $to = $chaperone->user->email;
      $from = "ahmed@kampasi.com";
      $subject = "Kampasi - Your external chaperone request was accepted!";

      //begin of HTML message
      $message ="
      <html>
      <body>
      <h1></h1>
      <p>
      Hello ". $chaperone->user->name .", <br>
      You new external chaperone was approved and added to your approved chaperones list.<br>
      <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.external.chaperones') ."\">View the list</a>
      </p>
      </body>
      </html>";
      //end of message
      $headers  = "From: $from\r\n";
      $headers .= "Content-type: text/html\r\n";

      mail($to, $subject, $message, $headers);


      return redirect()->back()->with(['mesasage' => 'Chaperone was approved successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getOffCampus($status) {
      $students = Auth::User()->school->students;
      if ($status == 'all') {
        //$requests = Auth::User()->school->offCampusRequests->paginate(10);
        $requests = OffCampusRequest::where('user_id', Auth::User()->id)->paginate(2);
      } elseif($status == 'arrived') {
        $requests = Auth::User()->school->offCampusArrivedRequests;
      } elseif ($status == 'departed') {
        $requests = Auth::User()->school->offCampusDepartedRequests;
      } elseif ($status == 'accepted') {
        $requests = Auth::User()->school->offCampusAcceptedRequests;
      } elseif ($status == 'departing_today') {
          $departingToday = [];
          foreach (Auth::User()->school->offCampusAcceptedRequests as $request) {
            $departureTime = $request->departure_time;
            $departureTimeTimestamp = strtotime($departureTime);
            $departureTime = date('Y-m-d', $departureTimeTimestamp);
            if($departureTime == date('Y-m-d')) {
              array_push($departingToday, $request);
            }
          }
          $requests = $departingToday;
        } elseif ($status == 'returning_today'){
          $returningToday = [];
          foreach (Auth::User()->school->offCampusDepartedRequests as $request) {
            $returnTime = $request->arriving_time;
            $returnTimeTimestamp = strtotime($returnTime);
            $returnTime = date('Y-m-d', $returnTimeTimestamp);
            if($returnTime == date('Y-m-d')) {
              array_push($returningToday, $request);
            }
          }
          $requests = $returningToday;
        } elseif ($status == 'created_today') {
          $createdToday = [];
          foreach (Auth::User()->school->offCampusRequests as $request) {
            $createdTime = $request->created_at;
            $createdTimeTimestamp = strtotime($createdTime);
            $createdTime = date('Y-m-d', $createdTimeTimestamp);
            if($createdTime == date('Y-m-d')) {
              array_push($createdToday, $request);
            }
          }
          $requests = $createdToday;
        } else {
          $requests = Auth::User()->school->offCampusRequests;
        }

        return view('app.school.off-campus.off-campus')->with(['students' => $students, 'requests' => $requests]);
    }

    public function postOffCampusRequest(Request $request)
    {

      $this->validate($request, [
            'place'         => 'required',
            'address'       => 'required',
            'departureTime' => 'required',
            'arrivingTime'  => 'required|after:departureTime',
            'chaperoneRadio'=> 'required',
            'absenceRadio'  => 'required'
      ]);

      $departure_day = date("D", strtotime($request['departureTime']));
      //return $departure_day . date('D');
      
      /*if(date("D") == 'Fri' || date("D") == 'Sat' || date("D") == 'Sun') {
        if($departure_day == 'Fri' || $departure_day == 'Sat' || $departure_day == 'Sun') {
          return redirect()->back()->with(['message' => 'Sorry you cannot submit a request at this time', 'status' => 'alert-danger', 'dismiss' => true]);
        }
      }*/

      $offCampusRequest = new OffCampusRequest();

      if($request['chaperoneRadio'] == 'internal') {
        if($request['internalChaperone'] == 0) {
          return redirect()->back()->with(['message' => 'Sorry you need to choose an internal chaperone', 'status' => 'alert-danger', 'dismiss' => true]);
        }
        $offCampusRequest->chaperon_id = $request['internalChaperone'];
        $offCampusRequest->chaperone_type = 'internal';
      } elseif ($request['chaperoneRadio'] == 'external') {
        if($request['externalChaperone'] == 0) {
          return redirect()->back()->with(['message' => 'Sorry you need to choose an external chaperone', 'status' => 'alert-danger', 'dismiss' => true]);
        }
        $offCampusRequest->chaperon_id = $request['externalChaperone'];
        $offCampusRequest->chaperone_type = 'external';
      }

      $offCampusRequest->user_id = Auth::User()->id;
      $offCampusRequest->school_id = Auth::User()->school->id;
      $offCampusRequest->place = $request['place'];
      $offCampusRequest->address = $request['address'];
      $offCampusRequest->departure_time = $request['departureTime'];
      $offCampusRequest->arriving_time = $request['arrivingTime'];
      $offCampusRequest->status = 'hold';
      $offCampusRequest->save();

      if($request['absenceRadio'] == 'yes') {
        
        $i = 1;
        while ($i < 9) {
            if($request['teacher' . (string)$i] != 0) {
              $absence = new Absence();
              $absence->user_id = $request['teacher' . (string)$i];
              $absence->off_campus_request_id = $offCampusRequest->id;
              $absence->approval = 'hold';
              $absence->save();

              $notification = new Notification();
              $notification->user_id = $absence->user->id;
              $notification->message = 'New off-campus request waiting for your approval';
              $notification->route = route('get.off.campus.request', $absence->offCampusRequest->id);
              $notification->save();

              $to = $absence->user->email;
              $from = "no-reply@kampasi.com";
              $subject = "Kampasi - New off-campus request!";

              //begin of HTML message
              $message ="
              <html>
              <body>
              <h1></h1>
              <p>
              Hello ". $absence->user->name .", <br>
              A new off-campus request was created and waiting for your approval. <br>
              <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $absence->offCampusRequest->id) ."\">View the request</a>
              </p>
              </body>
              </html>";
              //end of message
              $headers  = "From: $from\r\n";
              $headers .= "Content-type: text/html\r\n";

              mail($to, $subject, $message, $headers);

          }
          $i++;
        }
      } else {
        $x = 0;
        $student_count = User::all()->where('role', 'student')->count();
        while ($x < $student_count) {
          if(isset($request[$x])) {
            DB::table('off_campus_request_user')->insert([
                  ['off_campus_request_id' => $offCampusRequest->id, 'user_id' => $request[$x]]
              ]);
          }
          $x++;
        }
      }

      if($offCampusRequest->chaperone_type == 'internal') {
        $user = User::find($offCampusRequest->chaperon_id);

        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->message = 'New off-campus request waiting for your approval';
        $notification->route = route('get.off.campus.request', $offCampusRequest->id);
        $notification->save();
        $to = $user->email;
        $from = "ahmed@kampasi.com";
        $subject = "Kampasi - New off-campus request!";

        //begin of HTML message
        $message ="
        <html>
        <body>
        <h1></h1>
        <p>
        Hello ". $user->name .", <br>
        A new off-campus request was created and waiting for your approval. <br>
        <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $offCampusRequest->id) ."\">View the request</a>
        </p>
        </body>
        </html>";
        //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);
      } else {
        foreach(Auth::User()->school->users as $user) {
          if($user->role == 'student_life') {
            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->message = 'New off-campus request waiting for your approval';
            $notification->route = route('get.off.campus.request', $offCampusRequest->id);
            $notification->save();
            $to = $user->email;
            $from = "ahmed@kampasi.com";
            $subject = "Kampasi - New off-campus request!";

            //begin of HTML message
            $message ="
            <html>
            <body>
            <h1></h1>
            <p>
            Hello ". $user->name .", <br>
            A new off-campus request was created and waiting for your approval. <br>
            <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $offCampusRequest->id) ."\">View the request</a>
            </p>
            </body>
            </html>";
            //end of message
            $headers  = "From: $from\r\n";
            $headers .= "Content-type: text/html\r\n";

            mail($to, $subject, $message, $headers);
          }
        }
      }

      return redirect()->route('get.off.campus.request', $offCampusRequest->id);
    }

    public function getOffCampusRequest($request_id)
    {
      $request = OffCampusRequest::find($request_id);
      
      if(Auth::User()->id != $request->user->id && Auth::User()->role == 'student') {
        return redirect()->back()->with(['message' => 'Sorry you do not have access to this page.', 'status' => 'alert-info', 'dismiss' => 'true']);
      }
      if($request->chaperone_type == 'internal') {
        $chaperon = User::find($request->chaperon_id);
        $chaperoneType = 'internal';
      } else if ($request->chaperone_type == 'external') {
        $chaperon = ExternalChaperone::find($request->chaperon_id);
        $chaperoneType = 'external';
      } else {
        $chaperon = User::find($request->chaperon_id);
        $chaperoneType = 'internal';
      }
      $request_users = DB::table('off_campus_request_user')->where('off_campus_request_id', $request_id)->get();
      return view('app.school.off-campus.off-campus-request')->with(['request' => $request, 'chaperon' => $chaperon, 'chaperoneType' => $chaperoneType,'request_users' => $request_users]);
    }

    public function getDriverAcceptRequest($request_id, $chaperon)
    {
      $request = OffCampusRequest::find($request_id);
      /*if($request->chaperon_id != Auth::User()->id && $request->chaperone_type == 'internal' || Auth::User()->role != 'student_life') {
        return redirect()->back()->with(['message' => 'Sorry you are not authorized to access this page.', 'status' => 'alert-info', 'dismiss' => true]);
      }*/
      $request->driver_approval = 'accepted';
      $request->update();
      $notification = new Notification();
      $notification->user_id  = $request->user->id;
      $notification->message  = 'Your off-campus request was accepted by the chaperon';
      $notification->route    = route('get.off.campus.request', $request->id);
      $notification->save();
      $to = $request->user->email;
      $from = "ahmed@kampasi.com";
      $subject = "Kampasi - Your off-campus request was accepted by the chaperon!";
      //begin of HTML message
      $message ="
      <html>
      <body>
      <h1></h1>
      <p>
      Hello ". $request->user->name .", <br>
      Your off-campus request was approved by the chaperon. <br>
      <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
      </p>
      </body>
      </html>";
      //end of message
      $headers  = "From: $from\r\n";
      $headers .= "Content-type: text/html\r\n";

      //options to send to cc+bcc
      //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
      //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

      // now lets send the email.
      mail($to, $subject, $message, $headers);

      $users = User::all();
      foreach ($users as $user) {
        if ($user->role == 'student_life') {
          $notification           = new Notification();
          $notification->user_id  = $user->id;
          $notification->message  = 'New off-campus request waiting for your approval';
          $notification->route    = route('get.off.campus.request', $request->id);
          $notification->save();
          $to = $user->email;
          $from = "ahmed@kampasi.com";
          $subject = "Kampasi - New off-campus request waiting for your approval!";
          //begin of HTML message
          $message ="
          <html>
          <body>
          <h1></h1>
          <p>
          Hello ". $user->name .", <br>
          New off-campus request waiting for your approval. <br>
          <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
          </p>
          </body>
          </html>";
          //end of message
          $headers  = "From: $from\r\n";
          $headers .= "Content-type: text/html\r\n";

          mail($to, $subject, $message, $headers);
        }
      }
      return redirect()->back();
    }

    public function getDriverDeclineRequest($request_id, $chaperon)
    {
      $request = OffCampusRequest::find($request_id);
      if($request->chaperon_id != Auth::User()->id && $request->chaperone_type == 'internal' || Auth::User()->role != 'student_life') {
        return redirect()->back()->with(['message' => 'Sorry you are not authorized.', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $request->driver_approval = 'declined';
      $request->update();

      $notification = new Notification();
      $notification->user_id  = $request->user->id;
      $notification->message  = 'Your off-campus request was declined by the chaperon';
      $notification->route    = route('get.off.campus.request', $request->id);
      $notification->save();
      $to = $request->user->email;
      $from = "ahmed@kampasi.com";
      $subject = "Kampasi - Your off-campus request was declined by the chaperon!";
      //begin of HTML message
      $message ="
      <html>
      <body>
      <h1></h1>
      <p>
      Hello ". $request->user->name .", <br>
      Your off-campus request was declined by the chaperon. <br>
      <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
      </p>
      </body>
      </html>";
      //end of message
      $headers  = "From: $from\r\n";
      $headers .= "Content-type: text/html\r\n";

      //options to send to cc+bcc
      //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
      //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

      // now lets send the email.
      mail($to, $subject, $message, $headers);
      return redirect()->back();
    }

    public function getTeacherResponse($absence_id, $response)
    {
      $absence = Absence::find($absence_id);

      $absence->approval = $response;
      $absence->update();

      $to = $asbence->offCampusRequest->user->email;
      $from = "no-reply@kampasi.com";
      $subject = "Kampasi - Your off-campus request was ". $response ." by " . $absence->user->name;
      //begin of HTML message
      $message ="
      <html>
      <body>
      <h1></h1>
      <p>
      Hello ". $absence->offCampusRequest->user->name .", <br>
      Your off-campus request was ". $response ." by ". $absence->user->name .". <br>
      <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $absence->offCampusRequest->id) ."\">View the request</a>
      </p>
      </body>
      </html>";
      //end of message
      $headers  = "From: $from\r\n";
      $headers .= "Content-type: text/html\r\n";

      return redirect()->back();

    }

    public function getStudentLifeResponse($request_id, $response)
    {
      if(Auth::User()->role != 'student_life') {
        return redirect()->back()->with(['message' => 'Sorry you do not have access to this page', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $request = OffCampusRequest::find($request_id);
      if ($response) {
        $request->student_life_approval = 'accepted';
        $notification = new Notification();
        $notification->user_id  = $request->user->id;
        $notification->message  = 'Your off-campus request was accepted by the student life';
        $notification->route    = route('get.off.campus.request', $request->id);
        $notification->save();
        $to = $request->user->email;
        $from = "ahmed@kampasi.com";
        $subject = "Kampasi - Your off-campus request was accepted by the student life!";
        //begin of HTML message
        $message ="
        <html>
        <body>
        <h1></h1>
        <p>
        Hello ". $request->user->name .", <br>
        Your off-campus request was accepted by the student life. <br>
        <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
        </p>
        </body>
        </html>";
        //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";

        //options to send to cc+bcc
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

        // now lets send the email.
        mail($to, $subject, $message, $headers);
        foreach (Auth::User()->school->users as $user) {
          if ($user->role == 'security') {
            $notification           = new Notification();
            $notification->user_id  = $user->id;
            $notification->message  = 'New off-campus request waiting for your approval';
            $notification->route    = route('get.off.campus.request', $request->id);
            $notification->save();
            $to = $user->email;
            $from = "ahmed@kampasi.com";
            $subject = "Kampasi - New off-campus request waiting for your approval!";
            //begin of HTML message
            $message ="
            <html>
            <body>
            <h1></h1>
            <p>
            Hello ". $user->name .", <br>
            New off-campus request waiting for your approval. <br>
            <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
            </p>
            </body>
            </html>";
            //end of message
            $headers  = "From: $from\r\n";
            $headers .= "Content-type: text/html\r\n";

            mail($to, $subject, $message, $headers);
          }
        }
      } else {
        $request->student_life_approval = 'declined';
        $notification = new Notification();
        $notification->user_id  = $request->user->id;
        $notification->message  = 'Your off-campus request was declined by the student life';
        $notification->route    = route('get.off.campus.request', $request->id);
        $notification->save();
        $to = $request->user->email;
        $from = "ahmed@kampasi.com";
        $subject = "Kampasi - Your off-campus request was declined by the student life!";
        //begin of HTML message
        $message ="
        <html>
        <body>
        <h1></h1>
        <p>
        Hello ". $request->user->name .", <br>
        Your off-campus request was declined by the student life. <br>
        <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
        </p>
        </body>
        </html>";
        //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";

        //options to send to cc+bcc
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

        // now lets send the email.
        mail($to, $subject, $message, $headers);
      }
      $request->update();
      return redirect()->back();
    }

    public function getSecurityResponse($request_id, $response)
    {
      if(Auth::User()->role != 'security') {
        return redirect()->back()->with(['message' => 'sorry you do not have access to this page', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $request = OffCampusRequest::find($request_id);
      if($response) {
        $request->security_approval = 'accepted';
        $notification = new Notification();
        $notification->user_id  = $request->user->id;
        $notification->message  = 'Your off-campus request was accepted by the security';
        $notification->route    = route('get.off.campus.request', $request->id);
        $notification->save();
        $to = $request->user->email;
        $from = "ahmed@kampasi.com";
        $subject = "Kampasi - Your off-campus request was accepted by the security!";
        //begin of HTML message
        $message ="
        <html>
        <body>
        <h1></h1>
        <p>
        Hello ". $request->user->name .", <br>
        Your off-campus request was accepted by the security. <br>
        <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
        </p>
        </body>
        </html>";
        //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";

        //options to send to cc+bcc
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

        // now lets send the email.
        mail($to, $subject, $message, $headers);
      } else {
        $request->security_approval = 'declined';
        $notification = new Notification();
        $notification->user_id  = $request->user->id;
        $notification->message  = 'Your off-campus request was declined by the security';
        $notification->route    = route('get.off.campus.request', $request->id);
        $notification->save();
        $to = $request->user->email;
        $from = "ahmed@kampasi.com";
        $subject = "Kampasi - Your off-campus request was declined by the security!";
        //begin of HTML message
        $message ="
        <html>
        <body>
        <h1></h1>
        <p>
        Hello ". $request->user->name .", <br>
        Your off-campus request was declined by the security. <br>
        <a style=\"text-decoration:none;color:#246;\" href=\"". route('get.off.campus.request', $request->id) ."\">View the request</a>
        </p>
        </body>
        </html>";
        //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";

        //options to send to cc+bcc
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

        // now lets send the email.
        mail($to, $subject, $message, $headers);
      }
      $request->update();
      return redirect()->back();
    }

    public function confirmDeparture($request_id)
    {
      $request = OffCampusRequest::find($request_id);
      if(Auth::User()->role != 'security') {
        return redirect()->back()->with(['message' => 'sorry you do not have acces to this page.', 'status' => 'alert-info', 'dismiss' => true]);
      } elseif ($request->departed) {
        return redirect()->back()->with(['message' => 'This request has already departed', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $request->departed = 1;
      $request->update();
      return redirect()->back();
    }

    public function confirmArrival($request_id)
    {
      $request = OffCampusRequest::find($request_id);
      if(Auth::User()->role != 'security') {
        return redirect()->back()->with(['message' => 'sorry you do not have acces to this page.', 'status' => 'alert-info', 'dismiss' => true]);
      } elseif ($request->arrived) {
        return redirect()->back()->with(['message' => 'This request has already arrived', 'status' => 'alert-info', 'dismiss' => true]);
      }
      $request->arrived = 1;
      $request->update();
      return redirect()->back();
    }

    public function presence($request_id, $user_id)
    {
      $matchThese = ['user_id' => $user_id, 'off_campus_request_id' => $request_id];
      DB::table('off_campus_request_user')->where($matchThese)->update(['present' => 0]);
      return redirect()->back();
    }

    public function notReturn($request_id, $user_id)
    {
      $matchThese = ['user_id' => $user_id, 'off_campus_request_id' => $request_id];
      DB::table('off_campus_request_user')->where($matchThese)->update(['returned' => 0]);
      return redirect()->back();
    }

    public function getOffCampusList()
    {
      if(isset($_GET['from']) && isset($_GET['to'])) {
        $from = strtotime($_GET['from']);
        $to = strtotime($_GET['to']);
        echo $from;
        //echo $_GET['from'];
        echo '<br>';
        //echo $_GET['to'];
        echo $to;
        echo '<br><br>';
        foreach(Auth::User()->school->offCampusRequests as $request) {
          $departureTime = strtotime(date('Y-m-d', strtotime($request->departure_time)));
          $returnTime = strtotime(date('Y-m-d', strtotime($request->arriving_time)));
          echo 'all <br>';
          echo 'from: ' . $request->departure_time;
          echo ' to: ' . $request->arriving_time;
          echo '<br>';
          if($departureTime >= $from && $returnTime <= $to) {
            echo 'result <br>';
            echo 'from: ' . $request->departure_time;
            echo ' to: ' . $request->arriving_time;
            echo '<br>';
          }
          /*if($departureTime < $from && $returnTime < $to) {
            echo $request;
          }*/
        }
      }

      //return view('app.school.off-campus.off-campus-list');
    }
}
