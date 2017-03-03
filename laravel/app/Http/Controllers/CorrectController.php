<?php

namespace App\Http\Controllers;
use App\Correct;
use Illuminate\Http\Request;
use App\Http\Requests;

class CorrectController extends Controller
{
    public function postCorrect(Request $request)
    {
      $user_id = $request->userId;
      $answer_id = $request->answerId;
      $current_correct = Correct::where(['user_id' => $user_id, 'answer_id' => $answer_id])->first();
      if($current_correct == '') {
        $correct = new Correct();
        $correct->correct = 1;
        $correct->user_id   = $user_id;
        $correct->answer_id = $answer_id;
        $correct->save();
        return 1;
      } else {
        $current_correct->delete();
        return 0;
      }
    }
}
