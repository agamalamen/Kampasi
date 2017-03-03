<ul class="list-inline header-list" style="font-weight: bold; margin-top: -10px; margin-bottom: 30px;">
  <style>
    .header-list li a{
      margin-right: 30px;
      color: #333;
      font-family: lato;
    }
  </style>
  <li><a href="{{route('dashboard', $school->username)}}">Dashboard</a></li>
  <!--<li><a href="{{route('get.classrooms', $school->username)}}">Classrooms</a></li>-->
  <li><a href="{{route('get.members', ['all'])}}">Members</a></li>
  <li><a href="{{route('dashboard', Auth::User()->username)}}">Profile</a></li>
  <li><a href="{{route('get.notifications')}}">Notifications</a></li>
  <li class="pull-right"><a style="color: #2980b9" href="{{route('get.staffulty')}}">Staffulty</a></li>
</ul>
