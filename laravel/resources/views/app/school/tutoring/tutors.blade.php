@extends('layouts.school')
@section('title') Tutors @endsection
@section('app-content')
    <p style="margin-top: 0px; margin-bottom: 15px;"><a href="{{route('get.tutoring', Auth::User()->school->username)}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back to the tutoring page</a></p>

  @if(Auth::User()->role != 'student')
    <form action="{{route('post.tutor', [Auth::user()->school->id])}}" method="post" class="form-inline text-center">
      <select name="tutor" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput">
        @foreach(Auth::User()->school->students as $student)
        <option value={{$student->id}}>{{$student->name}}</option>
        @endforeach
      </select>

      <button type="submit" class="btn btn-primary">Add tutor</button>
      {{csrf_field()}}
    </form>
  @endif

  <div class="row">
    @foreach($school->tutors as $tutor)
      <div class="col-md-4">
        <div class="media well" style="background-color: #fff;">
          <a class="media-left" href="{{route('dashboard', $tutor->user->username)}}">
            <img class="media-object img-rounded" style="width: 50px; height: 50px;" src="{{route('get.avatar', $tutor->user->avatar)}}" alt="{{$tutor->user->name}}">
          </a>
          <div class="media-body">
            <h2 style="font-size: 16px;" class="media-heading"><a style="color: #333" href="{{route('dashboard', $tutor->user->username)}}">{{$tutor->user->name}}</a></h2>
            <ul class="list-inline username" style="padding-top: 5px;">
              @foreach($tutor->subjects as $subject)
                <li>{{$subject->tutoringSubject->name}}</li>
              @endforeach
            </ul>
            @if(Auth::User()->role != 'student')
              <form action="{{route('post.tutor.subject', [Auth::user()->school->id])}}" method="post" class="form-inline">
                <select name="tutoringSubject" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput">
                  @foreach(Auth::User()->school->tutoringSubjects as $subject)
                  <option value={{$subject->id}}>{{$subject->name}}</option>
                  @endforeach
                </select>
                <input type="hidden" value={{$tutor->id}} name="tutor">
                <button type="submit" class="btn btn-primary">Add subject</button>
                {{csrf_field()}}
              </form>
            @endif
          </div><!-- .media-body -->
        </div><!-- .media -->
      </div><!-- .col-md-4 -->
    @endforeach
  </div><!-- .row -->

@endsection
