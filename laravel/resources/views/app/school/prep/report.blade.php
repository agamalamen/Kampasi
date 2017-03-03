@extends('layouts.school')
@section('title') Prep report @endsection
@section('app-content')

  <div class="container">
    <form action="{{route('get.redirect.prep.date')}}" method="get" class="form-inline text-center">
      <input name="date" type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput">
      <button type="submit" class="btn btn-primary">Submit</button>
      {{csrf_field()}}
    </form>

    <div class="row">
      <div class="col-md-4">
        <h3 class="card-title">Did not signup:</h3>
        <div class="panel panel-primary">
          <div class="panel-body">
            <ul class="list-unstyled">
              <?php
                foreach(Auth::User()->school->users as $user) {
                  if($user->role == 'student') {
                    $prepped = 0;
                    foreach($preps as $prep) {
                      if($prep->user->id == $user->id) {
                        $prepped = 1;
                        break;
                      }
                    }
                    if(!$prepped) {
                      echo '<li><a href="'. route("dashboard", $user->username) .'">' . $user->name . '</a><li>';
                    }
                  }
                }
               ?>
            </ul>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      </div><!-- .col-md-4 -->

      <div class="col-md-4">
        <h3 class="card-title">Signed up late:</h3>
        <div class="panel panel-primary">
          <div class="panel-body">
            <ul class="list-unstyled">
              @foreach($preps as $prep)
                @if($prep->here && $prep->late)
                  <li><a href="{{route('dashboard', $prep->user->username)}}">{{$prep->user->name}}</a></li>
                @endif
              @endforeach
            </ul>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      </div><!-- .col-md-4 -->

      <div class="col-md-4">
        <h3 class="card-title">Not found:</h3>
        <div class="panel panel-primary">
          <div class="panel-body">
            <ul class="list-unstyled">
              @foreach($preps as $prep)
                @if(!$prep->here)
                  <li><a href="{{route('dashboard', $prep->user->username)}}">{{$prep->user->name}}</a></li>
                @endif
              @endforeach
            </ul>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      </div><!-- .col-md-4 -->
    </div><!-- .row -->
  </div><!-- .container -->

@endsection
