@extends('layouts.app')
@section('title') Signup @endsection
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
        <li><a href="{{route('home')}}">Back to home</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!-- .container -->
</nav>

<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4 login-container">
      <p>Already registered? <a href="{{route('get.login')}}">Login to your account</a><p>
      <form id="signup-form" action="{{route('post.signup')}}" method="post">
        <div class="form-group">
          <input id="fullName" type="text" class="form-control input-lg" placeholder="Full name">
          <label class="control-label text-danger" id="fullNameError"></label>
        </div>
        <div class="form-group">
          <input id="username" type="text" class="form-control input-lg" placeholder="Username">
          <label class="control-label text-danger" id="usernameError"></label>
        </div>
        <div class="form-group">
          <input id="email" type="text" class="form-control input-lg" placeholder="Email">
          <label class="control-label text-danger" id="emailError"></label>
        </div>
        <div class="form-group">
          <input id="phone" type="number" class="form-control input-lg" placeholder="Phone number">
          <label class="control-label text-danger" id="phoneError"></label>
        </div>
        <div class="form-group">
          <input id="password" type="password" class="form-control input-lg" placeholder="Password">
          <label class="control-label text-danger" id="passwordError"></label>
        </div>
        <input id="request" type="hidden" value="suborah">
        <button id="signupButton" type="submit" class="btn btn-primary btn-block btn-lg">Signup</button>
        {{ csrf_field() }}
      </form><!--
      <p class="text-center">Or</p>
      <div class="g-signin2" data-width="330" data-height="45" style="margin-bottom: 10px;" data-onsuccess="onSignIn"></div>
      -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
</div><!-- .container -->

<script>
  var token = '{{ Session::token() }}';
  var url = '{{ route('post.signup') }}';
  var googleUrl = '{{route('post.google.signup')}}';
</script>
