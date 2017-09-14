@extends('layouts.app')
@section('title') Staffulty Signup @endsection
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
  @include('includes.errors-block')
  @include('includes.message-block')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 login-container">
      <p>Already registered? <a href="{{route('get.login')}}">Login to your account</a><p>
      <form action="{{route('post.staffulty.signup')}}" method="post">
        <div class="form-group">
          <input name="name" type="text" class="form-control input-lg" placeholder="Full name">
        </div>
        <div class="form-group">
          <input name="username" type="text" class="form-control input-lg" placeholder="Username">
        </div>
        <div class="form-group">
          <input name="email" type="text" class="form-control input-lg" placeholder="Email">
        </div>
        <div class="form-group">
          <input name="phone" type="number" class="form-control input-lg" placeholder="Phone number">
        </div>
        <div class="form-group">
          <input name="password" type="password" class="form-control input-lg" placeholder="Password">
        </div>
        <div class="form-group">
          <input name="code" type="text" class="form-control input-lg" placeholder="Code">
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg">Signup</button>
        {{ csrf_field() }}
      </form>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
</div><!-- .container -->

<script>
  var token = '{{ Session::token() }}';
  var url = '{{ route('post.signup') }}';
  var googleUrl = '{{route('post.google.signup')}}';
</script>
