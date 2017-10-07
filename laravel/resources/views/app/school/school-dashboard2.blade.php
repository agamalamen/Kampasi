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
