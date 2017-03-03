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
  @include('includes.message-block')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 login-container">
      <form action="{{route('post.staffulty')}}" method="post">
        <div class="form-group">
          <p style="font-family: lato;">Switch your account to staffulty mode</p>
          <input name="staffulty_code" type="text" class="form-control input-lg" placeholder="Staffulty code">
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg">Submit</button>
        <label class="control-label text-danger" id="mismatchError"></label>
        {{ csrf_field() }}
      </form>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->
</div><!-- .container -->

<script>
  var token = '{{ Session::token() }}';
  var url = '{{ route('post.login') }}';
  var googleUrl = '{{route('post.google.signup')}}';
</script>
