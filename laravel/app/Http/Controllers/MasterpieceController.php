<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Input;
use Fileentry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Masterpiece;
use App\Http\Requests;

class MasterpieceController extends Controller
{
    public function getMasterpieces()
    {
      $masterpieces = Masterpiece::all();
      return view('app.school.masterpiece.masterpieces')->with(['masterpieces' => $masterpieces]);
    }

    public function getMasterpiece($id)
    {
      $masterpiece = Masterpiece::find($id);
      $file = Storage::disk('local')->get('masterpieces/' . $masterpiece->file);
      return (new Response($file, 200));
        //->header('Content-Type', $masterpiece->mime);
    }

    public function postMasterpiece(Request $request)
    {
      $this->validate($request, [
        'masterpiece' => 'required|mimes:jpeg,jpg,png,gif,pdf,docx'
      ]);
      $file = $request->file('masterpiece');
      $extension = Input::file('masterpiece')->getClientOriginalExtension();
      $mime = $file->getClientMimeType();

      $user = Auth::User();

      $file_name = 'masterpiece-' . Masterpiece::all()->count() . '-user-' . $user->id . '.' . $extension;

      $masterpiece = new Masterpiece();
      $masterpiece->user_id = $user->id;
      $masterpiece->file = $file_name;
      $masterpiece->mime = $mime;
      $masterpiece->save();

      if($file) {
        $file->move('src/masterpieces', $file_name);
        //Storage::disk('local')->put('public/' . $file_name, File::get($file));
        $message = 'Your masterpiece was uploaded successfully!';
        $status = 'alert-success';
        return redirect()->back()->with(['message' => $message, 'status' => $status, 'dismiss' => true]);
      } else {
        return redirect()->back()->with(['message' => 'Sorry something went wrong! please try again.', 'status' => 'alert-warning', 'dismiss' => true]);
      }
    }
}
