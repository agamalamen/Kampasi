@extends('layouts.school')
@section('title') {{$feedback->title}} @endsection
@section('app-content')

<div class="row">
  <div class="col-md-8">
    <h3 class="card-title">Feedback thread</h3>
    <div class="panel panel-primary" id="feedback_threads">
      <div class="panel-body" style="padding-top: 0px;">
        <h2><a href="{{route('get.feedback', $feedback->username)}}">{{$feedback->title}}</a>
          @if($feedback->resolved)
            <span style="color: #27ae60; font-size: 14px; font-family: arial;">[Resolved]</span>
          @else
            @if($feedback->user_id == Auth::User()->id)
              <a href="{{route('get.resolve.feedback', $feedback->id)}}" style="color: grey; font-size: 14px; font-family: arial;">Resolved</a>
            @endif
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
        <p>{{$feedback->content}}</p>
        <hr>
        <div class="row">
          @if(!$feedback->anonymous)
          <div class="col-md-2">
            <img id="user-avatar" class="img-responsive img-circle" style="cursor: pointer; height: 50px; width: 50px;" src="{{route('get.avatar', $feedback->user->avatar)}}">
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
    <a href="{{route('get.feedbacks')}}">Back to all feedbacks</a>
  </div><!-- .col-md-8 -->
  <div class="col-md-4">

    <h3 class="card-title">Energy points</h3>
    <div class="panel panel-primary">
      <div class="panel-body">
        <p style="color: #27ae60; font-size: 40px; font-weight: bold;" class="count text-center">{{$feedback->points}}</p>
      </div><!-- .panel-body -->
    </div><!-- .panel -->

    <h3 class="card-title">Comments</h3>
    <div class="panel panel-primary">
      <div class="panel-body">
        <form class="form-inline text-center" method="post" action="{{route('post.feedback.comment', $feedback->id)}}">
          <input type="text" name="content" style="width: 80%" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Your comment goes here..">
          <button type="submit" class="btn btn-primary">Post</button>
          {{csrf_field()}}
        </form>
        <hr>
        @if($feedback->comments == '[]')
          <p style="color: grey; font-style: italic;" class="text-center">There are no comments to show</p>
        @endif
        <ul class="list-unstyled">
        @foreach($feedback->comments as $comment)
          <li>
            <a href="{{route('dashboard', $comment->user->username)}}">{{$comment->user->name}}</a>
            <p>{{$comment->content}}</p>
          </li>
          <hr>
        @endforeach
        </ul>
      </div><!-- .panel-body -->
    </div><!-- .panel -->
  </div><!-- .col-md-4 -->

</div><!-- .row -->
@endsection
