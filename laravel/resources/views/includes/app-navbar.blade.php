<nav class="navbar" style="background-color: #34495e; padding: 0px; margin: 0px; border-radius: 0px;">
    <p class="text-center" style="padding-top: 13px; font-size: 16px; text-align: center;"><i class="fa fa-dollar" aria-hidden="true"></i>
      Help Brima Bangura to attend Embry-Riddle Aeronautical University. <i class="fa fa-dollar" aria-hidden="true"></i>
      <a class="btn btn-default"  target="_blank" href="https://www.gofundme.com/bbangura?rcid=cd77233214a44b31801c36fcafe6a186" style="border: 0px; border-radius: 15px; background-color: #2980b9;">Campaign page</a>
    </p>
</nav>

<?php
$birthday_guys = '';
foreach(Auth::User()->school->users as $user) {
  $today = date('Y-m-d');
  $todayDate = DateTime::createFromFormat("Y-m-d", $today);
  $current_day = $todayDate->format("d");
  $current_month = $todayDate->format("m");

  $birthdate = $user->birthdate;
  $userBirthdate = DateTime::createFromFormat("Y-m-d", $birthdate);
  $birthdate_day = $userBirthdate->format("d");
  $birthdate_month = $userBirthdate->format("m");

  if($current_day == $birthdate_day && $current_month == $birthdate_month) {
    $birthday_guys .= $user->name . ', ';
  }
}
$birthday_guys = substr($birthday_guys, 0, strlen($birthday_guys) - 2);
?>

<!-- Modal -->
<div id="addBirthdate" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 10px 10px 10px 10px;">
      <div class="big_container" style="border-radius: 6px 6px 0px 0px;">
        <h3 style="text-align: center; color: #333; font-family: lato;">Add your birthdate</h3>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <form action="{{route('post.birthdate')}}" method="post">
                <input type="date" name="birthdate" class="form-control">
            </div>
        </div>
      </div>
          <p style="text-align: center;"><button type="submit" class="btn btn-primary">Save</button></p>
          {{csrf_field()}}
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

@if($birthday_guys != '')
<nav class="navbar" style="background-color: #34495e; padding: 0px; margin: 0px; border-radius: 0px;">
    <p class="text-center" style="padding-top: 13px; font-size: 16px; text-align: center;"><i class="fa fa-gift" aria-hidden="true"></i>
      Happy birthday, {{$birthday_guys}} !
      @if(Auth::User()->birthdate == '0000-00-00')
      <a class="btn btn-default" data-toggle="modal" data-target="#addBirthdate" style="border: 0px; border-radius: 15px; background-color: #2980b9;" href="#">Add your birthdate</a>
      @endif
    </p>
</nav>
@endif

@if(isset($background_cover))
  <style>
    .big-header {
      background-image: url("{{URL::to('src/img/cover.png')}}");
    }
  </style>
@else
  <style>
    .big-header {
      background-color: #27ae60;
    }
  </style>
@endif

<div class="big-header">
  <nav style="margin-bottom: -20px;" class="navbar navbar-default navbar-static-top dashboard-header">
    <div class="container">
      <div class="search-form hide">
        <i id="close-search-form" class="fa fa-times" aria-hidden="true" style="cursor: pointer;"></i> <input style="background-color: #2ecc71; border: 0px;" id="search-input" type="text" class="form-control input-lg">
      </div><!-- .search-form -->
      <div class="top-navbar">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{{route('home')}}}">Kampasi</a><small class="hidden-xs">Beta</small>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          @if(Auth::User())
            <ul class="nav navbar-nav visible-xs">
              <li><a href="{{route('dashboard', Auth::User()->username)}}">{{Auth::User()->name}}</a></li>
              <li><a href="{{route('dashboard', Auth::User()->school->username)}}">Dashboard</a></li>
              <li><a href="{{route('get.notifications')}}">Notifications</a></li>
              <li><a href="{{route('logout')}}">Logout</a></li>
            </ul>
          @else
            <ul class="nav navbar-nav visible-xs">
              <li><a href="{{route('get.login')}}">Login</a></li>
            </ul>
          @endif
          @if(Auth::User())
            <ul class="nav navbar-nav navbar-right visible-lg visible-md visible-sm">
                <!--<li><a href="{{route('change.language', 'en')}}">En</a></li>
                <li style="margin-right: 50px;"><a href="{{route('change.language', 'fr')}}">Fr</a></li>-->
              <li>
                <img style="cursor: pointer; padding-top: 9px; padding-right: 20px;" class="dropdown-toggle" data-toggle="dropdown" src="{{URL::to('src/img/icons/settings.svg')}}" style="width: 25px; height: 25px;">
              </li>
              <li>
                <div class="dropdown">
                  @if(Auth::User()->unseenNotifications == '[]')
                  <img id="settings-icon" style="cursor: pointer; padding-top: 9px;" class="dropdown-toggle" data-toggle="dropdown" src="{{URL::to('src/img/icons/notification.svg')}}" style="width: 25px; height: 25px;">
                  @else
                  <span class="badge dropdown-toggle" data-toggle="dropdown" style="cursor: pointer; background-color: #e74c3c">{{Auth::User()->unseenNotifications->count()}}</span>
                  <img id="settings-icon" style="cursor: pointer; padding-top: 9px;" class="dropdown-toggle" data-toggle="dropdown" src="{{URL::to('src/img/icons/notification.svg')}}" style="width: 25px; height: 25px;">
                  @endif
                  <ul class="dropdown-menu" style="margin-top: 5px; width: 350px;">
                    @foreach(Auth::User()->notifications as $notification)
                      @if($notification->seen)
                        <li style="color: #333; font-size: 12px; padding: 10 30 10 30px; opacity: 0.5">
                          <a style="padding:0px;" href="{{$notification->route}}">{{$notification->message}}</a>
                        </li>
                      @else
                        <li style="color: #333; font-size: 12px; padding: 10 30 10 30px;">
                          <form action="{{route('proccess.notification')}}" method="post">
                            <input type="hidden" name="route" value="{{$notification->route}}">
                            <input type="hidden" name="notification_id" value="{{$notification->id}}">
                            <button type="submit" style="padding:0px; border:0px; background-color: #fff; color: #27ae60"><i class="fa fa-circle-o" aria-hidden="true" style="color: #e74c3c;"></i> {{$notification->message}}</button>
                            {{csrf_field()}}
                          </form>
                        </li>
                      @endif
                    @endforeach
                    @if(Auth::User()->notifications == '[]')
                      <li style="color: #27ae60; font-size: 12px; padding: 10 30 10 30px;">There are no notifications to show.</li>
                    @else
                    <li role="separator" class="divider"></li>
                    <a href="{{route('get.notifications')}}" style="font-size:12px; text-align:center; padding: 10 30 10 30px;">See all notifications</a>
                    @endif
                  </ul>
                </div><!-- .dropdown -->
              </li>

              <!--<li class="#"><a href="#"><span class="glyphicon glyphicon-th" style="font-size: 18px; margin-top: -5px;" aria-hidden="true"></span></a></li>-->
              <li><div class="dropdown">
              <a class="dropdown-toggle" id="profile-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                @if(Auth::User()->source == 'google')
                  <img id="user-avatar" class="img-responsive img-circle" style="cursor: pointer; height: 35px; width: 35px; margin-left: 40px; margin-top: 7px;" src="{{URL::to(Auth::User()->avatar)}}">
                @else
                  <img id="user-avatar" class="img-responsive img-circle" style="cursor: pointer; height: 35px; width: 35px; margin-left: 40px; margin-top: 7px;" src="{{route('get.avatar', Auth::User()->avatar)}}">
                @endif
              </a>
              <ul class="dropdown-menu" aria-labelledby="profile-list">
                <li><a href="{{route('dashboard', Auth::User()->username)}}">{{Auth::User()->name}}</a></li>
                <li><a href="{{route('dashboard', Auth::User()->school->username)}}">Dashboard</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{route('logout')}}">Logout</a></li>
              </ul>
            </div></li>
            </ul>
            @else
            <ul class="nav navbar-nav navbar-right visible-lg visible-md visible-sm">
              <li><a href="{{route('get.login')}}">Login</a></li>
            </ul>
          @endif
        </div><!--/.nav-collapse -->
      </div><!-- .top navbar -->
      <!--<img class="img-responsive pull-right" style="margin-bottom: -40px; width: 60px; height: 60px;" src="{{ URL::to('src/app/img/resources/plus.png') }}" >-->
    </div><!-- .container -->

  </nav>
  @yield('app-header')
</div><!-- big-header -->
