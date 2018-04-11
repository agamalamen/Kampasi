@extends('layouts.app')
@section('title') Landing page @endsection
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
  <div class="row text-center" style="padding-top: 20px;">
    <h1 class="text-center">Signup as:</h1>

    <div class="col-md-4 col-md-offset-2">
      <a href="{{route('get.signup')}}" class="btn btn-default btn-lg">Student</a>
    </div><!-- col-md-4 -->

    <div class="col-md-4">
      <a href="{{route('get.staffulty.signup')}}" class="btn btn-primary btn-lg">Staffulty</a>
    </div><!-- col-md-4 -->

  </div><!-- .row -->
</div><!-- .container -->

<script>
  var token = '{{ Session::token() }}';
  var url = '{{ route('post.signup') }}';
  var googleUrl = '{{route('post.google.signup')}}';
</script>
