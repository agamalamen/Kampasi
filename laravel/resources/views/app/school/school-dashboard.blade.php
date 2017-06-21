
@extends('layouts.school')
@section('title') {{ $school->name }} @endsection
@section('app-header') @include('includes.school-header') @endsection
@section('app-content')

<style>
  body {
    background-color: #f4f7fc !important;
  }
</style>

<div class="row">
  <div class="col-md-12">
  <p class="card-title">Inventory</p>
  @if(Auth::User()->role == 'student' && Auth::User()->items->count() == 0 && Auth::User()->allocatedCosts->count == 0)
  <div class="panel panel-primary">
    <div style="margin-left: 12%; margin-top: 20px;" class="panel-body">
    <div id="printable-card">
      <div class="row">
          <div class="col-md-4" style="margin-left: 20px; height: 300px; background-color: #27ae60;">
              <p class="text-center"><img id="avatar" class="img-circle" style="width: 80px; height: 80px; margin-top: 50px;" src="{{route('get.avatar', Auth::User()->avatar)}}"></p>
              <p class="text-center" style="color: white; font-size: 21px; font-family: timeburner">{{Auth::User()->name}} <span class="visible-print" style="font-family: arial; font-size: 12px;">(Verified)</span></p>
          </div><!-- .col-md-4 -->
          <div class="col-md-6">
              <div id="tile" style="background-color: #34495E; color: white; padding: 22px;">
                <p>This Card serves to confirm that the above named student has completed the clearance procedures for exiting the Academy.</p>
                <p>This card must be presented at the Gate on leaving together with Room Key.</p>
              </div><!-- .tile -->
              <div class="row" style="margin-top: 23px;">
                  <div class="col-md-6">
                    <div id="tile" style="background-color: #2980B9; color: white; padding: 10px;">
                        <p class="text-center">Date departing</p>
                          <form method="post" action="{{route('post.date.departing')}}">
                            <input name="date_departing" type="date" value="{{Auth::User()->date_departing}}" class="form-control">
                            <button type="submit" style="margin-top: 5px;" class="btn btn-default no-print">Update</button>
                            {{ csrf_field() }}
                          </form>
                    </div><!-- .tile -->  
                  </div><!-- .col-md-6 -->                  
                  <div class="col-md-6">
                    <div id="tile" style="background-color: #2980B9; color: white; padding: 10px;">
                        <p class="text-center">Time leaving campus</p>
                        <form method="post" action="{{route('post.time.departing')}}">
                            <input name="time_departing" type="time" value="{{Auth::User()->time_departing}}" class="form-control">
                            <button type="submit" style="margin-top: 5px;" class="btn btn-default no-print">Update</button>
                            {{ csrf_field() }}
                        </form>
                    </div><!-- .tile -->
                  </div><!-- .col-md-6 -->
              </div><!-- .row -->
          </div><!-- .col-md-8 -->
      </div>
    </div><!-- .printable-card -->
    <hr>
    <a href="{{route('get.inventories', Auth::User()->school->username)}}">Go to inventory</a>
    <button onclick="printExitCard()" class="btn btn-primary pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</button>

    <script>
      function printExitCard() {
        var printContents = document.getElementById("printable-card").innerHTML;

           var originalContents = document.body.innerHTML;

           document.body.innerHTML = printContents;

           window.print();

           document.body.innerHTML = originalContents;
      }
    </script>
    </div><!-- .panel-body -->
  </div><!-- .panel -->
  @else
  <div class="panel panel-primary">
    <div class="panel-body">
      @if(Auth::User()->items->count() == 0)
        <p style="color: grey; font-style: italic;">You have no items in your inventory.</p>
      @endif
      <div class="row">
        @foreach(Auth::User()->items as $item)
          <div class='col-md-4'>
            <a href="{{route('get.item', [Auth::User()->school->username, $item->inventory->name, $item->name])}}">{{$item->name}}</a> 
            <p><b>Return date:</b> <span style="color: red;">{{$item->pivot->return_date}}</span></p>
          </div><!-- .col-md-4 -->
        @endforeach
      </div><!-- .row -->
      <hr>
      <a href="{{route('get.inventories', Auth::User()->school->username)}}">Go to inventory</a>
    </div><!-- .panel-body -->
  </div><!-- .panel -->
  @endif
  </div><!-- .col-md-12 -->
</div><!-- .row -->

<div class="row">
  <div class="col-md-4">
    <p class="card-title">Prep signup</p>
    <div class="panel panel-primary" style="border: 0px;">
      <div class="panel-body">

        @if(Auth::User()->role != 'student')
        <div class="row text-center">
          <div class="col-xs-4">
            Signed up:
          </div><!-- .col-md-4 -->
          <div class="col-xs-4">
            Not yet:
          </div><!-- .col-md-4 -->
          <div class="col-xs-4">
            progress:
          </div><!-- .col-md-4 -->
        </div><!-- .row -->

        <div class="row text-center">
          <div class="col-xs-4">
            {{Auth::User()->school->todayPreps->count()}}
          </div><!-- .col-md-4 -->
          <div class="col-xs-4">
            {{Auth::User()->school->students->count() - Auth::User()->school->todayPreps->count()}}
          </div><!-- .col-md-4 -->
          <div class="col-xs-4">
            {{round(Auth::User()->school->todayPreps->count() / Auth::User()->school->students->count() * 100)}}%
          </div><!-- .col-md-3 -->
        </div><!-- .row -->
        @else
          @if(Auth::User()->prep)
            <p style="color: #27ae60"><i class="fa fa-check-circle" aria-hidden="true" style="display:inline;"></i> {{date('D, F, Y')}} you signed up for prep in
              @foreach(Auth::User()->school->prepPlaces as $place)
                @if(Auth::User()->prep->place == $place->id)
                  {{$place->name}}
                @endif
              @endforeach

               today</p>
          @else
          <p style="font-style: italic; color: grey;">You did not signup for prep today.</p>
          @endif
        @endif
        <hr>
        @if(Auth::User()->school->todayNightWatchers == '[]')
          <p style="font-style: italic; color: grey;">No Night watchers were added today.</p>
        @endif

        <div class="row text-center">
          @foreach(Auth::User()->school->todayNightWatchers as $nightWatcher)
          <div class="col-xs-3">
            <a href="{{route('dashboard', $nightWatcher->user->username)}}">
              <img class="img-circle img-responsive" style="width: 50px; height: 50px;" src="{{route('get.avatar', $nightWatcher->user->avatar)}}" alt="{{$nightWatcher->user->name}}">
            </a>
          </div><!-- .col-md-3 -->
          @endforeach
        </div><!-- .row -->
        <hr>
        <a href="{{route('get.prep', 'all')}}">Prep signup panel</a>
      </div><!-- .panel-body -->
    </div><!-- .panel-default -->
  </div><!-- .col-md-4 -->

  <div class="col-md-8">
    <p class="card-title">Off campus</p>
    <div class="panel panel-primary">
      <div class="panel-body" style="min-height: 200px;">
        <div class="container-fluid">
          @if(Auth::User()->offCampusRequest == '[]' || $request == '[]')
            <p class="text-center" style="padding-top: 44px; padding-bottom: 44px; color: grey; font-style: italic;">You do not have any off-campus requests.
              @if(Auth::User()->role == 'student')
              <a href="{{route('off.campus', 'all')}}">Request one</a></p>
              @else
              <a href="{{route('off.campus', 'all')}}">Add yourself to available chaperones</a></p>
              @endif
          @endif
          @if(Auth::User()->offCampusRequest != '[]')
          <h3 style="font-size: 30px; font-weight: light;"><a href="{{route('get.off.campus.request', $request->id)}}">{{$request->place}}</a>
            <i class="fa fa-plane pull-right" aria-hidden="true"></i>
          </h3>
          <p>
            @if($request->arrived)
            <span style="color: #27ae60; font-weight: bold;">Status: Arrived
              @elseif($request->departed)
              <span style="color: #27ae60; font-weight: bold;">Status: Departed
                @elseif($request->driver_approval == 'accepted' && $request->student_life_approval == 'accepted' && $request->security_approval == 'accepted')
                <span style="color: #27ae60; font-weight: bold;">Status: Accepted
                  @elseif($request->driver_approval == 'declined' || $request->student_life_approval == 'declined' || $request->security_approval == 'declined')
                  <span style="color: #e81212; font-weight: bold;">Status: Declined
                    @elseif($request->driver_approval == 'waiting' && $request->student_life_approval == 'waiting' && $request->security_approval == 'waiting')
                    <span style="color: #777; font-weight: bold;">Status: Hold
                      @else
                      <span style="color: #27ae60; font-weight: bold;">Status: In progress
                        @endif
                      </span> <span style="color: grey; font-style: italic;">/ Request by {{$requested_by->name}}</span></p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="row">
                            <?php
                            $departingDateTime = new DateTime($request->departure_time);
                            $departingDate = $departingDateTime->format('d, M, Y');
                            $departingTime = $departingDateTime->format('H:i:s');

                            $returningDateTime = new DateTime($request->arriving_time);
                            $returningDate = $returningDateTime->format('d, M, Y');
                            $returningTime = $returningDateTime->format('H:i:s');
                            ?>
                            <div class="col-md-4">
                              <h4 style="font-size: 24px;">Departing:</h4>
                            </div><!-- .col-md-6 -->
                            <div class="col-md-6 text-center">
                              <h4 style="font-size: 12px;">{{$departingDate}}</h4>
                              <h4 style="font-size: 12px;">{{$departingTime}}</h4>
                            </div><!-- .col-md-6 -->
                          </div><!-- .row -->
                        </div><!-- .col-md-6 -->
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-4">
                              <h4 style="font-size: 24px;">Returning:</h4>
                            </div><!-- .col-md-6 -->
                            <div class="col-md-6 text-center">
                              <h4 style="font-size: 12px;">{{$returningDate}}</h4>
                              <h4 style="font-size: 12px;">{{$returningTime}}</h4>
                            </div><!-- .col-md-6 -->
                          </div><!-- .row -->
                        </div><!-- .col-md-6 -->
                      </div><!-- .row -->
          @endif
          </div><!-- .container -->
        <hr>
        <a href="{{route('off.campus', 'all')}}">Off campus panel</a>

      </div><!-- .panel-body -->
    </div><!-- .panel-default -->
  </div><!-- .col-md-8 -->
</div><!-- .row -->

<div class="row">

  <div class="col-md-4">
    <p class="card-title">Members</p>
    <div class="panel panel-primary">
      <div class="panel-body">
        <form id="search-members-form">
          <input type="text" id="search-members-input" style="margin-bottom: 10px; border-radius: 3px;" placeholder="Search for members..." class="form-control" >
        </form>


        <script>
        var searchMembersRoute = "{{route('search.members')}}";
        var membersLoading = "{{URL::to('src/img/loading/rolling.gif')}}";
        </script>

        <style>
        #style-1::-webkit-scrollbar-track
        {
          border-radius: 10px;
          background-color: #bdc3c7;
        }

        #style-1::-webkit-scrollbar
        {
          width: 8px;
          background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar-thumb
        {
          border-radius: 10px;
          background-color: #555;
        }

        </style>
        <ul class="list-unstyled" id="style-1" style="overflow-y: auto; overflow-x: hidden; height: 120px;">
          @foreach($school->recentUsers as $user)
          <li>
            <div class="row">
              <div class="col-xs-2">
                <img class="img-circle" style="width: 50px; height: 50px;" src="{{route('get.avatar', $user->avatar)}}">
              </div><!-- .col-md-4 -->
              <div class="col-xs-8" style="text-align: left;">
                <a href="{{route('dashboard', $user->username)}}">{{$user->name}}</a>
                <?php
                $bio = $user->bio;
                if(strlen($bio) > 35) {
                  $bio = substr($bio, 0, 35) . '...';
                }
                ?>
                <p>{{$bio}}</p>
              </div><!-- .col-md-8 -->
            </div><!-- .row -->
            <hr>
          </li>
          @endforeach
        </ul>
        <hr>
        <a href="{{route('get.members', ['all'])}}">See all members</a>
      </div><!-- .panel-body -->
    </div><!-- .panel-default -->
  </div><!-- .col-md-4 -->

  <div class="col-md-4">
    <p class="card-title">Feedback system</p>
    <div class="panel panel-primary" style="border: 0px;">
      <div class="panel-body" style="min-height: 140px;">
        @if(Auth::User()->school->feedbacks == '[]')
          <p style="padding-top: 50px; padding-bottom: 50px; color: grey; font-style: italic;" class="text-center">There are no feedbacks to show.</p>
          <hr>
        @endif
        @foreach(Auth::User()->school->recentFeedbacks as $feedback)
          <a href="{{route('get.feedback', $feedback->username)}}">{{$feedback->title}}</a>
          <?php
          $content = $feedback->content;
          if(strlen($content) > 50) {
            $content = substr($content, 0, 250) . '...';
          }
          ?>
          <p>{{$content}}</p>
          <hr>
        @endforeach
        <a href="{{route('get.feedbacks')}}">Feedback panel</a>
      </div><!-- .panel-body -->
    </div><!-- .panel-default -->
  </div><!-- .col-md-4 -->


    <div class="col-md-4">
      <p class="card-title">Student publication</p>
      <div class="panel panel-primary">
        <div class="panel-body" style="min-height: 200px;">
          <div class="container-fluid">
            <form class="form-inline" action="{{route('post.masterpiece')}}" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="labelForFrom">Masterpiece</label>
                <input type="file" class="form-control" name="masterpiece">
              </div>
              <button type="submit" style="margin-top: 10px;" class="btn btn-primary">Submit</button>
              {{csrf_field()}}
            </form>
          </div><!-- .container -->
          <hr>

        </div><!-- .panel-body -->
      </div><!-- .panel-default -->
    </div><!-- .col-md-4 -->
</div><!-- .row -->

<div class="row">
  <div class="col-md-6">
    <p class="card-title">Tutoring program</p>
    <div class="panel panel-primary">
      <div class="panel-body">
          @if(Auth::User()->school->todayTutorings == '[]')
            <p class="no-results text-center">There are no tutoring slots for today.</p>
          @else
          <ul class="list-inline text-center">
            @foreach(Auth::User()->school->todayTutorings as $tutoring)
              <li style="margin-right: 20px;">
                <img class="img-circle" style="width: 50px; height: 50px;" src="{{route('get.avatar', $tutoring->tutor->user->avatar)}}">
              </li>
            @endforeach
          </ul>
          <p class="text-center">
            @if(Auth::User()->school->Todaytutorings->count() == 1)
              is
            @else
              are
            @endif
             tutoring today for
             <?php
              $subjectsTutoredToday = '';
              ?>
             @foreach(Auth::User()->School->todayTutorings as $tutoring)
                <?php $subjectsTutoredToday .= $tutoring->tutorSubject->tutoringSubject->name . ', '; ?>
             @endforeach
             <?php
                $subjectsTutoredToday = substr($subjectsTutoredToday, 0, strlen($subjectsTutoredToday) - 2);
              ?>
             <span style="font-family: lato; font-size: 18px; color: #27ae60; font-weight: bold;">{{$subjectsTutoredToday}}</span>
           </p>
          @endif
        <hr>
        <a href="{{route('get.tutoring', [Auth::User()->school->username])}}">Go to tutoring</a>
      </div><!-- .panel-body -->
    </div><!-- .panel -->
  </div><!-- .col-md-6 -->
</div><!-- .row -->


<!--<div class="row">
  <div class="col-md-8">

    <div class="row well">
      <div class="col-md-2">
        <img style="width: 100px; height: 100px;" src="{{URL::to('src/img/tools/off-campus.png')}}" alt="Off-campus">
      </div><!-- .col-md-3
      <div class="col-md-10" style="color: #333;">
        <h4 style="font-size: 20px; font-family: lato;"><a style="color: #27ae60" href="{{route('off.campus', ['all'])}}">Off campus</a></h4>
        There are alot of stuff to explore! Request to go off-campus as an individual or as a group. All your requests
        progress and tracking details will be here for you.
        <br><a href="{{route('off.campus', ['all'])}}" style="margin-top: 5px;" class="btn btn-primary pull-right">Off campus panel</a>
      </div>
    </div><!-- .row
  </div><!-- .col-md-8

</div> .row -->

<!--<div class="row">
  <div class="col-md-8">

    <div class="row well">
      <div class="col-md-2">
        <img style="width: 100px; height: 100px;" src="{{URL::to('src/img/tools/elections.png')}}" alt="Off-campus">
      </div><!-- .col-md-3
      <div class="col-md-10" style="color: #333;">
        <h4 style="font-size: 20px; font-family: lato;"><a style="color: #27ae60" href="{{route('get.elections', ['all'])}}">ALA elections</a></h4>
        Your vote makes the difference! Check out the candidate running for elections profiles, the ones who lost and the ones who won. Endorse
        those who you think they deserve.
        <br><a href="{{route('off.campus', ['all'])}}" style="margin-top: 5px;" class="btn btn-primary pull-right">ALA elections panel</a>
      </div>
    </div><!-- .row
  </div><!-- .col-md-8

</div><!-- .row -->
@endsection
