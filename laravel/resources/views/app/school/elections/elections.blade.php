@extends('layouts.school')
@section('title') ALA elections @endsection
@section('app-content')
  <?php
    $i = 0;
    foreach(Auth::User()->school->users as $user) {
      if($user->voted) {
        $i++;
      }
    }
   ?>
   {{$i}}
  <div class="row">
    <div class="col-md-4">
      @if(Auth::User()->voted)
      <p class="card-title">Your vote</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled">
          @foreach(Auth::User()->votes as $vote)
            @if($vote->candidate)
              <li><b>{{$vote->candidate->user->name}}</b> for {{$vote->candidate->position->name}}</li>
            @endif
          @endforeach
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel -->

      @endif
      <p class="card-title">Comments</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <form class="form-inline text-center" method="post" action="{{route('post.elections.comment', 2017)}}">
            <input type="text" name="content" style="width: 70%" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Your comment goes here..">
            <button type="submit" class="btn btn-primary">Post</button>
            {{csrf_field()}}
          </form>
          <hr>
          @if(Auth::User()->school->ElectionsComments == '[]')
            <p style="color: grey; font-style: italic;" class="text-center">There are no comments to show</p>
          @endif
          <ul class="list-unstyled">
          @foreach(Auth::User()->school->ElectionsComments as $comment)
            <li>
              <a href="{{route('dashboard', $comment->user->username)}}">{{$comment->user->name}}</a>
              <p>{{$comment->content}}</p>
            </li>
            <hr>
          @endforeach
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel-body -->

<!--
      <p class="card-title">Run for elections</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <form action="{{route('post.run', 'hello')}}" method="post">
            <div class="form-group">
              <label style="color: #333;">What are you running for?</label>
              <select name="position" type="text" class="form-control input-lg">
                @foreach(Auth::User()->school->positions as $position)
                <option value={{$position->id}}>{{$position->name}}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Run! Run!</button>
            {{csrf_field()}}
          </form>
        </div><!-- .panel-body
      </div><!-- .panel-primairy -->

      <p class="card-title">Vote for candidates</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <form action="{{route('post.vote', 'hello')}}" method="post">
          @foreach(Auth::User()->school->positions as $position)
            <div class="form-group">
              <label style="color: #333;">{{$position->name}}</label>
              <select name="{{$position->id}}" type="text" class="form-control input-lg">
                <option value=0>No candidate</option>
                @foreach($position->candidates as $candidate)
                <option value={{$candidate->id}}>{{$candidate->user->name}}</option>
                @endforeach
              </select>
            </div>
          @endforeach
          <button type="submit" class="btn btn-primary btn-block btn-lg">Vote</button>
          {{ csrf_field() }}
          </form>
        </div><!-- .panel-body -->
      </div><!-- .panel -->
    </div><!-- .col-md-4 -->

    <div class="col-md-8">
      @foreach(Auth::User()->school->positions as $position)
        <p class="card-title">{{$position->name}}</p>
        <div class="panel panel-primary">
          <div class="panel-body">
            <div class="row">
              @foreach($position->candidates as $candidate)
                <?php
                  $won = 1;
                  foreach($position->candidates as $current_candidate) {
                    if ($candidate->votes < $current_candidate->votes) {
                      $won = 0;
                      break;
                    }
                  }

                 ?>
                <div class="col-md-4 text-center">
                  <img id="avatar" class="img-circle" style="margin-top: 10px; width: 80px; height: 80px;" src="{{route('get.avatar', $candidate->user->avatar)}}">
                  <h3 style="font-family: Montserrat; font-size: 16px;"><a href="{{route('get.candidate', ['2017', $candidate->user->username])}}">{{$candidate->user->name}}</a></h3>
                  @if($won)
                    <p style="color: #d35400;"><i class="fa fa-bolt" aria-hidden="true"></i> Leading</p>
                  @endif
                  @if(Auth::User()->username == 'Afarag16' || Auth::User()->username == 'OJafter16')
                    {{$candidate->votes}}
                  @endif

                </div><!-- .col-md-4 -->
              @endforeach
            </div><!-- .row -->
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      @endforeach
    </div><!-- .col-md-8 -->

  </div><!-- .row -->
@endsection
