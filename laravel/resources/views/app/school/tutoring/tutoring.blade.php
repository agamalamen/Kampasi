@extends('layouts.school')
@section('title') Tutoring program @endsection
@section('app-content')
  @if(Auth::User()->tutor)
  <form action="{{route('post.tutoring', [Auth::user()->school->id])}}" method="post" class="form-inline text-center">
    <select name="subject" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput">
      @foreach(Auth::User()->tutor->subjects as $subject)
        <option value={{$subject->id}}>{{$subject->tutoringSubject->name}}</option>
      @endforeach
    </select>
    <input name="date" type="date" class="form-control mb-2 mr-sm-2 mb-sm-0">
    <select name="tutoringPeriod" class="form-control mb-2 mr-sm-2 mb-sm-0">
      @foreach(Auth::User()->school->tutoringPeriods as $tutoringPeriod)
      <option value={{$tutoringPeriod->id}}>{{$tutoringPeriod->from}} to {{$tutoringPeriod->to}}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
    {{csrf_field()}}
  </form>
  @endif

    <?php
      $i = 0;
      $today = date('Y-m-d');
      while($i < 7) {
        $date = date('Y-m-d', strtotime($today . ' +'. $i .' day'));
        $mydate = strtotime($date);
        $textDate = date('D, jS F', $mydate);
        echo '
        <div class="row" style="color: #333;">
        <h2 style="font-size: 24px; font-family: lato; padding-bottom: 15px;">'. $textDate .'</h2>
        ';
        if($school->tutorings->count() == 0) {
          echo '<p style="color: grey; font-style: italic;">No tutoring slots were added for this day.</p>';
        }
        foreach($school->tutorings as $tutoring) {
          if($tutoring->date == $date) {
            echo '
            <div class="col-md-4">
              <div class="panel panel-primary">
                <div class="panel-body">
                  <img id="user-avatar" class="img-responsive img-circle" style="display: inline; cursor: pointer; height: 35px; width: 35px;" src="' . route("get.avatar", $tutoring->tutor->user->avatar) . '">
                  <h3 style="display: inline; font-size: 16px;"><a href="#" style="font-family: lato;"><b>' . $tutoring->tutor->user->name . '</b></a></h3>
                   <p style="display: inline;">is tutoring for
                  '. $tutoring->tutorSubject->tutoringSubject->name. '</p>
                  <p class="text-center" style="font-size: 18px; color :grey;">' . $tutoring->tutoringPeriod->from . ' to ' . $tutoring->tutoringPeriod->to . '</p>';

            if ($tutoring->tutee_id == 0) {
              if(Auth::User()->id != $tutoring->tutor->user->id && Auth::User()->role == 'student') {
                echo '
                <hr>
                <a class="btn btn-primary btn-sm pull-right" href="' . route("get.signup.tutoring", [Auth::User()->school->id, $tutoring->id]) . '">signup</a>';
              } else {
                echo '
                <hr>
                <p style="color: grey; font-style: italic;">No one signed up for your slot.</p>';
              }
            } else {
                echo '
                <hr>
                <img id="user-avatar" class="img-responsive img-circle" style="display: inline; cursor: pointer; height: 35px; width: 35px;" src="' . route('get.avatar', $tutoring->tutee->user->avatar) . '">
                <h4 style="display: inline; font-size: 14px;"><a href="#">' . $tutoring->tutee->user->name . '</a> signed up for this slot.</h4>';
                if($userWatchingToday) {
                  echo '<hr>';
                  if($tutoring->tutor_here) {
                    echo '<a href="'. route("tutor.not.here", [Auth::User()->school->username, $tutoring->id]) .'" style="display: inline;" class="btn-danger btn-sm">Tutor not here</a>';
                  } else {
                    echo 'Tutor not here <a href="'. route("tutor.not.here", [Auth::User()->school->username, $tutoring->id]) .'">Undo</a>';
                  }
                  if($tutoring->tutee_here) {
                    echo '<a href="'. route("tutee.not.here", [Auth::User()->school->username, $tutoring->id]) .'" style="display: inline; margin-left: 20px;" class="btn-danger btn-sm">Tutee not here</a>';
                  } else {
                    echo '<p style="display: inline; margin-left: 20px;">Tutee not here <a href="'. route("tutee.not.here", [Auth::User()->school->username, $tutoring->id]) .'">Undo</a></p>';
                  }
                }
            }

            echo '
                </div><!-- .panel-body -->
              </div><!-- .panel -->
            </div><!-- .col-md-4 -->';
          }
        }
        $i++;
        echo '</div><!-- .row -->';
      }
    ?>
@endsection
