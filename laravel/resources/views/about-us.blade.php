@extends('layouts.app')
@section('title') Welcome to Kampasi @endsection
@section('content')

@if(Auth::User())
  @include('includes.app-navbar')
@else
<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{route('home')}}">Kampasi</a><small>Alpha</small>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Back to home</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!-- .container -->
</nav>
@endif

<!-- home container -->
<div class="container home-container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div><!-- .col-md-8 -->
  </div><!-- .row -->
</div><!-- .container -->

<div id="values" class="hr-container">

</div><!-- .hr-conteinar -->

<div class="socialmedia-container">
  <div class="container text-center">
    <ul class="list-inline slideanim">
      <li><a href="#"><i class="fa fa-facebook fa-3x"></i></a></li>
      <li><a href="#"><i class="fa fa-twitter fa-3x"></i></a></li>
      <li><a href="#"><i class="fa fa-pinterest fa-3x"></i></a></li>
      <li><a href="#"><i class="fa fa-instagram fa-3x"></i></a></li>
      <li><a href="#"><i class="fa fa-linkedin fa-3x"></i></a></li>
      <li><a href="#"><i class="fa fa-google-plus fa-3x"></i></a></li>
      <li><a href="#"><i class="fa fa-snapchat-ghost fa-3x"></i></a></li>
    </ul>
  </div><!-- .container -->
</div><!-- .socialmedia-container -->

<footer>
  <p class="text-center">&copy; 2016 All rights reserved. Kampasi, inc.</p>
</footer>
@endsection
