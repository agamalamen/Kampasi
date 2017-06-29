@extends('layouts.app')
@section('title') Welcome to Kampasi @endsection
@section('content')


<div class="welcome">
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Kampasi</a><small>Alpha</small>
      </div>
    </div><!-- .container -->
  </nav>

  <!-- home container -->
  <div class="container home-container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h2>Enhancing your campus experience.</h2>
        <div class="home-buttons">
          @if(Auth::User())
          @if(Auth::User()->school_id != 0)
          <a class="btn btn-primary btn-lg" href="{{route('dashboard', Auth::User()->school->username)}}">Go to school</a>
          @else
          <a class="btn btn-primary btn-lg" href="#alien">Join a school</a>
          @endif
          <a class="btn btn-default btn-lg" href="{{route('logout')}}">Logout</a>
          @else
          <a class="btn btn-primary btn-lg" href="{{route('get.login')}}">Login</a>
          <a class="btn btn-default btn-lg" href="{{route('about.us')}}">About us</a>
          <!--<a class="btn btn-default btn-lg" href="{{route('get.signup')}}">Signup</a>-->
          @endif
        </div><!-- .home-buttons -->
      </div><!-- .col-md-8 -->
    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- .welcome -->

<div id="values" class="hr-container">

</div><!-- .hr-conteinar -->

<div class="socialmedia-container">
  <div class="container text-center">
    <ul class="list-inline slideanim">
      <li style="font-family: lato; font-size: 36px; opacity: 0.7">"Stay focused and keep shipping"</li>
    </ul>
  </div><!-- .container -->
</div><!-- .socialmedia-container -->

<footer>
  <p class="text-center">&copy; 2016 All rights reserved. Kampasi</p>
</footer>
@endsection
