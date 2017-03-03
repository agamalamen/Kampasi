<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\FeedbackSupport;
use App\FeedbackTag;
use App\FeedbackComment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Redirect;

class FeedbackController extends Controller
{
    public function getFeedbacks()
    {
      return view('app.school.feedback.feedbacks');
    }

    public function getFeedback($username)
    {
      $feedback = Feedback::where('username', $username)->first();
      return view('app.school.feedback.feedback')->with(['feedback' => $feedback]);
    }

    public function postFeedbackComment(Request $request, $feedback_id)
    {
      $this->validate($request, [
        'content' => 'required'
      ]);

      $feedback = Feedback::find($feedback_id);
      $comment = new FeedbackComment();
      $comment->content = $request['content'];
      $comment->feedback_id = $feedback_id;
      $comment->user_id = Auth::User()->id;
      $comment->save();
      $feedback->points = $feedback->points + 2;
      $feedback->update();
      return redirect()->back();
    }

    public function postFeedback(Request $request)
    {

      $this->validate($request, [
        'title' => 'required',
        'content' => 'required',
        'tags' => 'required'
      ]);

      $feedback = new Feedback();
      $feedback->title = $request['title'];
      $feedback->content = $request['content'];
      $feedback->user_id = Auth::User()->id;
      if($request['anonymous'] == 'on') {
        $feedback->anonymous = 1;
      } else {
        $feedback->anonymous = 0;
      }
      $feedback->school_id = Auth::User()->school->id;

      $username = strtolower($request['title']);
      //Make alphanumeric (removes all other characters)
      $username = preg_replace("/[^a-z0-9_\s-]/", "", $request['title']);
      //Clean up multiple dashes or whitespaces
      $username = preg_replace("/[\s-]+/", " ", $request['title']);
      //Convert whitespaces and underscore to dash
      $username = preg_replace("/[\s_]/", "-", $request['title']);

      $feedback->username = $username;
      $duplicated_feedback = Feedback::where('username', $username)->first();
      if($duplicated_feedback) {
        return redirect()->back()->with(['message' => 'Sorry this feedback title is already taken', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $feedback->save();

      //Proccessing tags
      $separatedTags = array();
      $tags = $request['tags'];
      $startPoint = 0;
      while (strpos($tags, ', ') !== false) {
        $breakPoint = strcspn($tags,", ");
        array_push($separatedTags, substr($tags, $startPoint, $breakPoint));
        $tags = substr($tags, $breakPoint+2);
      }
      array_push($separatedTags, $tags);

      //creating new tags
      foreach ($separatedTags as $separatedTag) {
        $tag = new FeedbackTag();
        $tag->name = $separatedTag;
        $tag->feedback_id = $feedback->id;
        $tag->save();
      }
      $feedback_content = preg_replace( "/\r|\n/", "", $feedback->content);
      return Redirect::to('api/content-checker.php?text=' . $feedback_content . "&feedback_id=" . $feedback->id);
      //return redirect()->route('get.feedback', $feedback->username)->with(['message' => 'Your feedback was posted successfully.', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getFeedbackContentChecker()
    {
      $feedback = Feedback::find($_GET['feedback_id']);
      $points = $feedback->points;
      if($_GET['adult'] == 'adult' || $_GET['spam'] == 'spam') {
        $feedback->delete();
        return redirect()->route('get.feedbacks')->with(['message' => 'Sorry we cannot publish your feedback. It is either considered as spam or adult content.', 'status' => 'alert-danger', 'dismiss' => true]);
      } else {
        $points = $points + 10;
      }

      if($_GET['sentiment'] == 'positive') {
        $points = $points + 5;
      } elseif($_GET['sentiment'] == 'neutral') {
        $points = $points + 3;
      } else {
        $points = $points - 2;
      }

      if($_GET['readability'] == 'advanced') {
        $points = $points + 5;
      } elseif($_GET['readability'] == 'intermediate') {
        $points = $points + 3;
      }

      if($_GET['subjectivity'] == 'subjective') {
        $points = $points + 5;
      }

      $feedback->points = $points;
      $feedback->update();
      return redirect()->route('get.feedback', $feedback->username)->with(['points' => $points, 'message' => 'Your feedback was posted successfully.', 'status' => 'alert-success', 'dismiss' => true, 'points' => $points]);
    }

    public function getSupportFeedback($support_boolean, $feedback_id)
    {
      $feedback = Feedback::find($feedback_id);
      $support = FeedbackSupport::where(['user_id' => Auth::User()->id, 'feedback_id' => $feedback_id])->first();
      if($support) {
        if($support->support == $support_boolean) {
          $support->delete();
          return redirect()->back();
        } else {
          $support->support = $support_boolean;
          $support->update();
          return redirect()->back();
        }
      } else {
        $support = new FeedbackSupport();
        $support->support = $support_boolean;
        $support->user_id = Auth::User()->id;
        $support->feedback_id = $feedback_id;
        $feedback->points = $feedback->points + 1;
        $feedback->update();
        $support->save();
        return redirect()->back();
      }
    }

    public function getResolveFeedback($feedback_id)
    {
        $feedback = Feedback::find($feedback_id);
        if($feedback->user_id != Auth::User()->id) {
          return redirect()->back()->with(['message' => 'You are not allowed to resolve this feedback', 'status' => 'alert-danger', 'dismiss' => true]);
        }
        $feedback->resolved = 1;
        $feedback->points += 20;
        $feedback->update();
        return redirect()->back();
    }

}
