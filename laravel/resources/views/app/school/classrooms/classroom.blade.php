@extends('layouts.school')
@section('title') {{$classroom->name}} @endsection
@section('app-content')
  <div class="panel panel-default">
    <div class="panel-body" style="padding-top: 10px; padding-bottom: 10px;">
      <div class="row text-center">
        <div class="col-xs-3">
          <a data-toggle="modal" data-target="#askQuestionModal" style="color: #27ae60" href="#" id="questions-button">
            <i class="fa fa-question" aria-hidden="true"></i> Questions
          </a>
          @include('includes.modals.ask-question')
        </div><!-- col-md-3 -->
        <div class="col-xs-3">
          <a style="color: #27ae60" href="#"><i class="fa fa-bullhorn" aria-hidden="true"></i> Announcements</a>
        </div><!-- col-md-3 -->
        <div class="col-xs-3">
          <a style="color: #27ae60" href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Assignments</a>
        </div><!-- col-md-3 -->
        <div class="col-xs-3">
          <a style="color: #27ae60" href="#"><i class="fa fa-wpforms" aria-hidden="true"></i> Exams</a>
        </div><!-- col-md-3 -->
      </div><!-- .row -->
    </div><!-- .panel-body -->
  </div><!-- .panel-default -->

  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-body text-center">
          <h3 style="font-family: lato; margin-bottom: 0px;">{{$classroom->name}}</h3>
          <a href="#" style="font-family: lato; font-weight: bold; color: #27ae60"><?php echo '@'; ?>{{$classroom->username}}</a>
          <ul class="list-unstyled list-inline text-center" style="padding-top: 10px;">
                <li><img class="img-circle" style="margin-right: -20px; border: 3px solid #fff; width: 40px; height: 40px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"></li>
                <li><img class="img-circle" style="margin-right: -20px; border: 3px solid #fff; width: 40px; height: 40px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"></li>
                <li><img class="img-circle" style="margin-right: -20px; border: 3px solid #fff; width: 40px; height: 40px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"></li>
                <li><img class="img-circle" style="margin-right: -20px; border: 3px solid #fff; width: 40px; height: 40px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"></li>
                <li><img class="img-circle" style="margin-right: -20px; border: 3px solid #fff; width: 40px; height: 40px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}"></li>
                <li style="margin-left: 10px;"><a style="color: #27ae60" href="#"> +23 others</a></li>
          </ul>
        </div> <!-- .panel-body -->
      </div> <!-- .panel-default -->
    </div><!-- .col-md-4 -->

    <div class="col-md-8">
      <p style="color:#333;">Showing {{$classroom->questions->count()}} questions <a class="pull-right" style="color: #27ae60" href="#">Filter results <span class="caret"></span></p>

      <!-- questions goes here -->
      @foreach($classroom->questions as $question)
      <div class="panel panel-default question" id="question">
        <div class="panel-body">
          <div class="media">
            <div class="media-left">
                <a href="{{route('dashboard', $question->user->username)}}">
                  <img class="media-object img-rounded" style="width: 50px; height: 50px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}" alt="...">
                </a>
            </div>
            <div class="media-body">
                <div class="dropdown">
                  <a href="#" id="question-options" class="hidden dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span style="color: 27ae60" class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span></a>
                  <ul class="dropdown-menu pull-right" style="margin-top: 15px;" aria-labelledby="question-options">
                    <li><a href="#">Edit</a></li>
                    <li><a href="#" class="delete-question">Delete</a></li>
                  </ul>
                </div>
                <h3 class="media-heading" style="font-family: lato; font-size: 18px; margin: 0px;">{{$question->user->name}}</h3>
                <ul class="list-unstyled">
                    <li>{{$question->user->role}}</li>
                    <li style="margin-top: -5px;">Joined since 2009</li>
                </ul>
                <p style="font-size: 16px;">{{$question->title}}</p>
                <p id="question-description" class="small text-muted">
                  {{$question->description}}
                </p>
                <ul class="list-inline" style="padding-left: 5px;">
                  @foreach($question->tags as $tag)
                  <li class="badge">{{$tag->name}}</li>
                  @endforeach
                </ul>
                <hr>

                <!-- answer goes here -->
                <div class="answers">
                  @foreach($question->bestAnswers as $answer)
                  <div id="answer" class="answer media" style="margin-bottom: -10px;">
                    <div class="media-left">
                      <a href="{{route('dashboard', $answer->user->username)}}">
                        <img class="media-object img-circle" style="width: 45px; height: 45px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <p>{{$answer->content}}</p>
                    </div><!-- .media-body / answer-body -->
                    <form class="correct-form" method="post" action="{{route('post.correct')}}">
                      <input type="hidden" id="correct-answer-id" name="correct_answer_id" value="{{$answer->id}}" >
                      <input type="hidden" id="correct-user-id" name="correct_user_id" value="{{Auth::User()->id}}" >
                      @if(Auth::User()->correct($answer->id))
                      <input type="submit" id="btn-correct" class="btn btn-corrected btn-xs" style="margin-top: 10px;" value="Correct | {{$answer->corrects->count()}}">
                      @else
                      <input type="submit" id="btn-correct" class="btn btn-correct btn-xs" style="margin-top: 10px;" value="Correct | {{$answer->corrects->count()}}">
                      @endif
                      @foreach($answer->corrects as $correct)
                        @if ($correct->user->role == 'admin')
                          <p class="small" style="color: #27ae60; padding-left: 1px; padding-top: 3px;"><i class="fa fa-check-circle" aria-hidden="true"></i> Admin hit correct</p>
                        @endif
                      @endforeach
                    </form>
                    <script>
                      var correctToken = '{{ Session::token() }}';
                      var correctUrl = "{{route('post.correct')}}";
                    </script>
                  </div><!-- .media / answer -->
                  <hr>
                  @endforeach
                  @if($question->answers->count() > 2)
                  <div style="margin-top: -15px;"><a href="#">View more answers</a><p class="pull-right text-muted">2 of {{$question->answers->count()}}</p></div>
                  @endif
                  <!-- post answer goes here -->
                  <div class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object img-circle" style="width: 45px; height: 45px;" src="{{URL::to('src/img/testimonials/bill-gates.jpeg')}}" alt="...">
                      </a>
                    </div>
                    <div class="media-body">
                      <form class="answer-form" method="post">
                        <textarea name="answerContent" id="answer-content" style="resize:none; border-radius: 3px;" class="form-control" placeholder="Write your answer here.."></textarea>
                        <label class="control-label text-danger" id="answer-content-error"></label>
                        <input name="questionId" id="question-id" type="hidden" value="{{$question->id}}" >
                        <input id="answer-button" class="btn btn-default btn-sm pull-right" style="margin-top: 5px;" type="submit" value="Answer" >
                        {{csrf_field()}}
                      </form>
                      <script>
                        var answerToken = '{{ Session::token() }}';
                        var answerUrl = '{{ route('post.answer') }}';
                      </script>
                    </div><!-- .media-body / post-answer-body -->
                  </div><!-- .media / post-answer -->

                </div><!-- .answers -->

            </div><!-- .media-body -->
          </div><!-- .media -->
        </div><!-- .panel-body -->
      </div><!-- .panel-default -->
      @endforeach
      <div class="see-more-container text-center">
        <a href="#" style="color: #27ae60;padding-bottom: 20px;">See more <span class="caret"></span></a>
      </div><!-- .see-more-container -->
    </div><!-- .col-md-8 -->
  </div><!-- .row -->
@endsection
