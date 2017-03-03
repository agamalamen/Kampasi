@extends('layouts.app')
@section('title') Login @endsection
<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{route('home')}}">Kampasi</a><small>Beta</small>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{route('home')}}">Back to home</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!-- .container -->
</nav>

<div class="container">
  @include('includes.message-block')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 login-container">
      <form id="loginForm" action="{{route('post.login')}}" method="post">
        <div class="form-group">
          <input id="usernameOrEmail" type="text" class="form-control input-lg" placeholder="Username or Email">
          <label class="control-label text-danger" id="usernameOrEmailError"></label>
        </div>
        <div class="form-group">
          <input id="password" type="password" class="form-control input-lg" placeholder="Password">
          <label class="control-label text-danger" id="passwordError"></label>
        </div>
        <div class="checkbox">
          <label style="font-family: lato;">
            <input type="checkbox" id="rememberMe" name="rememberMe" value="1"> Remember me
          </label>
        </div>
        <button id="loginButton" type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
        <label class="control-label text-danger" id="mismatchError"></label>
        {{ csrf_field() }}
      </form>
      <!--<div class="g-signin2" data-width="330" data-height="45" style="margin-bottom: 10px;" data-onsuccess="onSignIn"></div>-->
      <a href="{{route('get.forgot.password')}}">Forgot your password?</a>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
</div><!-- .container -->

<script>
  var token = '{{ Session::token() }}';
  var url = '{{ route('post.login') }}';
  var googleUrl = '{{route('post.google.signup')}}';
</script>
