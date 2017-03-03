<?php

namespace App\Http\Controllers;
use App\Answer;
use URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class AnswerController extends Controller
{
    public function postAnswer(Request $request)
    {
      $this->validate($request, [
        'answerContent' => 'required'
      ]);
      $answer = new Answer();
      $answer->content = $request->answerContent;
      $answer->user_id = Auth::User()->id;
      $answer->question_id = $request->questionId;
      $avatarUrl = URL::to('src/img/testimonials/bill-gates.jpeg');
      $profileUrl = route('dashboard', Auth::User()->username);
      $answersCount = Answer::count();
      $answerId = $answersCount + 1;
      $response = '<div id="answer-'. $answerId .'" class="answer media" style="margin-bottom: -10px;">
                    <div class="media-left">
                      <a href="'. $profileUrl .'">
                        <img class="media-object img-circle" style="width: 45px; height: 45px;" src="'. $avatarUrl .'">
                      </a>
                    </div>
                    <div class="media-body">
                      <p>'. $answer->content .'</p>
                    </div><!-- .media-body / answer-body -->
                    <a class="btn btn-primary btn-xs" style="margin-top: 10px;" href="#">Correct | 202</a>
                  </div><!-- .media / answer -->
                  <hr>
                  ';
      $answer->save();
      return $response;
    }
}
