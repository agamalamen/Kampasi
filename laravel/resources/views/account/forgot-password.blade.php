@extends('layouts.app')
@section('title') Forgot password @endsection
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
  @include('includes.errors-block')
  @include('includes.message-block')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 login-container">
      <form action="{{route('post.forgot.password')}}" method="post">
        <div class="form-group">
          <input type="email" name="email" class="form-control input-lg" placeholder="Email">
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg">Proceed</button>
        {{csrf_field()}}
      </form>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
</div><!-- .container -->
