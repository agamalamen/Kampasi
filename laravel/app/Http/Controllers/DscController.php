<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\dsc;
use App\School;
use DB;
use App\dscUpdate;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DscController extends Controller
{
    public function getDSC()
    {
      return view('maboneng');
      $school = School::find(1);
      $updates = dscUpdate::orderBy('id', 'DESC')->get();
      return view('app.school.dsc.dsc')->with(['school' => $school, 'updates' => $updates]);
    }

    public function getDSCUpdates()
    {
      return view('maboneng');
      $school = School::find(1);
      $updates = dscUpdate::orderBy('id', 'DESC')->get();
      return view('app.school.dsc.updates')->with(['updates' => $updates, 'school' => $school]);
    }

    public function getDscPhoto($photo_name) {
      $photo = Storage::disk('local')->get('dsc/' . $photo_name);
      return Response($photo, 200);
    }

    public function getCreateDSC()
    {
      return view('maboneng');
      return view('app.school.dsc.create-dsc');
    }

    public function postCreateDSC(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
        'photo' => 'required|mimes:jpeg,jpg,png,gif'
      ]);

      $title = utf8_encode($request['title']);
      $dsc = new dsc();
      $dsc->title = $title;
      $dsc->description = $request['description'];
      $dsc->user_id = Auth::User()->id;
      $dsc->school_id = 1;
      $dsc->save();

      $file = $request->file('photo');
      $file_name = 'dsc-' . $dsc->id . '.jpg';
      $dsc->photo = $file_name;
      $dsc->update();
      if($file) {
        Storage::disk('local')->put('dsc/'.$file_name, File::get($file));
      } else {
        return redirect()->back()->with(['message' => 'Something went wrong please try again.', 'status' => 'alert-danger', 'dismiss' => True]);
      }

      $x = 0;
      $student_count = User::all()->count();
      while ($x < $student_count) {
        if(isset($request[$x])) {
          DB::table('dsc_creators')->insert([
                ['dsc_id' => $dsc->id, 'user_id' => $request[$x]]
            ]);
        }
        $x++;
      }

      DB::table('dsc_creators')->insert([
            ['dsc_id' => $dsc->id, 'user_id' => Auth::User()->id]
        ]);

      return redirect()->route('get.dsc.project', [$dsc->id]);
    }

    public function getDSCProject($dsc_id)
    {
      return view('maboneng');
      $dsc = DSC::find($dsc_id);
      if($dsc == '') {
        return redirect()->route('get.dsc')->with(['message' => 'Sorry! DSC project was not found.', 'status' => 'alert-info', 'dismiss' => true]);
      }

      return view('app.school.dsc.dsc-project')->with(['dsc' => $dsc]);
    }

    public function postDscUpdate(Request $request, $dsc_id)
    {
      $this->validate($request, [
        'content' => 'required',
        'photo' => 'mimes:jpeg,jpg,png,gif'
      ]);

      $rx = '~
      ^(?:https?://)?              # Optional protocol
      (?:www\.)?                  # Optional subdomain
      (?:youtube\.com|youtu\.be)  # Mandatory domain name
      /watch\?v=([^&]+)           # URI with video id as capture group 1
      ~x';

      if($request['photo'] != '' && $request['video'] != '') {
        return redirect()->back()->with(['message' => 'Sorry! You can not add photo and video at the same time.', 'status' => 'alert-warning', 'dismiss' => true]);
      }

      if($request['video'] != '') {
        $has_match = preg_match($rx, $request['video'], $matches);
        if(isset($matches[1])) {
          $video_url = $matches[1];
        } else {
          return redirect()->back()->with(['message' => 'You must enter a valid Youtube URL video.', 'status' => 'alert-danger', 'dismiss' => true]);
        }
      }

      $update = new dscUpdate();
      $update->content = $request['content'];
      $update->user_id = Auth::User()->id;
      $update->dsc_id = $dsc_id;
      $updates = dscUpdate::all()->count() + 1;

      if($request['photo'] != '')
      {
        $file = $request->file('photo');
        $file_name = 'dsc-update-' . $updates . '.jpg';
        $update->photo = $file_name;
      } else {
        $update->photo = 'no photo';
      }

      if($request['video'] != '') {
        $update->video = $video_url;
      } else {
        $update->video = 'no video';
      }

      $update->save();

      if($request['photo'] != '') {
        if($file) {
          Storage::disk('local')->put('dsc/updates/'.$file_name, File::get($file));
        } else {
          return redirect()->back()->with(['message' => 'Something went wrong please try again.', 'status' => 'alert-danger', 'dismiss' => True]);
        }
      }

      return redirect()->route('get.dsc.project', $dsc_id)->with(['message' => 'Your Update was posted successfully!', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function updateDscProgress(Request $request, $dsc_id)
    {
      $this->validate($request, [
        'progress' => 'required|integer|min:0|max:100'
      ]);

      $dsc = dsc::find($dsc_id);
      $dsc->progress = $request['progress'];
      $dsc->update();
      return redirect()->route('get.dsc.project', $dsc_id);
    }


    public function getDscUpdatePhoto($photo_name) {
      $photo = Storage::disk('local')->get('dsc/updates/' . $photo_name);
      return Response($photo, 200);
    }

}
