@extends('layouts.school')
@section('title') Off-campus request @endsection
@section('app-content')

  <ol class="breadcrumb" style="margin-top: -10px;">
    <li><a href="{{route('home')}}">Kampasi</a></li>
    <li><a href="{{route('dashboard', Auth::User()->school->username)}}">{{Auth::User()->school->name}}</a></li>
    <li><a href="{{route('off.campus', 'all')}}">Off campus</a></li>
    <li><a href="{{route('get.off.campus.request', $request->id)}}">Off campus request</a></li>
  </ol>

  <h1 style="color: #333; padding-bottom: 15px;">Request from {{$request->user->name}} to go to {{$request->place}}</h1>
  <div class="row">
    <div class="col-md-6">
      <p class="card-title">Request information</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled">
            <li>Request from: <a href="{{route('dashboard', $request->user->username)}}">{{$request->user->name}}</a></li>
            <li>Heading to: {{$request->place}}</li>
            <li>Request address: {{$request->address}}</li>
            <li>Phone number: {{$request->user->phone}}</li>
            <li>Departuring at: {{$request->departure_time}}</li>
            <li>Returning at: {{$request->arriving_time}}</li>
            @if($chaperoneType == 'internal')
              <li>Chaperone name: <a href="{{route('dashboard', $chaperon->username)}}">{{$chaperon->name}}</a></li>
            @else
              <li>Chaperone name: {{$chaperon->name}} (External)</li>
            @endif
            <li>Chaperone/Driver number: {{$chaperon->phone}}</li>
            <li>Chaperone/Driver email: {{$chaperon->email}}</li>
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel-default -->

      @if ($request->users != '[]')
      <p class="card-title">Other students</p>
      <div class="panel panel-primary">
        <div class="panel-body">
            <?php
              $i = 0;
              $requestUsers = $request->users;
              while ($i < $requestUsers->count())
              {
                if($request_users[$i]->present == 0)
                {
                  echo '<ul class="list-unstyled" style="text-decoration: line-through">';
                  echo '<li><a href="'. route("dashboard", $request->users[$i]->username) .'">'. $request->users[$i]->name .'</a></li>';
                  echo '<li>'. $request->users[$i]->phone .'</li>';
                  echo '</ul>';
                } else {
                  echo '<ul class="list-unstyled">';
                  echo '<li><a href="'. route("dashboard", $request->users[$i]->username) .'">'. $request->users[$i]->name .'</a></li>';
                  echo '<li>'. $request->users[$i]->phone .'</li>';
                  if($request_users[$i]->returned == 0) {
                    echo '<p style="color: red;">Didn\'t return</p>';
                  } elseif($request->departed && !$request->arrived) {
                    echo '<li><a href="'. route('not.return', [$request->id, $request->users[$i]->id]) .'">Didn\'t return</a></li>';
                  }

                  if (Auth::User()->role == 'security' && !$request->departed)
                  {
                    echo '<li><a class="no-print" href="'. route('presence', [$request->id, $request->users[$i]->id]) .'">Not present</a></li>';
                  }
                  echo '</ul>';
                }
                $i++;
              }
            ?>
        </div><!-- .panel-body -->
      </div><!-- .panel-default -->
      @endif
    </div><!-- .col-md-6 -->

    <div class="col-md-6">
      <p class="card-title">Request tracking</p>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled text-muted">
            <li style="color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true"></i> Request created at {{$request->created_at}}</li>

            @if($request->driver_approval == 'accepted')
              <li style="color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true"></i> Request approved by chaperone/driver</li>
            @elseif($request->driver_approval == 'declined')
              <li style="color: #e81212;"><i class="fa fa-times" aria-hidden="true"></i> Request declined by chaperone/driver</li>
            @else
              <li>
                <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                Wating for approval from chaperone/driver
                  @if($request->chaperone_type == 'internal')
                    @if(Auth::User()->id == $chaperon->id)
                      <span class="pull-right">
                        <a href="{{route('driver.accept.request', [$request->id, $chaperon])}}" style="padding-right: 5px;"><i class="fa fa-check" aria-hidden="true"></i> Accept</a>
                        <a href="{{route('driver.decline.request', [$request->id, $chaperon])}}"><i class="fa fa-times" aria-hidden="true"></i> Decline</a>
                      </span>
                    @endif
                  @else
                    @if(Auth::User()->role == 'student_life')
                      <span class="pull-right">
                        <a href="{{route('driver.accept.request', [$request->id, $chaperon])}}" style="padding-right: 5px;"><i class="fa fa-check" aria-hidden="true"></i> Accept</a>
                        <a href="{{route('driver.decline.request', [$request->id, $chaperon])}}"><i class="fa fa-times" aria-hidden="true"></i> Decline</a>
                      </span>
                    @endif
                  @endif
              </li>
            @endif

            @if($request->student_life_approval == 'accepted')
              <li style="color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true"></i> Request approved by student life</li>
            @elseif($request->student_life_approval == 'declined')
              <li style="color: #e81212;"><i class="fa fa-times" aria-hidden="true"></i> Request declined by student life</li>
            @else
              <li>
                <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                Wating for approval from student life
                @if(Auth::User()->role == 'student_life')
                  <span class="pull-right">
                    <a href="{{route('student.life.response', [$request->id, 1])}}" style="padding-right: 5px;"><i class="fa fa-check" aria-hidden="true"></i> Accept</a>
                    <a href="{{route('student.life.response', [$request->id, 0])}}"><i class="fa fa-times" aria-hidden="true"></i> Decline</a>
                  </span>
                @endif
              </li>
            @endif

            @if($request->security_approval == 'accepted')
              <li style="color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true"></i> Request approved by security office</li>
            @elseif($request->security_approval == 'declined')
              <li style="color: #e81212;"><i class="fa fa-times" aria-hidden="true"></i> Request declined by security office</li>
            @else
              <li>
                <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                Wating for approval from security office
                @if(Auth::User()->role == 'security')
                  <span class="pull-right">
                    <a href="{{route('security.response', [$request->id, 1])}}" style="padding-right: 5px;"><i class="fa fa-check" aria-hidden="true"></i> Accept</a>
                    <a href="{{route('security.response', [$request->id, 0])}}"><i class="fa fa-times" aria-hidden="true"></i> Decline</a>
                  </span>
                @endif
              </li>
            @endif

            @if($request->driver_approval == 'accepted' && $request->student_life_approval == 'accepted' && $request->security_approval == 'accepted')

              @if($request->departed == 0 && Auth::User()->role == 'security')
                <li>
                  <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                  Departed from campus
                  <a href="{{route('confirm.departure', [$request->id])}}" class="pull-right">Confirm departure</a>
                </li>
              @elseif($request->departed == 0)
                <li>
                  <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                  Departed from campus
                </li>
              @else
                <li style="color: #27ae60">
                  <i class="fa fa-check-circle" aria-hidden="true"></i>
                  Departed from campus
                </li>
              @endif

              @if($request->departed == 1 && $request->arrived == 0 && Auth::User()->role == 'security')
                <li>
                  <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                  Returned to campus
                  <a href="{{route('confirm.arrival', [$request->id])}}" class="pull-right">Confirm arrival</a>
                </li>
              @elseif($request->arrived == 1)
                <li style="color: #27ae60">
                  <i class="fa fa-check-circle" aria-hidden="true"></i>
                  Returned to campus
                </li>
              @else
              <li>
                <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                Returned to campus
              </li>
              @endif

            @endif
          </ul>
        </div>
      </div><!-- .panel-default -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

@endsection
