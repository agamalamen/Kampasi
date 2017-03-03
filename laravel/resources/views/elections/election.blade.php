@extends('layouts.app')
@section('title') {{$election->name}} @endsection

<div style="background-color: white; color: #27ae60; height: 5%; text-align: center;">
  <a id="alaelections" href="{{route('get.elections', ['ala'])}}" style="color: #27ae60"><h1 id="alaelections2016" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px; font-family: lato; font-size: 20px;">ALA <b>Elections</b> of 2016</h1></a>
</div>

<style>
  #alaelections:hover {
    text-decoration: none;
  }

  #alaelections2016:hover {
    color: #2ecc71;
  }

  i {
    color: #95a5a6;
    padding-right: 10px;
    padding-left: 10px;
  }

  i:hover {
    color: #bdc3c7;
  }

</style>

<div class="container" style="margin-top: -30px;">
  <div class="row" style="padding-top: 10%;">
    <div class="col-md-4">
      <div class="panel">
        <div class="panel-header text-center">
          <img src=<?php echo URL::to('src/img/elections/' . $election->id . '.jpg') ?> class="img-circle" style="margin-top: -30px; width: 150px; height: 150px;">
        </div><!-- .panel-heading -->
        <div class="panel-body">
          <h2 class="text-center" style="text-transform: uppercase; font-weight: bold;">{{$election->name}}</h2>
          <h3 class="text-center" style="color: #333; font-size: 20px; margin-top: -5px;">{{$election->position}}</h3>
          <p style="color: #333; padding-top: 5px; text-align: left;">{{$election->summary}}</p>
          @if(Auth::User())
            @if($election->endorsement(Auth::User()->id) == '')
              <a href="{{route('endorse', ['ala', $election->id])}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$election->endorsements->count()}} Endorse</p></a>
            @else
              <b><a href="{{route('endorse', ['ala', $election->id])}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$election->endorsements->count()}} Endorsed</p></a></b>
            @endif
          @else
          <a href="{{route('endorse', ['ala', 0])}}"><p style="display: inline; color: #3498db;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> {{$election->endorsements->count()}} Endorse</p></a>
          @endif
          <p style="display: inline; color: #95a5a6;" class="pull-right"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{$election->views}} views</p>
        </div><!-- .panel-body -->
        <div class="panel-footer">
          <ul class="list-inline text-center">
            <li><a href="{{$election->facebook}}" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a></li>
            <li><a href="{{$election->twitter}}" target="_blank"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a></li>
            <li><a href="{{$election->linkedin}}" target="_blank"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a></li>
          </ul>
        </div><!-- .panel-footer -->
      </div><!-- .panel -->
    </div><!-- .col-md-4 -->
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-body election-information">
          @if($election->intro != '')
            <h4 style="font-size: 24px; font-weight: bold; font-family: lato;">Intro</h4>
            <p>{{$election->intro}}</p>
          @endif
          @if($election->what != '')
            <h4 style="font-size: 24px; font-weight: bold; font-family: lato; padding-top: 20px; ">What?</h4>
            <p><b>What I am going to contribute?</b> {{$election->what}}</p>
          @endif
          @if($election->why != '')
            <h4 style="font-size: 24px; font-weight: bold; font-family: lato; padding-top: 20px; ">Why?</h4>
            <p><b>Why I want to contribute?</b> {{$election->why}}</p>
          @endif
          @if($election->how != '')
            <h4 style="font-size: 24px; font-weight: bold; padding-top: 20px;  font-family: lato;">How?</h4>
            <p><b>How being {{$election->position}} will help me contribute?</b> {{$election->how}}</p>
          @endif
          @if($election->goals != '')
            <h4 style="font-size: 24px; padding-top: 20px;  font-weight: bold; font-family: lato;">Goals</h4>
            <ul>
            @foreach($separatedGoals as $goal)
              <li>{{$goal}}</li>
            @endforeach
            </ul>
          @endif
          @if($election->plans != '')
            <h4 style="font-size: 24px; padding-top: 20px; font-weight: bold; font-family: lato;">Plans</h4>
            <ul>
              @foreach($separatedPlans as $plan)
                <li>{{$plan}}</li>
              @endforeach
            </ul>
          @endif
          @if($election->background != '')
          <h4 style="font-size: 24px; padding-top: 20px; font-weight: bold; font-family: lato;">Background & Experiences</h4>
          <ul>
            @foreach($separatedBackgrounds as $background)
              <li>{{$background}}</li>
            @endforeach
          </ul>
          @endif
          @if($election->strengths != '')
          <h4 style="font-size: 24px; padding-top: 20px; font-weight: bold; font-family: lato;">Strengths</h4>
          <ul>
            @foreach($separatedStrengths as $strength)
              <li>{{$strength}}</li>
            @endforeach
          </ul>
          @endif
        </div><!-- .panel-body -->
      </div><!-- .panel-default -->
    </div><!-- .col-md-8 -->
  </div><!-- .row -->
</div><!-- .container -->

<footer style="margin-top: 5%">
  <p class="text-center">Powered by Ahmed Gamal</p>
</footer>
