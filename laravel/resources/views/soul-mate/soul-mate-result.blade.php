@extends('layouts.app')
@section('title') Your soul mate result @endsection

@section('content')
  <style>
    body {
      background-color: #3498db;
    }

    .btn-lg {
      background-color: #2980b9;
    }

    .btn-lg:hover {
      background-color: #3498db;
    }

    .btn-lg:active {
      background-color: #3498db;
    }

    .btn-lg:focus {
      background-color: #3498db;
    }
  </style>
  <div class="container" style="padding-top: 5%">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <h1>Your ALAian soul mate is...</h1>
        <a href="#" id="showSoulMateResult" class="btn btn-primary btn-lg" style="margin-top: 20px;">show result</a>
        <div id="soulMateImage" class="hidden">
        <img class="img-rounded " width="500" height="300" src="{{URL::to('src/img/soulmates/soulmates.jpg')}}">
        <h2>Matching...</h2>
        </div>
        <p class="hidden" id="callToAction" style="font-size: 24px;">
          WOW! your soulmate looks like a really cool person. In order to know him/her please go to
          Amine, Syrine, and Ahmed on thursday FLEX during the community art projects event.<br>
          <img style="margin-top: 10px;" src="{{URL::to('src/img/soulmates/spot.jpg')}}" width="500" height="300" class="img-rounded">
          <br>
          You will find us in this spot.
        </p>
      </div><!-- .col-md-8 -->
    </div><!--- .row -->
  </div><!-- .container -->
@endsection
