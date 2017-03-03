@extends('layouts.school')
@section('title') Feedback system @endsection
@section('app-content')

  <div class="row">
    <div class="col-md-4 visible-lg visible-md">
      <p class="card-title">Publish feedback</p>
      <div class="panel panel-primary" id="publish_feedback">
        <div class="panel-body">
          <form id="post-feedback" action="{{route('post.feedback')}}" method="get">
            <input name="title" type="title" class="form-control input-sm" placeholder="Feedback title*" style="margin-bottom: 5px;" value="{{ old('title') }}">
            <textarea id="post_feedback_content" name="content" class="form-control" placeholder="Write your feedback here.." style="margin-bottom: 5px;">{{ old('content') }}</textarea>
            <input name="tags" type="title" class="form-control input-sm" placeholder="Tags*" style="margin-bottom: 5px;" value="{{ old('tags') }}">
            <input name="anonymous" type="checkbox"> Post Anonymously
            <button id="post-feedback-button" type="submit" class="pull-right btn btn-primary">Publish</button>
            {{ csrf_field() }}
          </form>
        </div><!-- .panel-body -->
      </div><!-- .panel -->
    </div><!-- .col-md-4 -->
    <div class="col-md-8" id="feedback_threads">
      <p class="card-title">Feedback threads</p>
      @if(Auth::User()->school->feedbacks == '[]')
        <p class="text-center" style="color: grey; font-style: italic; font-family: lato;">There are no feedbacks posted yet.</p>
      @endif
      @foreach(Auth::User()->school->feedbacks as $feedback)
      <div class="panel panel-primary" id="feedback_threads">
        <div class="panel-body" style="padding-top: 0px;">
          <h2><a href="{{route('get.feedback', $feedback->username)}}">{{$feedback->title}}</a>
            @if($feedback->resolved)
              <span style="color: #27ae60; font-size: 14px; font-family: arial;">[Resolved]</span>
            @endif
            <span class="pull-right" style="font-size: 16px;">
              <span style="padding-right: 10px;">
                @if($feedback->up_support(Auth::User()->id))
                  {{$feedback->up_supports->count()}} <a href="{{route('get.support.feedback', [1, $feedback->id])}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                @else
                  {{$feedback->up_supports->count()}} <a href="{{route('get.support.feedback', [1, $feedback->id])}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
                @endif
              </span>
              <span>
                @if($feedback->down_support(Auth::User()->id))
                  @if($feedback->down_supports->count() != 0)
                  -
                  @endif
                  {{$feedback->down_supports->count()}} <a href="{{route('get.support.feedback', [0, $feedback->id])}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
                  @else
                  @if($feedback->down_supports->count() != 0)
                  -
                  @endif
                  {{$feedback->down_supports->count()}} <a href="{{route('get.support.feedback', [0, $feedback->id])}}"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                @endif
              </span>
            </span>
          </h2>
          <ul class="unstyled-list" style="padding-left: 0px;">
            @foreach($feedback->tags as $tag)
            <li class="badge">{{$tag->name}}</li>
            @endforeach
          </ul>
          <?php
          $content = $feedback->content;
          if(strlen($content) > 250) {
            $content = substr($content, 0, 250) . '...';
          }
          ?>
          <p>{{$content}} <a href="{{route('get.feedback', $feedback->username)}}">read more</a></p>
          <hr>
          <div class="row">
            @if(!$feedback->anonymous)
              <div class="col-md-2">
                <img id="user-avatar" class="img-responsive img-circle" style="cursor: pointer; height: 50px; width: 50px;" src="{{route('get.avatar', Auth::User()->avatar)}}">
              </div><!-- .col-md-4 -->
              <div class="col-md-4">
                <a href="{{route('dashboard', $feedback->user->username)}}">{{$feedback->user->name}}</a>
                <?php
                  $bio = $feedback->user->bio;
                  if(strlen($bio) > 35) {
                    $bio = substr($bio, 0, 35) . '...';
                  }
                 ?>
                <p style="color: grey; font-style: italic">{{$bio}}</p>
              </div><!-- .col-md-4 -->
            @else
              <div class="col-md-2">
                <img id="user-avatar" class="img-responsive img-circle" style="cursor: pointer; height: 50px; width: 50px;" src="{{route('get.avatar', 'default.jpg')}}">
              </div><!-- .col-md-4 -->
              <div class="col-md-4">
                <a href="#">Anonymous Alien</a>
                <p style="color: grey; font-style: italic">Fixing my space shuttle</p>
              </div><!-- .col-md-4 -->
            @endif
          </div><!-- .row -->
        </div><!-- .panel-body -->
      </div><!-- .panel -->
      @endforeach
    </div><!-- .col-md-8 -->
  </div><!-- .row -->

@endsection
