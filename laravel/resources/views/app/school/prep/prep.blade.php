@extends('layouts.school')
@section('title') Prep signup @endsection
@section('app-content')

  <!--Load the AJAX API-->
  <script type="text/javascript">

    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawAnotherChart);

    function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['On time', {{Auth::User()->school->todayOnTimePreps->count()}}],
        ['Late', {{Auth::User()->school->todayLatePreps->count()}}],
        ['Not found', {{Auth::User()->school->todayNotHerePreps->count()}}],
        ['Didn\'t sign up', {{Auth::User()->school->students->count() - Auth::User()->school->todayPreps->count()}}]
      ]);

      // Set chart options
      var options = {'title':'Prep signup',
                     'width':500,
                     'height':350};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }

    function drawAnotherChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Classrooms", {{Auth::User()->school->todayClassroomsPreps->count()}}, "#b87333"],
        ["Dorms", {{Auth::User()->school->todayDormsPreps->count()}}, "silver"],
        ["MST", {{Auth::User()->school->todayMSTPreps->count()}}, "gold"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Where do students prep?",
        width: 500,
        height: 350,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
    }
  </script>

  <!--Div that will hold the pie chart-->

  <?php $userWatchingToday = 0; ?>
  @foreach(Auth::User()->school->todayNightWatchers as $nightWatcher)
    @if($nightWatcher->user_id == Auth::User()->id)
      <?php
        $userWatchingToday = 1;
        break;
       ?>
    @endif
  @endforeach

<div class="container">
  @if(Auth::User()->role != 'student')
  <div class="panel panel-primary">
    <div class="panel-body">
      <div class="row text-center">
        <div class="col-md-3">
          All students: {{Auth::User()->school->students->count()}}
        </div><!-- .col-md-4 -->
        <div class="col-md-3">
          Signed up: {{Auth::User()->school->todayPreps->count()}}
        </div><!-- .col-md-4 -->
        <div class="col-md-3">
          Not yet: {{Auth::User()->school->students->count() - Auth::User()->school->todayPreps->count()}}
        </div><!-- .col-md-4 -->
        <div class="col-md-3">
          progress: {{round(Auth::User()->school->todayPreps->count() / Auth::User()->school->students->count() * 100)}}%
        </div><!-- .col-md-3 -->
      </div><!-- .row -->
    </div><!-- .panel-body -->
  </div><!-- .panel-primary -->

  @if($userWatchingToday)
  <p class="text-center" style="padding-bottom: 10px;"><a href="#" id="show_detailed_report">Show detailed report <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></p>
  <div id="detailed_report" style="display: none;">
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div id="chart_div"></div>
      </div>
    </div><!-- .col-md-6 -->
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div id="barchart_values"></div>
      </div><!-- .panel -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-4">
      <h3 class="card-title">Did not signup:</h3>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled">
            @if($todayPreps->count() == Auth::User()->school->students->count())
              <p style="font-style: italic; color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true" style="display:inline;"></i> Everybody signed up for prep.</p>
            @endif
              @foreach(Auth::User()->school->users as $user)
                @if($user->prep == '' && $user->role == 'student')
                  <li><a href="{{route('dashboard', [$user->username])}}">{{$user->name}}</a></li>
                @endif
              @endforeach
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel-primary -->
    </div><!-- .col-md-4 -->

    <div class="col-md-4">
      <h3 class="card-title">Signed up late:</h3>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled">
            @if(Auth::User()->school->todayLatePreps->count() == 0)
              <p style="font-style: italic; color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true" style="display:inline;"></i> No late signups for today.</p>
            @endif
              @foreach(Auth::User()->school->todayLatePreps as $prep)
                  <li><a href="{{route('dashboard', [$prep->user->username])}}">{{$prep->user->name}}</a></li>
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
            @if(Auth::User()->school->todayNotHerePreps->count() == 0)
              <p style="font-style: italic; color: #27ae60;"><i class="fa fa-check-circle" aria-hidden="true" style="display:inline;"></i> No late signups for today.</p>
            @endif
              @foreach(Auth::User()->school->todayNotHerePreps as $prep)
                  <li><a href="{{route('dashboard', [$prep->user->username])}}">{{$prep->user->name}}</a></li>
              @endforeach
          </ul>
        </div><!-- .panel-body -->
      </div><!-- .panel-primary -->
    </div><!-- .col-md-4 -->
  </div><!-- .row -->
  </div><!-- .detailed report -->
  @endif
@endif

  @if(Auth::User()->role == 'student')
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-body">
            <h1 style="font-family: lato; font-weight: bold;">{{date('D, F, Y')}}</h1>
            <form action="{{route('post.prep')}}" method="post" style="margin-top: 20px;">
              <div class="form-group">
                <label style="color: #333;">Where do you want to prep?</label>
                <select name="place" type="text" class="form-control input-lg" placeholder="Username or Email">
                  @foreach(Auth::User()->school->prepPlaces as $place)
                    @if($place->available)
                      <option value="{{$place->id}}">{{$place->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <?php
                if(Date('D') == 'Sat' || Date('D') == 'Fri') {
                  $prepDisabled = "disabled";
                } else {
                  $prepDisabled = "";
                }
               ?>
              <button type="submit" class="btn btn-primary btn-block btn-lg {{$prepDisabled}}">Signup for prep</button>
              {{ csrf_field() }}
            </form>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->

        <div class="panel panel-primary">
          <div class="panel-body">
            <h2>Night watchers</h2>
            @if(Auth::User()->school->todayNightWatchers != '[]')
              <ul class="list-unstyled">
              @foreach(Auth::User()->school->todayNightWatchers as $nightWatcher)
                <li><a href="{{route('dashboard', [$nightWatcher->user->username])}}">{{$nightWatcher->user->name}}</a>
                  @if($nightWatcher->place != 'house-master')
                    watching {{$nightWatcher->place}}
                  @endif
                </li>
              @endforeach
              </ul>
          @else
          <p style="font-style: italic; color: #7f8c8d;">There are no night watchers to show.</p>
          @endif
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      </div><!-- .col-md-6 -->

      <div class="col-md-6">
        <!--<div class="panel panel-primary" style="border: 0px;">
          <div class="panel-body">
            You marked
            <select class="prep-default">
              @if(Auth::User()->prep_place_id != 0)
                <option value="{{Auth::User()->prepPlace->id}}">{{Auth::User()->prepPlace->name}}</option>
              @else
                <option value=0>No place</option>
              @endif
              @foreach(Auth::User()->school->prepPlaces as $place)
                @if($place != Auth::User()->prepPlace)
                  <option value="{{$place->id}}">{{$place->name}}</option>
                @endif
              @endforeach
            </select>
            as your default place for prep. <span id="updatePrepPlaceStatus" style="display:none; color: #27ae60"></span>
          </div><!-- .panel-body 

          <script>
            var updatePrepPlaceRoute = "{{route('update.prep.place')}}";
          </script>

        </div><!-- .panel-primary -->

        <div class="panel panel-primary">
          <div class="panel-body">
            <ul class="list-unstyled">
              @if(Auth::User()->preps == '[]')
              <p style="font-style: italic; color: #7f8c8d;">There are no prep signups to show.</p>
              @endif
              @foreach(Auth::User()->preps as $prep)
                <?php
                  $prepDate = date("d, F, Y", strtotime($prep->date));
                ?>
                @if($prep->prepPlace)
                  <li><b>{{$prepDate}}</b> you signed up for prep in {{$prep->prepPlace->name}}</li>
                @endif
              @endforeach
            </ul>
          </div><!-- .panel-body -->
        </div><!-- .panel-primary -->
      </div><!-- .col-md-6 -->
    </div><!-- .row -->
  @else
    <div class="row" style="color: #333;">
      <div class="col-md-6">

        @if(!$userWatchingToday)
        <h2 class="card-title">Add yourself as a night watcher</h2>
          <div class="panel panel-primary">
            <div class="panel-body">
              <form action="{{route('post.night.watchers')}}" method="post" style="margin-top: 15px;">
                <div class="form-group">
                  <label style="color: #333">Name</label>
                  <select class="form-control input-lg" name="duty_id">
                      @if(Auth::User()->authority)
                        @if(Auth::User()->authority->prep_duty)
                          <option value="{{Auth::User()->id}}">{{Auth::User()->name}}</option>
                        @endif
                      @endif
                  </select>
                  <label style="color: #333; margin-top: 5px;">Duty</label>
                  <select class="form-control input-lg" name="place">
                    <option value="house-master">House Master</option>
                    <option value="classrooms">Classrooms</option>
                    <option value="dorms">Dorms</option>
                  </select>
                </div>
                <button id="loginButton" type="submit" class="btn btn-primary btn-lg pull-right">Add</button>
                {{ csrf_field() }}
              </form>
            </div><!-- .panel-body -->
          </div><!-- .panel-primary -->
        @else
          <div class="panel panel-primary" style="min-height: 436px;">
            <div class="panel-heading" style="background-color: white;">
              <ul class="list-unstyled list-inline text-center">
                <li><a href="{{route('get.prep', ['all'])}}">All</a></li>
                @foreach(Auth::User()->school->prepPlaces as $prepPlace)
                <li><a href="{{route('get.prep', [$prepPlace->name])}}">{{$prepPlace->name}}</a></li>
                @endforeach
              </ul>
              @if($place == 'Dorms')
                <ul class="list-unstyled list-inline text-center">
                  @foreach(Auth::User()->school->halls as $hall)
                    <li><a href="{{route('get.prep', [$place]) . '?hall=' . $hall->name}}">{{$hall->name}}</a></li>
                  @endforeach
                </ul>
              @endif
            </div><!-- panel-heading -->
            <div class="panel-body">
              <ul class="list-unstyled">
                @if($todayPreps == '[]')
                  <p style="font-style: italic; color: #7f8c8d;">There are no prep signups to show.</p>
                @endif

                @if(isset($_GET['hall']))
                  @if($place == 'Dorms')
                    @foreach(Auth::User()->school->halls as $hall)
                        @if ($_GET['hall'] == $hall->name)
                          @foreach($todayPreps as $prep)
                            @if($prep->user->hall)
                              @if($prep->user->hall->id == $hall->id)
                                @if(!$prep->here)
                                  <li style="color: #e74c3c;"><a style="color: #c0392b;" href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a>
                                    @if(Auth::User()->room)
                                      (Room: {{Auth::User()->room}})
                                    @endif
                                    signed up for prep in {{$prep->prepPlace->name}} (Not here) <a href="{{route('prep.not.here.undo', [$prep->user->id])}}">Undo</li>
                                  <hr>
                                @elseif ($prep->late)
                                  <li style="color: #e67e22;"><a style="color: #d35400" href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in  (Late)<a href="{{route('prep.not.here', [$prep->user->id])}}"><span class="badge pull-right">Not here</span></a></li>
                                  <hr>
                                @elseif($prep->here)
                                    <li><a href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a>
                                       @if($prep->user->room)
                                       <span style="color: grey; font-style: italic">(Room: {{$prep->user->room}})</span>
                                       @endif
                                       signed up for prep in {{$prep->prepPlace->name}} <a href="{{route('prep.not.here', [$prep->user->id])}}"><span class="badge pull-right">Not here</span></a></li>
                                    <hr>
                                @endif
                              @endif
                            @endif
                          @endforeach
                        @endif
                    @endforeach
                  @endif

                  @else
                    @foreach($todayPreps as $prep)
                      @if($prep->prepPlace)
                        @if(!$prep->here)
                          <li style="color: #e74c3c;"><a style="color: #c0392b;" href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in {{$prep->prepPlace->name}} (Not here) <a href="{{route('prep.not.here.undo', [$prep->user->id])}}">Undo</a></li>
                          <hr>
                        @elseif ($prep->late)
                          <li style="color: #e67e22;"><a style="color: #d35400" href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in {{$prep->prepPlace->name}} (Late)<a href="{{route('prep.not.here', [$prep->user->id])}}"><span class="badge pull-right">Not here</span></a></li>
                          <hr>
                        @elseif($prep->here)
                          <li><a href="{{route('dashboard', [$prep->user->username])}}"><b>{{$prep->user->name}}</b></a> signed up for prep in {{$prep->prepPlace->name}} <a href="{{route('prep.not.here', [$prep->user->id])}}"><span class="badge pull-right">Not here</span></a></li>
                          <hr>
                        @endif
                      @endif
                    @endforeach
                @endif
              </ul>
            </div><!-- .panel-body -->
          </div><!-- .panel-primary -->
        @endif

      </div><!-- .col-md-6 -->

      <div class="col-md-6">


        <?php
          if(!Auth::User()->authority) {
            $nightWatchersMinHeight = "min-height: 394px;";
          } elseif (!Auth::User()->authority->add_night_watchers) {
            $nightWatchersMinHeight = "min-height: 394px;";
          } else {
            $nightWatchersMinHeight = "";
          }
         ?>

        <h2 class="card-title">Night watchers</h2>
        <div class="panel panel-primary" style="{{$nightWatchersMinHeight}}">
          <div class="panel-body">
            <ul class="list-unstyled" style="margin-top: 5px;">
            @if(Auth::User()->school->todayNightWatchers != '[]')
              @foreach(Auth::User()->school->todayNightWatchers as $nightWatcher)
                <li><a href="{{route('dashboard', [$nightWatcher->user->username])}}">{{$nightWatcher->user->name}}</a>
                  @if($nightWatcher->place != 'house-master')
                    watching {{$nightWatcher->place}}
                  @endif
                </li>
              @endforeach
            @else
              <p style="font-style: italic; color: #7f8c8d;">You didn't add any night wathcers for today.</p>
            @endif
            </ul>
          </div><!-- panel-body -->
        </div><!-- .panel-primary -->

        @if(Auth::User()->authority)
          @if(Auth::User()->authority->add_night_watchers)
            <div class="panel panel-primary">
              <div class="panel-body">
                <h2 style="margin: 0px;">Add night watcher</h2>
                <form action="{{route('post.night.watchers')}}" method="post" style="margin-top: 15px;">
                  <div class="form-group">
                    <label style="color: #333">Name</label>
                    <select class="form-control input-lg" name="duty_id">
                      @foreach(Auth::User()->school->users as $user)
                        @if($user->authority)
                          @if($user->authority->prep_duty)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                          @endif
                        @endif
                      @endforeach
                    </select>
                    <label style="color: #333; margin-top: 5px;">Duty</label>
                    <select class="form-control input-lg" name="place">
                      <option value="house-master">House Master</option>
                      <option value="classrooms">Classrooms</option>
                      <option value="dorms">Dorms</option>
                    </select>
                  </div>
                  <button id="loginButton" type="submit" class="btn btn-primary btn-lg pull-right">Add</button>
                  {{ csrf_field() }}
                </form>
              </div><!-- .panel-body -->
            </div><!-- .panel-primary -->
          @endif
        @endif
      </div><!-- .col-md-6 -->
    </div><!-- .row -->
  @endif

  @if(Auth::User()->role != 'student')
  <div class="row" style="color: #333;">
    <div class="col-md-12">
      <h1 class="card-title">History</h1>
      <div class="panel panel-primary">
        <div class="panel-body">
          <ul class="list-unstyled">
          @foreach(Auth::User()->school->recentPreps as $prep)
            @foreach(Auth::User()->school->prepPlaces as $place)
              @if($prep->place == $place->id)
                <li>{{$prep->user->name}} signed up for prep in {{$place->name}} on {{$prep->date}}</li>
              @endif
            @endforeach
          @endforeach
          </ul>
          <a href="{{route('get.prep.history')}}" class="text-center">View all prep history <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        </div><!-- .panel-body -->
      </div><!-- .panel-primary -->
    </div><!-- .col-md-12 -->
  </div><!-- .row> -->
@endif

</div><!-- .container -->

@endsection
