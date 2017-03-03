<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Tag;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function postQuestion(Request $request)
    {
      //validating Request
      $this->validate($request, [
        'questionTitle' => 'required',
        'questionDescription' => 'required',
        'questionTags' => 'required'
      ]);

      //Creating new question
      $question = new Question();
      $question->title = $request->questionTitle;
      $question->description = $request->questionDescription;
      $question->classroom_id = $request->classroom_id;
      $question->user_id = Auth::User()->id;
      $question->save();

      //Proccessing tags
      $separatedTags = array();
      $tags = $request->questionTags;
      $startPoint = 0;
      while (strpos($tags, ', ') !== false) {
        $breakPoint = strcspn($tags,", ");
        array_push($separatedTags, substr($tags, $startPoint, $breakPoint));
        $tags = substr($tags, $breakPoint+2);
      }
      array_push($separatedTags, $tags);

      //creating new tags
      foreach ($separatedTags as $separatedTag) {
        $tag = new Tag();
        $tag->name = $separatedTag;
        $tag->question_id = Question::count();
        $tag->save();
      }

      return redirect()->back();
    }
}
