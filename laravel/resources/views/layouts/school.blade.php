<style>
  body {
    background-color: #f4f7fc !important;
  }
</style>
@extends('layouts.app')
@section('content')
  @include('includes.app-navbar')
  <div class="container" style="margin-top: 40px;">
    @include('includes.errors-block')
    @include('includes.message-block')
    @yield('app-list')

    @yield('app-content')
  </div><!-- .container -->

  <footer class="footer no-print" style="margin-top: 50px;">
  <div class="container">
    <div class="row">
      <div class="col-xs-4">
        <ul class="list-unstyled">
          <li style="padding-bottom: 20px;" class="text-muted"><b>TOOLS</b></li>
          <li><a class="text-muted" href="{{route('get.prep', 'all')}}">Prep signup</a></li>
          <li><a class="text-muted" href="{{route('get.feedbacks')}}">Feedback system</a></li>
          <li><a class="text-muted" href="{{route('off.campus', 'all')}}">Off campus</a></li>
        </ul>
      </div><!-- .col-xs-4 -->

      <div class="col-xs-4">
        <ul class="list-unstyled">
          <li style="padding-bottom: 20px;" class="text-muted"><b>HELPFUL</b></li>
          <li ><a class="text-muted" href="{{route('dashboard', 'ala')}}">Dashboard</a></li>
          <li><a class="text-muted" href="{{route('get.notifications')}}">Notifications</a></li>
          <li ><a class="text-muted" href="{{route('get.members', 'all')}}">Members</a></li>
        </ul>
      </div><!-- .col-xs-4 -->

      <div class="col-xs-4">
        <ul class="list-unstyled">
          <li style="padding-bottom: 20px;" class="text-muted"><b>YOU</b></li>
          <li><a class="text-muted" href="{{route('dashboard', Auth::User()->username)}}">Profile</a></li>
          <li ><a class="text-muted" href="{{route('dashboard', Auth::User()->username)}}">Account settings</a></li>
          <li ><a class="text-muted" href="{{route('logout')}}">Logout</a></li>
        </ul>
      </div><!-- .col-xs-4 -->
    </div><!-- .row -->
  </div>
  <ul style="padding-top: 20px;" class="text-center list-inline">
    <li>© 2017 Kampasi</li>
    <li>|</li>
    <li><a href="{{route('get.terms.of.service')}}" class="text-muted">Terms of service</a></li>
    <li>|</li>
    <li><a href="{{route('get.privacy.policy')}}" class="text-muted">Privacy</a></li>
  </ul>
</footer>
@endsection
